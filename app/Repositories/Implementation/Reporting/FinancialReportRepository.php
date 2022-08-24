<?php

namespace App\Repositories\Implementation\Reporting;

use App\Models\Advance;
use App\Models\Employee;
use App\Models\Expenditure;
use App\Models\Fee;
use App\Models\Staff;
use App\Models\Teacher;
use App\Repositories\Interfaces\Reporting\FinancialReportRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FinancialReportRepository implements FinancialReportRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getDailyTransaction(Request $request)
    {
        if ($request->date != null) {
            $fees = Fee::query()
                ->where('date', data_get($request, 'date'))
                ->where('branchID', \request()->header('branchID'))
                ->get();

            $advances = Advance::query()
                ->where('date', data_get($request, 'date'))
                ->where('branchID', \request()->header('branchID'))
                ->get();

            $expenditures = Expenditure::query()
                ->where('date', data_get($request, 'date'))
                ->where('branchID', \request()->header('branchID'))
                ->get();

            return $this->extracted($fees, $advances, $expenditures);
        }

        $fees = Fee::query()
            ->where('date', Carbon::now()->format('Y-m-d'))
            ->where('branchID', \request()->header('branchID'))
            ->get();

        $advances = Advance::query()
            ->where('date', Carbon::now()->format('Y-m-d'))
            ->where('branchID', \request()->header('branchID'))
            ->get();

        $expenditures = Expenditure::query()
            ->where('date', Carbon::now()->format('Y-m-d'))
            ->where('branchID', \request()->header('branchID'))
            ->get();

        return $this->extracted($fees, $advances, $expenditures);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getMonthlyTransaction(Request $request)
    {
        if ($request->date != null) {
            $fees = Fee::query()
                ->whereYear('date', data_get($request, 'date'))
                ->whereMonth('date', Carbon::make(data_get($request, 'date'))->format('m'))
                ->where('branchID', \request()->header('branchID'))
                ->get();

            $advances = Advance::query()
                ->whereYear('date', data_get($request, 'date'))
                ->whereMonth('date', Carbon::make(data_get($request, 'date'))->format('m'))
                ->where('branchID', \request()->header('branchID'))
                ->get();

            $expenditures = Expenditure::query()
                ->whereYear('date', data_get($request, 'date'))
                ->whereMonth('date', Carbon::make(data_get($request, 'date'))->format('m'))
                ->where('branchID', \request()->header('branchID'))
                ->get();

            return $this->extracted($fees, $advances, $expenditures);
        }

        $fees = Fee::query()
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->where('branchID', \request()->header('branchID'))
            ->get();

        $advances = Advance::query()
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->where('branchID', \request()->header('branchID'))
            ->get();

        $expenditures = Expenditure::query()
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->where('branchID', \request()->header('branchID'))
            ->get();

        return $this->extracted($fees, $advances, $expenditures);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getYearlyTransaction(Request $request)
    {
        if ($request->date != null) {
            $fees = Fee::query()
                ->whereYear('date', data_get($request, 'date'))
                ->where('branchID', \request()->header('branchID'))
                ->get();

            $advances = Advance::query()
                ->whereYear('date', data_get($request, 'date'))
                ->where('branchID', \request()->header('branchID'))
                ->get();

            $expenditures = Expenditure::query()
                ->whereYear('date', data_get($request, 'date'))
                ->where('branchID', \request()->header('branchID'))
                ->get();

            return $this->extracted($fees, $advances, $expenditures);
        }

        $fees = Fee::query()
            ->whereYear('date', Carbon::now()->year)
            ->where('branchID', \request()->header('branchID'))
            ->get();

        $advances = Advance::query()
            ->whereYear('date', Carbon::now()->year)
            ->where('branchID', \request()->header('branchID'))
            ->get();

        $expenditures = Expenditure::query()
            ->whereYear('date', Carbon::now()->year)
            ->where('branchID', \request()->header('branchID'))
            ->get();

        return $this->extracted($fees, $advances, $expenditures);
    }

    /**
     * @param Request $request
     * @param Staff $staff
     * @return mixed
     */
    public function getStaffPaymentsById(Request $request, Staff $staff)
    {
        // TODO: Implement getStaffPaymentsById() method.
    }

    /**
     * @param Request $request
     * @param Teacher $teacher
     * @return mixed
     */
    public function getTeacherDailyPaymentsById(Request $request, Teacher $teacher)
    {
        if ($request->date != null) {
            return Teacher::query()
                ->with([
                    'employee.person',
                    'classes' => function ($query) use ($request) {
                        $query->where('status', 'Active')
                            ->where('feeType', 'Daily')
                            ->where('branchID', \request()->header('branchID'));
                    },
                    'classes.fees' => function ($query) use ($request) {
                        $query->where('date', data_get($request, 'date'))
                            ->where('branchID', \request()->header('branchID'));
                    },
                ])->find($teacher->teacherID);
        }

        return Teacher::query()
            ->with([
                'employee.person',
                'classes' => function ($query) use ($request) {
                    $query->where('status', 'Active')
                        ->where('feeType', 'Daily')
                        ->where('branchID', \request()->header('branchID'));
                },
                'classes.fees' => function ($query) use ($request) {
                    $query->where('date',  Carbon::now()->format('Y-m-d'))
                        ->where('branchID', \request()->header('branchID'));
                },
            ])->find($teacher->teacherID);
    }

    /**
     * @param Request $request
     * @param Teacher $teacher
     * @return mixed
     */
    public function getTeacherMonthlyPaymentsById(Request $request, Teacher $teacher)
    {
        if ($request->date != null) {
            return Teacher::query()
                ->with([
                    'employee.person',
                    'classes' => function ($query) use ($request) {
                        $query->where('status', 'Active')
                            ->where('branchID', \request()->header('branchID'));
                    },
                    'classes.fees' => function ($query) use ($request) {
                        $query->whereYear('date', data_get($request, 'date'))
                            ->whereMonth('date', Carbon::make(data_get($request, 'date'))->format('m'))
                            ->where('branchID', \request()->header('branchID'));
                    },
                ])->find($teacher->teacherID);
        }

        return Teacher::query()
            ->with([
                'employee.person',
                'classes' => function ($query) use ($request) {
                    $query->where('status', 'Active')
                        ->where('branchID', \request()->header('branchID'));
                },
                'classes.fees' => function ($query) use ($request) {
                    $query->whereYear('date', Carbon::now()->year)
                        ->whereMonth('date', Carbon::now()->month)
                        ->where('branchID', \request()->header('branchID'));
                },
            ])->find($teacher->teacherID);
    }

    /**
     * @param Request $request
     * @param Teacher $teacher
     * @return mixed
     */
    public function getTeacherTargetById(Request $request, Teacher $teacher)
    {
        // TODO: Implement getTeacherTargetById() method.
    }

    /**
     * @param Request $request
     * @param Teacher $teacher
     * @return mixed
     */
    public function getDailyAdvanceByEmployee(Request $request, Teacher $teacher)
    {
        if ($request->date != null) {
            return Employee::query()
                ->with([
                    'advances' => function ($query) use ($request) {
                        $query->where('date', data_get($request, 'date'))
                            ->where('branchID', \request()->header('branchID'))
                            ->orderBy('date', 'asc');
                    }])
                ->find($teacher->teacherID);
        }

        return Employee::query()
            ->with([
                'advances' => function ($query) {
                    $query->where('date', Carbon::now()->format('Y-m-d'))
                        ->where('branchID', \request()->header('branchID'))
                        ->orderBy('date', 'asc');
                }])->find($teacher->teacherID);
    }

    /**
     * @param Request $request
     * @param $employee
     * @return mixed
     */
    public function getMonthlyAdvanceByEmployee(Request $request, $employee)
    {
        if ($request->date != null) {
            return Employee::query()
                ->with([
                    'advances' => function ($query) use ($request) {
                        $query->whereYear('date', data_get($request, 'date'))
                            ->whereMonth('date', Carbon::make(data_get($request, 'date'))->format('m'))
                            ->where('branchID', \request()->header('branchID'))
                            ->orderBy('date', 'asc');
                    }])
                ->find($employee);
        }

        return Employee::query()
            ->with([
                'advances' => function ($query) {
                    $query->whereYear('date', Carbon::now()->year)
                        ->whereMonth('date', Carbon::now()->month)
                        ->where('branchID', \request()->header('branchID'))
                        ->orderBy('date', 'asc');
                }])->find($employee);
    }

    /**
     * @param mixed $fees
     * @param mixed $advances
     * @param mixed $expenditures
     * @return mixed
     */
    protected function extracted(mixed $fees, mixed $advances, mixed $expenditures)
    {
        $transactions['fees'] = $fees;
        $transactions['advances'] = $advances;
        $transactions['expenditures'] = $expenditures;

        return $transactions;
    }
}
