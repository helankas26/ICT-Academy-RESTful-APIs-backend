<?php

namespace App\Repositories\Interfaces\Reporting;

use App\Models\Staff;
use App\Models\Teacher;
use Illuminate\Http\Request;

interface FinancialReportRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getDailyTransaction(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function getMonthlyTransaction(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function getYearlyTransaction(Request $request);

    /**
     * @param Request $request
     * @param Staff $staff
     * @return mixed
     */
    public function getStaffPaymentsById(Request $request, Staff $staff);

    /**
     * @param Request $request
     * @param Teacher $teacher
     * @return mixed
     */
    public function getTeacherDailyPaymentsById(Request $request, Teacher $teacher);

    /**
     * @param Request $request
     * @param Teacher $teacher
     * @return mixed
     */
    public function getTeacherMonthlyPaymentsById(Request $request, Teacher $teacher);

    /**
     * @param Request $request
     * @param Teacher $teacher
     * @return mixed
     */
    public function getTeacherTargetById(Request $request, Teacher $teacher);

    /**
     * @param Request $request
     * @param Teacher $teacher
     * @return mixed
     */
    public function getDailyAdvanceByEmployee(Request $request, Teacher $teacher);

    /**
     * @param Request $request
     * @param $employee
     * @return mixed
     */
    public function getMonthlyAdvanceByEmployee(Request $request, $employee);
}
