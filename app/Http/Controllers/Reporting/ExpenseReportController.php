<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenditureResource;
use App\Http\Resources\Reporting\ExpenseReportResource;
use App\Models\Branch;
use App\Repositories\Interfaces\Reporting\ExpenseReportRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ExpenseReportController extends Controller
{
    /**
     * @var ExpenseReportRepositoryInterface
     */
    private ExpenseReportRepositoryInterface $expenseReportRepository;

    /**
     * @param ExpenseReportRepositoryInterface $expenseReportRepository
     */
    public function __construct(ExpenseReportRepositoryInterface $expenseReportRepository)
    {
        $this->expenseReportRepository = $expenseReportRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate([
           'date' => ['nullable', 'date']
        ]);

        $expenses = $this->expenseReportRepository->getAllExpenses($request);
        $total_expenses = $this->expenseReportRepository->getTotalExpensesForBranch($request);

        $total = 0;

        foreach ($expenses as $expense) {
            $total += $expense->expenseAmount;
        }

        return new JsonResponse([
            'success' => true,
            'advances' => ExpenditureResource::collection($expenses),
            'meta' => [
                'expense_count' => $expenses->count(),
                'branchTotalAmount' => $total_expenses,
                'total' => number_format($total, 2),
                'date' => Carbon::make($request->date)->format('Y F'),
                'printedBy' => \request()->header('employeeName'),
                'printedDate' => Carbon::now()->format('Y-m-d h:i A'),
            ],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function indexByBranch(Request $request, Branch $branch)
    {
        $request->validate([
            'date' => ['nullable', 'date']
        ]);

        $branch = $this->expenseReportRepository->getExpenseByBranch($request, $branch);

        $total = 0;

        foreach ($branch->expenditures as $expenditure) {
            $total += $expenditure->expenseAmount;
        }

        return new JsonResponse([
            'success' => true,
            'branchID' => $branch->branchID,
            'branchName' => $branch->branchName,
            'address' => $branch->address,
            'expenses' => ExpenseReportResource::collection($branch->expenditures),
            'meta' => [
                'expense_count' => $branch->expenditures->count(),
                'total' => number_format($total, 2),
                'date' => Carbon::make($request->date)->format('Y F'),
                'printedBy' => \request()->header('employeeName'),
                'printedDate' => Carbon::now()->format('Y-m-d h:i A'),
            ],
        ]);
    }
}
