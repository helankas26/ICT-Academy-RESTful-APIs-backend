<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reporting\RegisterClassReportResource;
use App\Models\Classes;
use App\Repositories\Interfaces\Reporting\RegisterReportRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class RegisterReportController extends Controller
{
    /**
     * @var RegisterReportRepositoryInterface
     */
    private RegisterReportRepositoryInterface $enrollmentReportRepository;

    /**
     * @param RegisterReportRepositoryInterface $enrollmentReportRepository
     */
    public function __construct(RegisterReportRepositoryInterface $enrollmentReportRepository)
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
            'class' => new RegisterClassReportResource($class),
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
