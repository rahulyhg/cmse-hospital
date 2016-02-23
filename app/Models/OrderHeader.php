<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHeader extends Model
{
    public function items(){
        return $this->hasMany('App\Models\OrderDetail', 'order_id', 'id');
    }

    public function orderedFrom(){
        return $this->belongsTo('App\Models\Hospital', 'ordered_from');
    }

    public function orderBy(){
        return $this->belongsTo('App\User', 'order_by');
    }

    public function approvedBy(){
        return $this->belongsTo('App\User', 'approved_by');
    }

    public function cancelledBy(){
        return $this->belongsTo('App\User', 'cancelled_by');
    }

    public function scopeLatest($query){
        return $query->where('delivered_at','=','0000-00-00')
            ->where('cancelled_at','=','0000-00-00')
            ->orderBy('created_at','desc');
    }

    public function scopeWaitingApproval($query){
        return $query->where('approved_at','=','0000-00-00')
            ->where('cancelled_at','=','0000-00-00');
    }

    public function scopePendingToDeliver($query){
        return $query->where('approved_at','!=','0000-00-00')
            ->where('delivering_at','=','0000-00-00')
            ->where('cancelled_at','=','0000-00-00');
    }

    public function scopeDelivering($query){
        return $query->where('approved_at', '!=', '0000-00-00')
            ->where('delivering_at', '!=', '0000-00-00')
            ->where('cancelled_at','=','0000-00-00');
    }

    public function scopeDelivered($query){
        return $query->where('delivered_at','!=','0000-00-00');
    }

    public function getStatus(){

        if($this->cancelled_at != "0000-00-00 00:00:00"){
            return "cancelled";
        }

        if($this->approved_at == "0000-00-00 00:00:00"){
            //return "Waiting for approval <a href='orders/".$this->id."/approve' class='btn btn-primary btn-xs'>Approve Now</a>";
            return "pending";
        }

        if($this->approved_at != "0000-00-00 00:00:00" && $this->delivering_at == "0000-00-00 00:00:00"){
            //return "Pending to deliver <a href='orders/".$data->id."/deliver' class='btn btn-primary btn-xs'>Deliver Now</a>";
            return "approved";
        }

        if($this->approved_at != "0000-00-00 00:00:00" && $this->delivering_at != "0000-00-00 00:00:00" && $this->delivered_at == "0000-00-00 00:00:00"){
            //return "Delivering <a href='orders/".$data->id."/delivered' class='btn btn-primary btn-xs'>Completed</a>";
            return "delivering";
        }

        if($this->approved_at != "0000-00-00 00:00:00" && $this->delivering_at != "0000-00-00 00:00:00" && $this->delivered_at != "0000-00-00 00:00:00"){
            //return "Delivering <a href='orders/".$data->id."/delivered' class='btn btn-primary btn-xs'>Completed</a>";
            return "received";
        }



    }


}
