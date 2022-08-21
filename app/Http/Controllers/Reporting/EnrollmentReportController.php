<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reporting\EnrollmentClassReportResource;
use App\Models\Classes;
use App\Repositories\Interfaces\Reporting\EnrollmentReportRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class EnrollmentReportController extends Controller
{
    /**
     * @var EnrollmentReportRepositoryInterface
     */
    private EnrollmentReportRepositoryInterface $enrollmentReportRepository;

    /**
     * @param EnrollmentReportRepositoryInterface $enrollmentReportRepository
     */
    public function __construct(EnrollmentReportRepositoryInterface $enrollmentReportRepository)
    {
        $this->enrollmentReportRepository = $enrollmentReportRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Classes $class)
    {
        $class = $this->enrollmentReportRepository->getEnrollmentsByClass($class);

        return new JsonResponse([
            'success' => true,
            'class' => new EnrollmentClassReportResource($class),
            'meta' => [
                'active_count' => $class->active_count,
                'deactivate_count' => $class->deactivate_count,
                'fixed_students' => $class->fixed_students,
                'free_students' => $class->free_students,
                'students_count' => $class->students_count,
                'printedBy' => \request()->header('employeeName'),
                'printedDate' => Carbon::now()->format('Y-m-d h:i A'),
            ],
        ]);
    }
}
