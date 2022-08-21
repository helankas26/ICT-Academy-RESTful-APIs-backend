<?php

namespace App\Repositories\Interfaces\Reporting;

use App\Models\Classes;

interface EnrollmentReportRepositoryInterface
{
    /**
     * @param Classes $class
     * @return mixed
     */
    public function getEnrollmentsByClass(Classes $class);
}
