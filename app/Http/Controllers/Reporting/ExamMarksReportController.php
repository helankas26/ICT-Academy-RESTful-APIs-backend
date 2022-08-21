<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reporting\ExamReportResource;
use App\Models\Exam;
use App\Repositories\Interfaces\Reporting\ExamMarksReportRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class ExamMarksReportController extends Controller
{
    /**
     * @var ExamMarksReportRepositoryInterface
     */
    private ExamMarksReportRepositoryInterface $examMarksReportRepository;

    /**
     * @param ExamMarksReportRepositoryInterface $examMarksReportRepository
     */
    public function __construct(ExamMarksReportRepositoryInterface $examMarksReportRepository)
    {
        $this->examMarksReportRepository = $examMarksReportRepository;
    }

    /**
     * Display the specified resource.
     *
     * @param Exam $exam
     * @return JsonResponse
     */
    public function show(Exam $exam)
    {
        $exam = $this->examMarksReportRepository->getMarksByExam($exam);

        return new JsonResponse([
            'success' => true,
            'exam' => new ExamReportResource($exam),
            'meta' => [
                'present_count' => $exam->present_count,
                'absent_count' => $exam->absent_count,
                'students_count' => $exam->students_count,
                'printedBy' => \request()->header('employeeName'),
                'printedDate' => Carbon::now()->format('Y-m-d h:i A'),
            ],
        ]);
    }
}
