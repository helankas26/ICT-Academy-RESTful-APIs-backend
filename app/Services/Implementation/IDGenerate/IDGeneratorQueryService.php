<?php

namespace App\Services\Implementation\IDGenerate;

use App\Services\Interfaces\IDGenerate\IDGeneratorQueryServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class IDGeneratorQueryService implements IDGeneratorQueryServiceInterface
{

    /**
     * @return Collection
     */
    public function getBranchIDs(): Collection
    {
        return DB::table('branches')->pluck('branchID');

    }

    /**
     * @return Collection
     */
    public function getStaffIDs(): Collection
    {
        return DB::table('staff')->pluck('staffID');
    }

    /**
     * @return Collection
     */
    public function getTeacherIDs(): Collection
    {
        return DB::table('teachers')->pluck('teacherID');
    }

    /**
     * @return Collection
     */
    public function getUserIDs(): Collection
    {
        return DB::table('users')->pluck('userID');
    }

    /**
     * @return Collection
     */
    public function getStudentIDs(): Collection
    {
        return DB::table('students')->pluck('studentID');
    }

    /**
     * @param string $dob
     * @return Collection
     */
    public function getStudentIDsByDOB(string $dob): Collection
    {
        return DB::table('people')->where('personType', 'Student')
            ->whereYear('dob', $dob)->pluck('personID');
    }

    /**
     * @return Collection
     */
    public function getCategoryIDs(): Collection
    {
        return DB::table('categories')->pluck('categoryID');
    }

    /**
     * @return Collection
     */
    public function getSubjectIDs(): Collection
    {
        return DB::table('subjects')->pluck('subjectID');
    }

    /**
     * @return Collection
     */
    public function getClassIDs(): Collection
    {
        return DB::table('classes')->pluck('classID');
    }

    /**
     * @return Collection
     */
    public function getExamIDs(): Collection
    {
        return DB::table('exams')->pluck('examID');
    }
}
