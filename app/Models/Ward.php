<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $fillable = ['ward_name', 'remark', 'hospital_id'];

    public function hospital(){
        return $this->belongsTo('App\Models\Hospital','hospital_id');
    }
}
