<?php

namespace App\Repositories\Implementation\Reporting;

use App\Models\Classes;
use App\Repositories\Interfaces\Reporting\RegisterReportRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class RegisterReportRepository implements RegisterReportRepositoryInterface
{
    /**
     * @param Classes $class
     * @return mixed
     */
    public function getEnrollmentsByClass(Classes $class)
    {
        return Classes::query()->with(['subject', 'category', 'teacher.employee.person', 'branch', 'students.person'])
            ->withCount([
                'students as active_count' => function (Builder $query) {
                    $query->where('enrollment.status', 1);
                },
                'students as deactivate_count' => function (Builder $query) {
                    $query->where('enrollment.status', 0);
                },
                'students as fixed_students' => function (Builder $query) {
                    $query->whereNot('enrollment.paymentStatus', -1);
                },
                'students as free_students' => function (Builder $query) {
                    $query->where('enrollment.paymentStatus', -1);
                },
                'students'
            ])->find($class->classID);
    }
}
