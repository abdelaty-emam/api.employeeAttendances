<?php

namespace Modules\WorkLocations\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkLocationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'encrypt_id'    => encrypt($this->id),
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,

        ];
    }
}
