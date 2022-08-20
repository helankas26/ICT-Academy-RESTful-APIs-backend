<?php

namespace App\Repositories\Interfaces\Reporting;

use App\Models\Employee;
use Illuminate\Http\Request;

interface AdvanceReportRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllAdvances(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllAdvancesByEmployeeType(Request $request);

    /**
     * @param Request $request
     * @param Employee $employee
     * @return mixed
     */
    public function getAdvanceByEmployee(Request $request, Employee $employee);
}
