<?php

namespace Modules\Leaves\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class EmployeeLeavesHistoryResource  extends JsonResource
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
            'id'         => $this->id,
            'encrypt_id' => encrypt($this->id),
            'leave_type' => $this->leaveType->name,
            'from_date'  => $this->start_date,
            'to_date'    => $this->end_date,
            'days'       => $days,
            'status' => $this->status,
            'approved_by' => $this->approver->name ?? null
        ];
    }
}
