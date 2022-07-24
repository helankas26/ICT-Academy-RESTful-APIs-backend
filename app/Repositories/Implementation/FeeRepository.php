<?php

namespace App\Repositories\Implementation;

use App\Http\Requests\StoreFeeRequest;
use App\Http\Requests\UpdateFeeRequest;
use App\Models\Classes;
use App\Models\Fee;
use App\Models\Student;
use App\Repositories\Interfaces\FeeRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class FeeRepository implements FeeRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllFees(Request $request)
    {
        if ($request->date != null) {
            return Fee::query()
                ->with(['student.person', 'class', 'staff.employee.person', 'branch'])
                ->whereYear('date', data_get($request, 'date'))
                ->get();
        }

        return Fee::query()
            ->with(['student.person', 'class', 'staff.employee.person', 'branch'])
            ->whereYear('date', Carbon::now()->year)
            ->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllTrashedFees(Request $request)
    {
        if ($request->date != null) {
            return Fee::onlyTrashed()
                ->with(['student.person', 'class', 'staff.employee.person', 'branch'])
                ->whereYear('date', data_get($request, 'date'))
                ->get();
        }

        return Fee::onlyTrashed()
            ->with(['student.person', 'class', 'staff.employee.person', 'branch'])
            ->whereYear('date', Carbon::now()->year)
            ->get();
    }

    /**
     * @param StoreFeeRequest $request
     * @param Student $student
     * @param Classes $class
     * @return mixed
     * @throws Throwable
     */
    public function payForOneClass(StoreFeeRequest $request, Student $student, Classes $class)
    {
        $student = Student::query()->find($student->studentID);

        $payments = array();
        $count = 1;

        foreach ($request->amounts as $amount) {
            $payments[] = [
                'classID' => $class->classID,
                'paidAmount' => data_get($amount, 'paidAmount'),
                'date' => data_get($request, 'date', Carbon::now()->format('Y-m-d')),
                'paidStatus' => $count >= $request->paymentStatus ? 'P' : 'A',
                'handlerStaffID' => data_get($request, 'handlerStaffID'),
                'branchID' => data_get($request, 'branchID')
            ];

            ++$count;
        }

        return DB::transaction(function () use ($student, $payments) {
            return $student->fees()->createMany($payments);
        });
    }

    /**
     * @param StoreFeeRequest $request
     * @param Student $student
     * @return mixed
     * @throws Throwable
     */
    public function payForManyClasses(StoreFeeRequest $request, Student $student)
    {
        $student = Student::query()->find($student->studentID);

        $payments = array();
        $count = 1;

        foreach ($request->classes as $class) {
            foreach (data_get($class, 'amounts') as $amount) {
                $payments[] = [
                    'classID' => data_get($class, 'classID'),
                    'paidAmount' => data_get($amount, 'paidAmount'),
                    'date' => data_get($request, 'date', Carbon::now()->format('Y-m-d')),
                    'paidStatus' => $count >= data_get($class, 'paymentStatus') ? 'P' : 'A',
                    'handlerStaffID' => data_get($request, 'handlerStaffID'),
                    'branchID' => data_get($request, 'branchID')
                ];

                ++$count;
            }

            $count = 1;
        }

        return DB::transaction(function () use ($student, $payments) {
            return $student->fees()->createMany($payments);
        });
    }

    /**
     * @param $feeID
     * @return mixed
     */
    public function trashedRestore($feeID)
    {
        $fee = Fee::withTrashed()->findOrFail($feeID);

        return $fee->trashed() ? $fee->restore() : false;
    }

    /**
     * @param Fee $fee
     * @return mixed
     */
    public function getFeeById(Fee $fee)
    {
        return Fee::query()
            ->with(['student.person', 'class', 'staff.employee.person', 'branch'])
            ->find($fee->feeID);
    }

    /**
     * @param UpdateFeeRequest $request
     * @param Fee $fee
     * @return mixed
     * @throws Exception
     */
    public function updateFee(UpdateFeeRequest $request, Fee $fee)
    {
        $updated = $fee->update([
            'studentID' => data_get($request, 'studentID', $fee->studentID),
            'classID' => data_get($request, 'classID', $fee->classID),
            'paidAmount' => data_get($request, 'paidAmount', $fee->paidStatus),
            'date' => data_get($request, 'date', $fee->date),
            'paidStatus' => data_get($request, 'paidStatus', $fee->paidStatus),
            'handlerStaffID' => data_get($request, 'handlerStaffID', $fee->handlerStaffID),
            'branchID' => data_get($request, 'branchID', $fee->branchID)
        ]);

        if (!$updated){
            throw new Exception('Failed to update fee: ' . $fee->feeID);
        }

        return $fee;
    }

    /**
     * @param Fee $fee
     * @return mixed
     * @throws Exception
     */
    public function softDeleteFee(Fee $fee)
    {
        $deleted = $fee->delete();

        if (!$deleted){
            throw new Exception('Failed to soft delete fee: ' . $fee->feeID);
        }

        return $deleted;
    }

    /**
     * @param $feeID
     * @return mixed
     */
    public function forceDeleteFee($feeID)
    {
        $fee = Fee::withTrashed()->findOrFail($feeID);

        return $fee->trashed() ? $fee->forceDelete() : false;
    }
}
