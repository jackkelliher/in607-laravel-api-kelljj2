<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
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
            'full_name' => $this->customer->full_name,
            'phone' => $this->customer->phone,
            'email' => $this->customer->email,
            'job' => $this->job,
            'qualifications' => $this->qualifications,
            'current_airport' => $this->airport->location
        ];
    }
}
