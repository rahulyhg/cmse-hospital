<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    public function users(){
        return $this->hasMany('App\User','hospital_id','id');
    }

    public function wards(){
        return $this->hasMany('App\Models\Ward','hospital_id','id');
    }
}
