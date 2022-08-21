<?php

namespace App\Http\Resources\Reporting;

use App\Http\Resources\SubjectResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamReportResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'exam';

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'examID' => $this->examID,
            'exam' => $this->exam,
            'totalMark' => $this->totalMark,
            'date' => $this->date,
            'class' => [
                'classID' => $this->class->classID,
                'className' => $this->class->className,
                'day' => $this->class->day,
                'grade' => $this->class->grade,
            ],
            'subject' => new SubjectResource($this->subject),
            'category' => $this->category,
            'teacher' => [
                'teacherID' => $this->class->teacher->teacherID,
                'teacherName' => $this->class->teacher->employee->title .
                    ' ' . $this->class->teacher->employee->person->firstName .
                    ' ' . $this->class->teacher->employee->person->lastName,
            ],
            'branch' => [
                'branchID' => $this->branch->branchID,
                'branchName' => $this->branch->branchName,
            ],
            'students' => ExamMarksReportResource::collection($this->students),
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
