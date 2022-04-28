<?php

namespace App\Services\Implementation;

use App\Services\Interfaces\IDGeneratorQueryServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class IDGeneratorQueryService implements IDGeneratorQueryServiceInterface
{

    /**
     * @return Collection
     */
    public function getBranchIDs(): Collection
    {
        return $branchIDs = DB::table('branches')->pluck('branchID');

    }

    /**
     * @return Collection
     */
    public function getStaffIDs(): Collection
    {
        return $staffIDs = DB::table('staff')->pluck('staffID');
    }

    /**
     * @return Collection
     */
    public function getTeacherIDs(): Collection
    {
        return $teacherIDs = DB::table('teachers')->pluck('teacherID');
    }

    /**
     * @return Collection
     */
    public function getUserIDs(): Collection
    {
        return $userIDs = DB::table('users')->pluck('userID');
    }

    /**
     * @return Collection
     */
    public function getStudentIDs(): Collection
    {
        return $studentIDs = DB::table('students')->pluck('studentID');
    }

    /**
     * @param string $dob
     * @return Collection
     */
    public function getStudentIDsByDOB(string $dob): Collection
    {
        return $studentIDs = DB::table('people')->where('personType', 'Student')
            ->whereYear('dob', $dob)->pluck('personID');
    }

    /**
     * @return Collection
     */
    public function getCategoryIDs(): Collection
    {
        return $categoryIDs = DB::table('categories')->pluck('categoryID');
    }

    /**
     * @return Collection
     */
    public function getSubjectIDs(): Collection
    {
        return $subjectIDs = DB::table('subjects')->pluck('subjectID');
    }

    /**
     * @return Collection
     */
    public function getClassIDs(): Collection
    {
        return $classIDs = DB::table('classes')->pluck('classID');
    }

    /**
     * @return Collection
     */
    public function getExamIDs(): Collection
    {
        return $examIDs = DB::table('exams')->pluck('examID');
    }
}
