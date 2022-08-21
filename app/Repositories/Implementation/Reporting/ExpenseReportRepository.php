<?php

namespace App\Repositories\Implementation\Reporting;

use App\Models\Branch;
use App\Models\Expenditure;
use App\Repositories\Interfaces\Reporting\ExpenseReportRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ExpenseReportRepository implements ExpenseReportRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function getAllExpenses(Request $request)
    {
        if ($request->date != null) {
            return Expenditure::query()
                ->with(['staff.employee.person', 'branch'])
                ->whereYear('date', data_get($request, 'date'))
                ->whereMonth('date', Carbon::make(data_get($request, 'date'))->format('m'))
                ->orderBy('date', 'asc')
                ->get();
        }

        return Expenditure::query()
            ->with(['staff.employee.person', 'branch'])
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->orderBy('date', 'asc')
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getExpenseByBranch(Request $request, Branch $branch)
    {
        if ($request->date != null) {
            return Branch::query()
                ->with(['expenditures.staff.employee.person',
                    'expenditures' => function ($query) use ($request) {
                        $query->whereYear('date', data_get($request, 'date'))
                            ->whereMonth('date', Carbon::make(data_get($request, 'date'))->format('m'))
                            ->orderBy('date', 'asc');
                }])->find($branch->branchID);
        }

        return Branch::query()
            ->with(['expenditures.staff.employee.person',
                'expenditures' => function ($query) use ($request) {
                    $query->whereYear('date', Carbon::now()->year)
                        ->whereMonth('date', Carbon::now()->month)
                        ->orderBy('date', 'asc');
                }])->find($branch->branchID);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getTotalExpensesForBranch(Request $request)
    {
        if ($request->date != null) {
            return Expenditure::query()
                ->select('branchID', DB::raw('sum(expenseAmount) as totalAmount'))
                ->with('branch:branchID,branchName')
                ->whereYear('date', data_get($request, 'date'))
                ->whereMonth('date', Carbon::make(data_get($request, 'date'))->format('m'))
                ->groupBy('branchID')
                ->get();
        }

        return Expenditure::query()
            ->select('branchID', DB::raw('sum(expenseAmount) as totalAmount'))
            ->with('branch:branchID,branchName')
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->groupBy('branchID')
            ->get();
    }
}
