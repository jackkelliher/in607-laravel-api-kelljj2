<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
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
            'departure_date' => $this->departure_date,
            'departure_airport' => $this->d_airport->location,
            'arrival_date' => $this->arrival_date,
            'arrival_airport' => $this->a_airport->location,
            'pilot' => $this->pilot->customer->full_name,
            'plane_model' => $this->plane->model
        ];
    }
}
