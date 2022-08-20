<?php

namespace App\Repositories\Implementation\Reporting;

use App\Models\Advance;
use App\Models\Employee;
use App\Repositories\Interfaces\Reporting\AdvanceReportRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdvanceReportRepository implements AdvanceReportRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllAdvances(Request $request)
    {
        if ($request->date != null) {
            return Advance::query()
                ->with(['employee', 'staff', 'branch'])
                ->whereYear('date', data_get($request, 'date'))
                ->whereMonth('date', Carbon::make(data_get($request, 'date'))->format('m'))
                ->where('branchID', \request()->header('branchID'))
                ->orderBy('date', 'asc')
                ->get();
        }

        return Advance::query()
            ->with(['employee', 'staff', 'branch'])
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->where('branchID', \request()->header('branchID'))
            ->orderBy('date', 'asc')
            ->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllAdvancesByEmployeeType(Request $request)
    {
        if ($request->date != null) {
            return Advance::query()
                ->with(['employee' => function ($query) use ($request) {
                    $query->where('employeeType', data_get($request, 'employeeType'));
                }, 'staff', 'branch'])
                ->whereHas('employee', function (Builder $query) use ($request) {
                    $query->where('employeeType', data_get($request, 'employeeType'));
                })
                ->whereYear('date', data_get($request, 'date'))
                ->whereMonth('date', Carbon::make(data_get($request, 'date'))->format('m'))
                ->where('branchID', \request()->header('branchID'))
                ->orderBy('date', 'asc')
                ->get();
        }

        return Advance::query()
            ->with(['employee' => function ($query) use ($request) {
                $query->where('employeeType', data_get($request, 'employeeType'));
            }, 'staff', 'branch'])
            ->whereHas('employee', function (Builder $query) use ($request) {
                $query->where('employeeType', data_get($request, 'employeeType'));
            })
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->where('branchID', \request()->header('branchID'))
            ->orderBy('date', 'asc')
            ->get();
    }

    /**
     * @param Request $request
     * @param Employee $employee
     * @return mixed
     */
    public function getAdvanceByEmployee(Request $request, Employee $employee)
    {
        if ($request->date != null) {
            return Employee::query()
                ->with(['person',
                    'advances' => function ($query) use ($request) {
                    $query->whereYear('date', data_get($request, 'date'))
                        ->whereMonth('date', Carbon::make(data_get($request, 'date'))->format('m'))
                        ->where('branchID', \request()->header('branchID'))
                        ->orderBy('date', 'asc');
                }])->where('employeeType', data_get($request, 'employeeType'))
                ->find($employee->employeeID);
        }

        return Employee::query()
            ->with(['person',
                'advances' => function ($query) {
                    $query->whereYear('date', Carbon::now()->year)
                        ->whereMonth('date', Carbon::now()->month)
                        ->where('branchID', \request()->header('branchID'))
                        ->orderBy('date', 'asc');
            }])->where('employeeType', data_get($request, 'employeeType'))
            ->find($employee->employeeID);
    }
}
