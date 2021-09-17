<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plane extends Model
{
    protected $fillable = ['model' ,'speed', 'capacity', 'airport_id'];

    public function airports() {
        return $this->belongsTo(Airport::Class, 'airport_id', 'id');
    }
}
