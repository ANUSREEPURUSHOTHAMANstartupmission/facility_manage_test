<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use UsesUuid;

    public function facility(){
        return $this->belongsTo('App\Models\Facility');
    }
}
