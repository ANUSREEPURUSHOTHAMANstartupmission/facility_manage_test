<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use UsesUuid;

    protected $casts = ['availability' => 'array'];

    public function users(){
        return $this->belongsToMany('App\Models\User');
    }

    public function facilities(){
        return $this->hasMany('App\Models\Facility');
    }
}
