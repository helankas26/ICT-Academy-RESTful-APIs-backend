<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reporting\AttendanceClassReportResource;
use App\Models\Classes;
use App\Repositories\Interfaces\Reporting\AttendanceReportRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceReportController extends Controller
{
    /**
     * @var AttendanceReportRepositoryInterface
     */
    private AttendanceReportRepositoryInterface $attendanceReportRepository;

    /**
     * @param AttendanceReportRepositoryInterface $attendanceReportRepository
     */
    public function __construct(AttendanceReportRepositoryInterface $attendanceReportRepository)
    {
        $this->attendanceReportRepository = $attendanceReportRepository;
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Classes $class
     * @return JsonResponse
     */
    public function showByDate(Request $request, Classes $class)
    {
        $request->validate([
            'date' => ['required', 'date']
        ]);

        $class = $this->attendanceReportRepository->getDailyAttendanceByClass($request, $class);

        return new JsonResponse([
            'success' => true,
            'class' => new AttendanceClassReportResource($class),
            'meta' => [
                'present_count' => $class->present_count,
                'absent_count' => $class->absent_count,
                'attendances_count' => $class->attendances_count,
                'printedBy' => \request()->header('employeeName'),
                'printedDate' => Carbon::now()->format('Y-m-d h:i A'),
            ],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Classes $class
     * @return JsonResponse
     */
    public function showByMonth(Request $request, Classes $class)
    {
        $request->validate([
            'date' => ['required', 'date']
        ]);

        $class = $this->attendanceReportRepository->getMonthlyAttendanceByClass($request, $class);
        $dates = $this->attendanceReportRepository->getDatesByClass($request, $class);

        $attendances = array();

        foreach ($dates as $date) {
            foreach ($class->attendances as $attendance) {
                if ($attendance->date == $date) {
                    $attendances[$date][] = [
                        "studentID" => $attendance->studentID,
                        'studentName' => $attendance->student->person->firstName . ' ' . $attendance->student->person->lastName,
                        "date" => $attendance->date,
                        "time" => $attendance->time != null ? date('h:i A', strtotime($attendance->time)) : null,
                        "attendStatus" => $attendance->attendStatus,
                        "attend_status" => $attendance->attendStatus == 1 ? 'Present' : 'Absent',
                        "paymentStatus" => $attendance->paymentStatus,
                        "status" => $attendance->status,
                    ];
                }
            }
        }

        return new JsonResponse([
            'success' => true,
            'class' => new AttendanceClassReportResource($class),
            'attendances' => $attendances,
            'meta' => [
                'date_count' => $dates->count(),
                'date' => Carbon::make($request->date)->format('Y F'),
                'printedBy' => \request()->header('employeeName'),
                'printedDate' => Carbon::now()->format('Y-m-d h:i A'),
            ],
        ]);

    }
}
