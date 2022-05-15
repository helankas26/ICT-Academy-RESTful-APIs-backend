<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'teacher';

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'teacherID' => $this->teacherID,
            'title' => $this->employee->title,
            'firstName' => $this->employee->person->firstName,
            'lastName' => $this->employee->person->lastName,
            'nic' => $this->employee->nic,
            'dob' => $this->employee->person->dob,
            'sex' => $this->employee->person->sex,
            'telNo' => $this->employee->person->telNo,
            'address' => $this->employee->person->address,
            'email' => $this->employee->person->email,
            'qualification' => $this->qualification,
            'status' => $this->employee->person->status,
            'joinedDate' => $this->employee->person->joinedDate,
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
