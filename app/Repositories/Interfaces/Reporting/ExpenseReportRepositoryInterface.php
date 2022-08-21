<?php

namespace App\Repositories\Interfaces\Reporting;

use App\Models\Branch;
use Illuminate\Http\Request;

interface ExpenseReportRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllExpenses(Request $request);

    /**
     * @param Request $request
     * @param Branch $branch
     * @return mixed
     */
    public function getExpenseByBranch(Request $request, Branch $branch);

    /**
     * @param Request $request
     * @return mixed
     */
    public function getTotalExpensesForBranch(Request $request);
}
