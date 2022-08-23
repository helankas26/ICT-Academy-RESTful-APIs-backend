<?php

namespace App\Http\Resources\Reporting;

use App\Repositories\Implementation\Reporting\TimetableReportRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimetableTeacherReportResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'timetable';

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        if ($request->routeIs('timetableReports.index')) {
            $branches = (new TimetableReportRepository())->getAllBranches();

            $classes = array();

            foreach ($branches as $branch) {
                foreach ($this->classes as $class) {
                    if ($class->branchID == $branch->branchID) {
                        $classes[$branch->branchName][] = [
                            'classID' => $class->classID,
                            'className' => $class->className,
                            'day' => $class->day,
                            'startTime' => date('h:i A', strtotime($class->startTime)),
                            'endTime' => date('h:i A', strtotime($class->endTime)),
                            'grade' => $class->grade,
                            'room' => $class->room,
                            'classFee' => $class->classFee,
                            'feeType' => $class->feeType,
                            'subject' => [
                                'subjectID' => $class->subject->subjectID,
                                'subjectName' => $class->subject->subjectName,
                                'medium' => $class->subject->subjectName,
                            ],
                            'category' => $class->subject->category,
                            'branch' => [
                                'branchID' => $class->branch->branchID,
                                'branchName' => $class->branch->branchName,
                            ],
                        ];
                    }
                }
            }

            return [
                'teacherID' => $this->teacherID,
                'title' => $this->employee->title,
                'firstName' => $this->employee->person->firstName,
                'lastName' => $this->employee->person->lastName,
                'classes' => $classes,
            ];
        }


        return [
            'teacherID' => $this->teacherID,
            'title' => $this->employee->title,
            'firstName' => $this->employee->person->firstName,
            'lastName' => $this->employee->person->lastName,
            'classes' => TimetableClassReportResource::collection($this->classes),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
     * @return array
     */
    public function with($request)
    {
        return [
            'success' => true,
        ];
    }
}
