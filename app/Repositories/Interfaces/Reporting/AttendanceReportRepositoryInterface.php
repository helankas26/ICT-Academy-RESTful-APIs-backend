<?php

namespace App\Repositories\Interfaces\Reporting;

use App\Models\Classes;
use Illuminate\Http\Request;

interface AttendanceReportRepositoryInterface
{
    /**
     * @param Request $request
     * @param Classes $class
     * @return mixed
     */
    public function getDailyAttendanceByClass(Request $request, Classes $class);

    /**
     * @param Request $request
     * @param Classes $class
     * @return mixed
     */
    public function getMonthlyAttendanceByClass(Request $request,  Classes $class);

    /**
     * @param Request $request
     * @param Classes $class
     * @return mixed
     */
    public function getDatesByClass(Request $request,  Classes $class);
}
