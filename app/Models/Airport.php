<?php

namespace App\Models;
// Please change this to: namespace App\models

// You will need to do this to all your models

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AirportController;
use App\Models\Plane;
use App\Models\Staff;
use App\Models\Flight;

class Airport extends Model
{

    public function planes() {
        return $this->hasMany(Plane::class, 'airport_id', 'id');
    }

    public function staff() {
        return $this->hasMany(Staff::class, 'airport_id', 'id');
    }

    public function flight() {
        return $this->hasMany(Flight::Class);
    }

    public function getPlanesCountAttribute() {
        return $this->planes()->count();
    }

    public function getStaffCountAttribute() {
        return $this->staff()->count();
    }

    protected $fillable=["location"];

    protected $appends = ["planes_count", 'staff_count'];
}
