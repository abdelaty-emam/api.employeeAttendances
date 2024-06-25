<?php

namespace Modules\Leaves\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class LeaveRequestResource  extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);
        $days = $start->diffInDays($end);

        return [
            'id' => $this->id,
            'encrypt_id'    => encrypt($this->id),
            'employee' => $this->employee,
            'leave_type' => $this->leaveType->name,
            'from_data' => $this->start_date,
            'to_date' => $this->end_date,
            'days' => $days
        ];
    }
}
