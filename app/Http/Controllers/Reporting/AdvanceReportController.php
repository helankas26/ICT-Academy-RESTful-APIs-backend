<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvanceResource;
use App\Http\Resources\Reporting\AdvanceReportResource;
use App\Models\Employee;
use App\Repositories\Interfaces\Reporting\AdvanceReportRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class AdvanceReportController extends Controller
{
    /**
     * @var AdvanceReportRepositoryInterface
     */
    private AdvanceReportRepositoryInterface $advanceReportRepository;

    /**
     * @param AdvanceReportRepositoryInterface $advanceReportRepository
     */
    public function __construct(AdvanceReportRepositoryInterface $advanceReportRepository)
    {
        $this->advanceReportRepository = $advanceReportRepository;
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

        $advances = $this->advanceReportRepository->getAllAdvances($request);

        $total = 0;

        foreach ($advances as $advance) {
            $total += $advance->advanceAmount;
        }

        return new JsonResponse([
            'success' => true,
            'branch' => [
                'branchID' => \request()->header('branchID'),
                'branchName' => \request()->header('branchName'),
            ],
            'advances' => AdvanceResource::collection($advances),
            'meta' => [
                'advance_count' => $advances->count(),
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
    public function indexByEmployeeType(Request $request)
    {
        $request->validate([
            'employeeType' => ['required', 'string', 'max:20', Rule::exists('employees', 'employeeType')],
            'date' => ['nullable', 'date']
        ]);

        $advances = $this->advanceReportRepository->getAllAdvancesByEmployeeType($request);

        $total = 0;

        foreach ($advances as $advance) {
            $total += $advance->advanceAmount;
        }

        return new JsonResponse([
            'success' => true,
            'employeeType' => $request->employeeType,
            'branch' => [
                'branchID' => \request()->header('branchID'),
                'branchName' => \request()->header('branchName'),
            ],
            'advances' => AdvanceResource::collection($advances),
            'meta' => [
                'advance_count' => $advances->count(),
                'total' => number_format($total, 2),
                'date' => Carbon::make($request->date)->format('Y F'),
                'printedBy' => \request()->header('employeeName'),
                'printedDate' => Carbon::now()->format('Y-m-d h:i A'),
            ],
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Employee $employee
     * @return JsonResponse
     */
    public function showByEmployee(Request $request, Employee $employee)
    {

        $request->validate([
            'employeeType' => ['required', 'string', 'max:20', Rule::exists('employees', 'employeeType')],
            'date' => ['nullable', 'date']
        ]);

        $employee = $this->advanceReportRepository->getAdvanceByEmployee($request, $employee);

        $total = 0;

        foreach ($employee->advances as $advance) {
            $total += $advance->advanceAmount;
        }

        if ($employee->employeeType == 'Teacher') {
            return new JsonResponse([
                'success' => true,
                'teacherID' => $employee->employeeID,
                'employeeType' => $employee->employeeType,
                'title' => $employee->title,
                'firstName' => $employee->person->firstName,
                'lastName' =>  $employee->person->lastName,
                'branch' => [
                    'branchID' => \request()->header('branchID'),
                    'branchName' => \request()->header('branchName'),
                ],
                'advances' => AdvanceReportResource::collection($employee->advances),
                'meta' => [
                    'advance_count' => $employee->advances->count(),
                    'total' => number_format($total, 2),
                    'date' => Carbon::make($request->date)->format('Y F'),
                    'printedBy' => \request()->header('employeeName'),
                    'printedDate' => Carbon::now()->format('Y-m-d h:i A'),
                ],
            ]);
        }

        return new JsonResponse([
            'success' => true,
            'staffID' => $employee->employeeID,
            'employeeType' => $employee->employeeType,
            'title' => $employee->title,
            'firstName' => $employee->person->firstName,
            'lastName' =>  $employee->person->lastName,
            'branch' => [
                'branchID' => \request()->header('branchID'),
                'branchName' => \request()->header('branchName'),
            ],
            'advances' => AdvanceReportResource::collection($employee->advances),
            'meta' => [
                'advance_count' => $employee->advances->count(),
                'total' => number_format($total, 2),
                'date' => Carbon::make($request->date)->format('Y F'),
                'printedBy' => \request()->header('employeeName'),
                'printedDate' => Carbon::now()->format('Y-m-d h:i A'),
            ],
        ]);
    }
}
