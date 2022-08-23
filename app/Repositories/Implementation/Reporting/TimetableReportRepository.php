<?php

namespace App\Repositories\Implementation\Reporting;

use App\Models\Branch;
use App\Models\Teacher;
use App\Repositories\Interfaces\Reporting\TimetableReportRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TimetableReportRepository implements TimetableReportRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getTimetable()
    {
        return Teacher::query()
            ->with([
                'employee.person', 'classes.subject.category', 'classes.branch',
                'classes' => function ($query) {
                    $query->where('status', 'Active');
                }
            ])->whereHas('employee.person', function (Builder $query) {
                $query->where('status', 'Active');
            })->whereHas('classes', function (Builder $query) {
                $query->where('status', 'Active');
            })->get();
    }

    /**
     * @param Request $request
     * @param Branch $branch
     * @return mixed
     */
    public function getTimetableByBranch(Request $request, Branch $branch)
    {
        return Teacher::query()
            ->with([
                'employee.person', 'classes.subject.category', 'classes.branch',
                'classes' => function ($query) use ($request, $branch) {
                    $query->where('status', data_get($request, 'status'))
                        ->where('branchID', $branch->branchID);
                }
            ])->whereHas('employee.person', function (Builder $query) {
                $query->where('status', 'Active');
            })->whereHas('classes', function (Builder $query) use ($request, $branch) {
                $query->where('status', data_get($request, 'status'))
                    ->where('branchID', $branch->branchID);
            })->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getTimetableByDay(Request $request)
    {
        return Teacher::query()
            ->with([
                'employee.person', 'classes.subject.category', 'classes.branch',
                'classes' => function ($query) use ($request) {
                    $query->where('status', 'Active')
                        ->where('day', data_get($request, 'day'))
                        ->where('branchID', \request()->header('branchID'));
                }
            ])->whereHas('employee.person', function (Builder $query) {
                $query->where('status', 'Active');
            })->whereHas('classes', function (Builder $query) use ($request) {
                $query->where('status', 'Active')
                    ->where('day', data_get($request, 'day'))
                    ->where('branchID', \request()->header('branchID'));
            })->get();
    }

    /**
     * @return mixed
     */
    public function getAllBranches()
    {
        return Branch::query()->get();
    }
}
