<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Startup extends Model
{
    use UsesUuid;

    public function user(){
        return $this->morphOne('App\Models\User', 'entity');
    }
    
}
