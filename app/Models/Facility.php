<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use UsesUuid;

    protected $casts = [
        "is_addon" => 'boolean',
        'availability' => 'array'
    ];

    public function location(){
        return $this->belongsTo('App\Models\Location');
    }

    public function rates(){
        return $this->hasMany('App\Models\Rate');
    }

    public function bookings(){
        return $this->belongsToMany('App\Models\Booking')->withPivot('amount');
    }

    public function images(){
        return $this->hasMany('App\Models\Image');
    }

    public function users(){
        return $this->belongsToMany('App\Models\User');
    }
}
