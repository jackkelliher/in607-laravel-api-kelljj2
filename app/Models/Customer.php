<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email', 'phone'];

    protected $appends = ['full_name'];

    public function staff() {
        return $this->hasOne(Staff::Class);
    }

    public function getFullNameAttribute() {
        return $this->first_name . " " . $this->last_name;
    }
}
