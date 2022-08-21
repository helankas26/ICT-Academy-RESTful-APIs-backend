<?php

namespace App\Http\Resources\Reporting;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisteredStudentsReportResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'registry';

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'studentID' => $this->studentID,
            'studentName' => $this->person->firstName. ' ' . $this->person->lastName,
            'grade' => $this->grade,
            'telNo' => $this->person->telNo,
            'enrolledDate' => $this->enrollment->enrolledDate,
            'paymentStatus'=> $this->enrollment->paymentStatus != -1 ? ($this->enrollment->paymentStatus > 1 ? 'A' : 'P') : 'F',
            'payment_count'=> $this->enrollment->paymentStatus,
            'status' => $this->enrollment->status,
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
