<?php

namespace App\Repositories\Implementation;

use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\UpdateEnrollmentRequest;
use App\Models\Classes;
use App\Models\Enrollment;
use App\Models\Student;
use App\Repositories\Interfaces\EnrollmentRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class EnrollmentRepository implements EnrollmentRepositoryInterface
{
    /**
     * @return mixed
     * @throws Exception
     */
    public function getAllStudentsEnrollments()
    {
        $enrollments = Student::query()->has('classes')->with(['classes', 'person'])->get();

        if ($enrollments->isEmpty()){
            throw new Exception('Failed to retrieve Enrollment of Students');
        }

        return $enrollments;
    }

    /**
     * @return mixed
     */
    public function getStudentsNotInFreeCard()
    {
        $enrollment = Enrollment::query()
            ->whereNot('paymentStatus', -1)
            ->distinct()
            ->pluck('studentID');

        return Student::query()->with('person')->findMany($enrollment);
    }

    /**
     * @return mixed
     */
    public function getStudentsInFreeCard()
    {
        $enrollment = Enrollment::query()
            ->where('paymentStatus', -1)
            ->distinct()
            ->pluck('studentID');

        return Student::query()->with('person')->findMany($enrollment);
    }

    /**
     * @param StoreEnrollmentRequest $request
     * @return mixed
     * @throws Throwable
     */
    public function attachStudentEnrollments(StoreEnrollmentRequest $request)
    {
        return DB::transaction(function () use ($request) {

            $student = Student::query()->find(data_get($request, 'studentID'));

            $student->classes()->attach(data_get($request, 'classID'), [
                'enrolledDate' => Carbon::now()->format('Y-m-d')
            ]);

            return $student;
        });
    }

    /**
     * @param Student $student
     * @return mixed
     */
    public function getStudentEnrollmentsById(Student $student)
    {
        return Student::query()->with('classes', 'person')->find($student);
    }

    /**
     * @param UpdateEnrollmentRequest $request
     * @param Student $student
     * @param Classes $class
     * @return mixed
     */
    public function updateStudentFreeClass(UpdateEnrollmentRequest $request, Student $student, Classes $class)
    {
        $student = Student::query()->find($student->studentID);

        $class = Classes::query()->find($class->classID);

        $student->classes()->updateExistingPivot($class, [
            'paymentStatus' => data_get($request, 'paymentStatus')
        ]);

        return $student;
    }

    /**
     * @param UpdateEnrollmentRequest $request
     * @param Student $student
     * @param Classes $class
     * @return mixed
     */
    public function updateStudentStatus(UpdateEnrollmentRequest $request, Student $student, Classes $class)
    {
        $student = Student::query()->find($student->studentID);

        $class = Classes::query()->find($class->classID);

        $student->classes()->updateExistingPivot($class, [
            'status' => data_get($request, 'status')
        ]);

        return $student;
    }

    /**
     * @param UpdateEnrollmentRequest $request
     * @param Student $student
     * @return mixed
     * @throws Throwable
     */
    public function updateStudentStatusForAll(UpdateEnrollmentRequest $request, Student $student)
    {
        return DB::transaction(function () use ($request, $student) {

            $student = Student::query()->find($student->studentID);

            $student->classes()->newPivotStatement()->where('enrollment.studentID', $student->studentID)
                ->update([
                    'status' => data_get($request, 'status')
                ]);

            return $student;
        });
    }

    /**
     * @param UpdateEnrollmentRequest $request
     * @param Student $student
     * @param Classes $class
     * @return mixed
     */
    public function updateDailyClassPaidStatus(UpdateEnrollmentRequest $request, Student $student, Classes $class)
    {
        $student->classes()
            ->where('enrollment.classID', $class->classID)
            ->where('enrollment.status', '1')
            ->whereNot('enrollment.paymentStatus', '0')
            ->decrement('paymentStatus', data_get($request, 'decrement', 1));

        return $student;
    }

    /**
     * @param UpdateEnrollmentRequest $request
     * @param Student $student
     * @return void
     * @throws Throwable
     */
    public function updateMonthlyClassPaidStatus(UpdateEnrollmentRequest $request, Student $student)
    {
        DB::transaction(function () use ($request, $student) {

            foreach ($request->classes as $class) {
                $student->classes()
                    ->where('enrollment.classID', data_get($class, 'classID'))
                    ->where('enrollment.status', '1')
                    ->whereNot('enrollment.paymentStatus', '0')
                    ->decrement('paymentStatus', data_get($class, 'decrement', 1));
            }
        });
    }

    /**
     * @param Request $request
     * @param Student $student
     * @return mixed
     * @throws Exception
     */
    public function detachStudentEnrollments(Request $request, Student $student)
    {
        $student = Student::query()->find($student->studentID);

        $deleted =  $student->classes()->detach(data_get($request, 'classID'));

        if (!$deleted){
            throw new Exception('Failed to detach Enrollment of: ' . $student->studentID);
        }

        return $deleted;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getAllClassesEnrollments()
    {
        $enrollments = Classes::query()->has('students')->with(['students', 'students.person'])->get();

        if ($enrollments->isEmpty()){
            throw new Exception('Failed to retrieve Enrollment of Classes');
        }

        return $enrollments;
    }

    /**
     * @param StoreEnrollmentRequest $request
     * @return mixed
     * @throws Throwable
     */
    public function attachClassEnrollments(StoreEnrollmentRequest $request)
    {
        return DB::transaction(function () use ($request) {

            $class = Classes::query()->find(data_get($request, 'classID'));

            $class->students()->attach(data_get($request, 'studentID'), [
                'enrolledDate' => Carbon::now()->format('Y-m-d')
            ]);

            return $class;
        });
    }

    /**
     * @param Classes $class
     * @return mixed
     */
    public function getClassEnrollmentsById(Classes $class)
    {
        return Classes::query()->with('students', 'students.person')->find($class);
    }

    /**
     * @param Classes $class
     * @return mixed
     * @throws Exception
     */
    public function getStudentsNotInClass(Classes $class)
    {
        $enrollment = Enrollment::query()->where('classID', $class->classID)->pluck('studentID');

        $students = Student::query()->with('person')
            ->join('people', 'students.studentID', 'people.personID')
            ->where('people.status', 'Active')
            ->whereNotIn('studentID', $enrollment)
            ->get();

        if ($students->isEmpty()){
            throw new Exception('Failed to retrieve Students');
        }

        return $students;
    }

    /**
     * @param Classes $class
     * @param Student $student
     * @return mixed
     */
    public function updateDailyClassPaymentStatus(Classes $class, Student $student)
    {
        $class->students()
            ->where('enrollment.studentID', $student->studentID)
            ->where('enrollment.status', '1')
            ->whereNot('enrollment.paymentStatus', '-1')
            ->increment('paymentStatus');

        return $class;
    }

    /**
     * @return mixed
     * @throws Throwable
     */
    public function updateMonthlyClassesPaymentStatus()
    {
        return DB::transaction(function () {

            $classes = Classes::query()->where('feeType', 'Monthly')
                ->where('status', 'Active')
                ->get();

            foreach ($classes as $class) {
                $class->students()
                    ->where('enrollment.status', '1')
                    ->whereNot('enrollment.paymentStatus', '-1')
                    ->increment('paymentStatus');
            }

            return $classes;
        });
    }

    /**
     * @param UpdateEnrollmentRequest $request
     * @param Classes $class
     * @return mixed
     * @throws Throwable
     */
    public function updateClassStatusForAll(UpdateEnrollmentRequest $request, Classes $class)
    {
        return DB::transaction(function () use ($request, $class) {

            $class = Classes::query()->find($class->classID);

            $class->students()->newPivotStatement()->where('enrollment.classID', $class->classID)
                ->update([
                    'status' => data_get($request, 'status')
                ]);

            return $class;
        });
    }

    /**
     * @param Request $request
     * @param Classes $class
     * @return mixed
     * @throws Exception
     */
    public function detachClassEnrollments(Request $request, Classes $class)
    {
        $class = Classes::query()->find($class->classID);

        $deleted =  $class->students()->detach(data_get($request, 'studentID'));

        if (!$deleted){
            throw new Exception('Failed to detach Enrollment of: ' . $class->classID);
        }

        return $deleted;
    }
}
