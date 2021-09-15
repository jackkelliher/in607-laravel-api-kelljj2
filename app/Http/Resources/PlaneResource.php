<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AirportResource;

class PlaneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'model' => $this->model,
            'capacity' => $this->capacity,
            'speed' => $this->speed,
            'location' => $this->airports->location
        ];
    }
}
