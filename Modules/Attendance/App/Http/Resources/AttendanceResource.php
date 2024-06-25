<?php

namespace Modules\Attendance\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'date' => $this->date,
            'check_in' => [
                'time' => $this->time_in,
                'latitude' => $this->latitude_in,
                'longitude' => $this->longitude_in,
                'photo' => $this->photos->where('type', 'checkin')->first()->path ?? null,
            ],
            'check_out' => [
                'time' => $this->time_out,
                'latitude' => $this->latitude_out,
                'longitude' => $this->longitude_out,
                'photo' => $this->photos->where('type', 'checkout')->first()->path ?? null,
            ],
            'status' => $this->status,
        ];
    }
}
