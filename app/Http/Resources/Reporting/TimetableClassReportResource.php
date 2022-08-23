<?php

namespace App\Http\Resources\Reporting;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimetableClassReportResource extends JsonResource
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
        return [
            'classID' => $this->classID,
            'className' => $this->className,
            'day' => $this->day,
            'startTime' => date('h:i A', strtotime($this->startTime)),
            'endTime' => date('h:i A', strtotime($this->endTime)),
            'grade' => $this->grade,
            'room' => $this->room,
            'classFee' => $this->classFee,
            'feeType' => $this->feeType,
            'subject' => [
                'subjectID' => $this->subject->subjectID,
                'subjectName' => $this->subject->subjectName,
                'medium' => $this->subject->subjectName,
            ],
            'category' => $this->subject->category,
            'branch' => [
                'branchID' => $this->branch->branchID,
                'branchName' => $this->branch->branchName,
            ],
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
