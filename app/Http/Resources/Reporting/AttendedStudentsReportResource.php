<?php

namespace App\Http\Resources\Reporting;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendedStudentsReportResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'attendance';

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "studentID" => $this->studentID,
            'studentName' => $this->student->person->firstName . ' ' . $this->student->person->lastName,
            "date" => $this->date,
            "time" => $this->time != null ? date('h:i A', strtotime($this->time)) : null,
            "attendStatus" => $this->attendStatus,
            "attend_status" => $this->attendStatus == 1 ? 'Present' : 'Absent',
            "paymentStatus" => $this->paymentStatus,
            "status" => $this->status,
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
