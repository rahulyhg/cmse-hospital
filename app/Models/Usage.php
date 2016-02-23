<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
    protected $guarded = [];

    public function item(){
        return $this->belongsTo('App\Models\Item','item_code','item_code');
    }

    public function ward(){
        return $this->belongsTo('App\Models\Ward', 'ward_id');
    }


}
