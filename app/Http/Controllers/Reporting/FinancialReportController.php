<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Teacher;
use App\Repositories\Interfaces\Reporting\FinancialReportRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class FinancialReportController extends Controller
{
    /**
     * @var FinancialReportRepositoryInterface
     */
    private FinancialReportRepositoryInterface $financialReportRepository;

    /**
     * @param FinancialReportRepositoryInterface $financialReportRepository
     */
    public function __construct(FinancialReportRepositoryInterface $financialReportRepository)
    {
        $this->financialReportRepository = $financialReportRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function indexDaily(Request $request)
    {
        $request->validate([
            'date' => ['nullable', 'date']
        ]);

        $transactions = $this->financialReportRepository->getDailyTransaction($request);

        return $this->finance($transactions, $request->date);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function indexMonthly(Request $request)
    {
        $request->validate([
            'date' => ['nullable', 'date']
        ]);

        $transactions = $this->financialReportRepository->getMonthlyTransaction($request);

        return $this->finance($transactions, Carbon::make($request->date)->format('Y F'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function indexYearly(Request $request)
    {
        $request->validate([
            'date' => ['nullable', 'date_format:Y']
        ]);

        $transactions = $this->financialReportRepository->getYearlyTransaction($request);

        return $this->finance($transactions, $request->date);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Staff $staff
     * @return Response
     */
    public function showStaffPaySheet(Request $request, Staff $staff)
    {
        $request->validate([
            'date' => ['nullable', 'date']
        ]);

        //to be implemented

    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Teacher $teacher
     * @return JsonResponse
     */
    public function showTeacherPaySheetForDaily(Request $request, Teacher $teacher)
    {
        $request->validate([
            'date' => ['nullable', 'date']
        ]);

        $teacher = $this->financialReportRepository->getTeacherDailyPaymentsById($request, $teacher);
        $employee = $this->financialReportRepository->getDailyAdvanceByEmployee($request, $teacher);

        return $this->paySheet($teacher, $employee, $request, $request->date);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Teacher $teacher
     * @return JsonResponse
     */
    public function showTeacherPaySheetForMonthly(Request $request, Teacher $teacher)
    {
        $request->validate([
            'date' => ['nullable', 'date']
        ]);

        $teacher = $this->financialReportRepository->getTeacherMonthlyPaymentsById($request, $teacher);
        $employee = $this->financialReportRepository->getMonthlyAdvanceByEmployee($request, $teacher->teacherID);

        return $this->paySheet($teacher, $employee, $request, Carbon::make($request->date)->format('Y F'));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Teacher $teacher
     * @return Response
     */
    public function showTeacherTargetSheet(Request $request, Teacher $teacher)
    {
        $request->validate([
            'date' => ['nullable', 'date']
        ]);

        //to be implemented
    }

    /**
     * @param mixed $transactions
     * @param mixed $date
     * @return JsonResponse
     */
    private function finance(mixed $transactions, mixed $date): JsonResponse
    {
        $payments = 0;
        $arrears = 0;
        $advanceTotal = 0;
        $expenseTotal = 0;

        foreach ($transactions['fees'] as $fee) {
            if ($fee->paidStatus == 'P') {
                $payments += $fee->paidAmount;
            }

            if ($fee->paidStatus == 'A') {
                $arrears += $fee->paidAmount;
            }
        }

        foreach ($transactions['advances'] as $advance) {
            $advanceTotal += $advance->advanceAmount;
        }

        foreach ($transactions['expenditures'] as $expenditure) {
            $expenseTotal += $expenditure->expenseAmount;
        }

        return new JsonResponse([
            'success' => true,
            'earnings' => [
                'payments' => number_format($payments, 2),
                'arrears' => number_format($arrears, 2),
                'total' => number_format($payments + $arrears, 2),
            ],
            'expenditures' => [
                'advances' => number_format($advanceTotal, 2),
                'expenses' => number_format($expenseTotal, 2),
                'total' => number_format($advanceTotal + $expenseTotal, 2),
            ],

            'profit-loss' => number_format(($payments + $arrears) - ($advanceTotal + $expenseTotal), 2),
            'meta' => [
                'date' => $date,
                'branchID' => \request()->header('branchID'),
                'branchName' => \request()->header('branchName'),
                'printedBy' => \request()->header('employeeName'),
                'printedDate' => Carbon::now()->format('Y-m-d h:i A'),
            ],
        ]);
    }

    /**
     * @param mixed $teacher
     * @param mixed $employee
     * @param Request $request
     * @param mixed $date
     * @return JsonResponse
     */
    private function paySheet(mixed $teacher, mixed $employee, Request $request, mixed $date): JsonResponse
    {
        //income calculation
        $classes = array();
        $gross_salary = 0;

        foreach ($teacher->classes as $class) {
            $arrears = 0;
            $payments = 0;
            foreach ($class->fees as $fee) {
                if ($fee->paidStatus == 'A') {
                    $classes[$class->className]['A'] = $arrears += $fee->paidAmount;
                    $gross_salary += $fee->paidAmount;
                }

                if ($fee->paidStatus == 'P') {
                    $classes[$class->className]['P'] = $payments += $fee->paidAmount;
                    $gross_salary += $fee->paidAmount;
                }
            }
            $classes[$class->className]['A'] = number_format($arrears, 2);
            $classes[$class->className]['P'] = number_format($payments, 2);
        }

        //advance calculation
        $total_advance = 0;

        foreach ($employee->advances as $advance) {
            $total_advance += $advance->advanceAmount;
        }

        //welfare calculation
        $welfare = ($gross_salary * 20) / 100;

        //total deduction calculation
        $total_deduction = $total_advance + $welfare;

        //net salary calculation
        $net_salary = $gross_salary - $total_deduction;

        return new JsonResponse([
            'success' => true,
            'teacherID' => $employee->employeeID,
            'employeeType' => $employee->employeeType,
            'title' => $employee->title,
            'firstName' => $employee->person->firstName,
            'lastName' => $employee->person->lastName,
            'classes' => $classes,
            'meta' => [
                'date' => $date,
                'gross_salary' => number_format($gross_salary, 2),
                'deductions' => [
                    'advance' => number_format($total_advance, 2),
                    'welfare' => number_format($welfare, 2),
                    'total_deductions' => number_format($total_deduction, 2),
                ],
                'net_salary' => number_format($net_salary, 2),
                'branchID' => \request()->header('branchID'),
                'branchName' => \request()->header('branchName'),
                'printedBy' => \request()->header('employeeName'),
                'printedDate' => Carbon::now()->format('Y-m-d h:i A'),
            ],
        ]);
    }
}
