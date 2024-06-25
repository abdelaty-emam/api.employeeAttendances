<?php

namespace Modules\Shifts\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;


class ShiftsResource  extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [

            'id'=> $this->id,
            'encrypt_id'    => encrypt($this->id),
            'satrt_time'=>$this->start_time,
            'end_time'=>$this->end_time,
        ];
    }


}
