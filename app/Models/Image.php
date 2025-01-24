<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use UsesUuid;

    public function facility(){
        return $this->belongsTo('App\Models\Facility');
    }
}
