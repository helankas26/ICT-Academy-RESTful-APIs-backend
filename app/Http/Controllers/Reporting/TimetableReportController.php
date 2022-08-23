<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reporting\TimetableTeacherReportResource;
use App\Models\Branch;
use App\Repositories\Interfaces\Reporting\TimetableReportRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class TimetableReportController extends Controller
{
    /**
     * @var TimetableReportRepositoryInterface
     */
    private TimetableReportRepositoryInterface $timetableReportRepository;

    /**
     * @param TimetableReportRepositoryInterface $timetableReportRepository
     */
    public function __construct(TimetableReportRepositoryInterface $timetableReportRepository)
    {
        $this->timetableReportRepository = $timetableReportRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $teachers = $this->timetableReportRepository->getTimetable();

        return new JsonResponse([
            'success' => true,
            'teachers' => TimetableTeacherReportResource::collection($teachers),
            'meta' => [
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
            'status' => ['required', Rule::in(['Active', 'Deactivate']), 'string', 'max:10']
        ]);

        $teachers = $this->timetableReportRepository->getTimetableByBranch($request, $branch);

        return new JsonResponse([
            'success' => true,
            'teachers' => TimetableTeacherReportResource::collection($teachers),
            'meta' => [
                'branchID' => $branch->branchID,
                'branchName' => $branch->branchName,
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
    public function indexByDay(Request $request)
    {
        $request->validate([
            'day' => [
                'required',
                Rule::in(['Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']),
                'string',
                'max:10'
            ],
        ]);

        $teachers = $this->timetableReportRepository->getTimetableByDay($request);

        return new JsonResponse([
            'success' => true,
            'teachers' => TimetableTeacherReportResource::collection($teachers),
            'meta' => [
                'Day' => $request->day,
                'branchID' => \request()->header('branchID'),
                'branchName' => \request()->header('branchName'),
                'printedBy' => \request()->header('employeeName'),
                'printedDate' => Carbon::now()->format('Y-m-d h:i A'),
            ],
        ]);
    }
}
