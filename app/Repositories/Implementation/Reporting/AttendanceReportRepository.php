<?php

namespace App\Repositories\Implementation\Reporting;

use App\Models\Attendance;
use App\Models\Classes;
use App\Repositories\Interfaces\Reporting\AttendanceReportRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceReportRepository implements AttendanceReportRepositoryInterface
{
    /**
     * @param Request $request
     * @param Classes $class
     * @return mixed
     */
    public function getDailyAttendanceByClass(Request $request, Classes $class)
    {
        return Classes::query()
            ->with([
                'subject', 'category', 'teacher.employee.person', 'branch',
                'attendances' => function ($query) use ($request) {
                    $query->join('enrollment', function ($join) {
                        $join->on('attendances.studentID', 'enrollment.studentID')
                            ->on('attendances.classID', 'enrollment.classID')
                            ->where('enrollment.status', 1);
                    })->with('student.person')
                        ->where('date', data_get($request, 'date'));
                }
            ])->withCount([
                'attendances as present_count' => function (Builder $query) use ($request) {
                    $query->where('attendances.attendStatus', 1)
                        ->where('attendances.date', data_get($request, 'date'));
                },
                'attendances as absent_count' => function (Builder $query) use ($request) {
                    $query->where('attendances.attendStatus', 0)
                        ->where('attendances.date', data_get($request, 'date'));
                },
                'attendances' => function (Builder $query) use ($request) {
                    $query->where('attendances.date', data_get($request, 'date'));
                },
            ])->whereHas('attendances', function (Builder $query) use ($request, $class) {
                $query->where('classID', $class->classID)
                    ->where('date', data_get($request, 'date'));
            })->find($class->classID);

    }

    /**
     * @param Request $request
     * @param Classes $class
     * @return mixed
     */
    public function getMonthlyAttendanceByClass(Request $request, Classes $class)
    {
        return Classes::query()
            ->with([
                'subject', 'category', 'teacher.employee.person', 'branch',
                'attendances' => function ($query) use ($request) {
                    $query->join('enrollment', function ($join) {
                        $join->on('attendances.studentID', 'enrollment.studentID')
                            ->on('attendances.classID', 'enrollment.classID')
                            ->where('enrollment.status', 1);
                    })->with('student.person')
                        ->whereYear('date', data_get($request, 'date'))
                        ->whereMonth('date', Carbon::make(data_get($request, 'date'))->format('m'));
                }
            ])->find($class->classID);
    }

    /**
     * @param Request $request
     * @param Classes $class
     * @return mixed
     */
    public function getDatesByClass(Request $request, Classes $class)
    {
        return Attendance::query()
            ->where('classID', $class->classID)
            ->whereYear('date', data_get($request, 'date'))
            ->whereMonth('date', Carbon::make(data_get($request, 'date'))->format('m'))
            ->distinct()
            ->pluck('date');
    }
}
