<?php

namespace App\Http\Resources\Reporting;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvanceReportResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'advance';

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'advanceID' => $this->advanceID,
            'description' => $this->description,
            'advanceAmount' => $this->advanceAmount,
            'date' => $this->date,
            'deleted_at' => $this->whenNotNull($this->deleted_at),
            'handledBy' => [
                'staffID' => $this->staff->staffID,
                'staffName' => $this->staff->employee->title .
                    ' ' . $this->staff->employee->person->firstName . ' ' . $this->staff->employee->person->lastName,
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
