<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use UsesUuid;

    public function facilities(){
        return $this->belongsToMany('App\Models\Facility')->withPivot('amount');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function location(){
        return $this->belongsTo('App\Models\Location');
    }

    public function payments(){
        return $this->morphMany('App\Models\Payment', 'payable');
    }

    public function getTotalAttribute(){
        return $this->facilities->reduce(function($carry, $item){
            return $carry + $item->pivot->amount;
        });
    }

    public function getDiscountableAttribute(){
        return $this->facilities->filter(function($item){
            return $item->is_addon == false;
        })->reduce(function($carry, $item){
            return $carry + $item->pivot->amount;
        });
    }

    public function getDiscountAmountAttribute(){
        // return $this->discount == 100 ? $this->total : (($this->discountable * ($this->discount??0))/100);

        return ($this->total * ($this->discount??0))/100;
    }

    public function getPaidAttribute(){
        return $this->payments()->where('status','paid')->sum('amount');
    }

    public function getBalanceAttribute(){
        return $this->total - $this->discount_amount - $this->paid;
    }

    public function getPaymentsInitiatedAttribute(){
        return $this->payments()->sum('amount');
    }
}
