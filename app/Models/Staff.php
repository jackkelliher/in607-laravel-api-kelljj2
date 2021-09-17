<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable=['hire_date', 'job', 'qualifications', 'customer_id', 'airport_id'];
    
    public function customer() {
        return $this->belongsTo(Customer::Class);
    }

    public function airport() {
        return $this->belongsTo(Airport::Class);
    }
}
