<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = ['departure_date', 'arrival_date'];

    public function d_airport() {
        return $this->belongsTo(Airport::class, 'departure_airport');
    }

    public function a_airport() {
        return $this->belongsTo(Airport::class, 'arrival_airport');
    }

    public function plane() {
        return $this->belongsTo(Plane::class, 'plane_id');
    }

    public function pilot() {
        return $this->belongsTo(Staff::class, 'pilot_id');
    }
}
