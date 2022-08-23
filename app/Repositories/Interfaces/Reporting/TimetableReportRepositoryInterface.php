<?php

namespace App\Repositories\Interfaces\Reporting;

use App\Models\Branch;
use Illuminate\Http\Request;

interface TimetableReportRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getTimetable();

    /**
     * @return mixed
     */
    public function getTimetableByBranch(Request $request, Branch $branch);

    /**
     * @param Request $request
     * @return mixed
     */
    public function getTimetableByDay(Request $request);

    /**
     * @return mixed
     */
    public function getAllBranches();
}
