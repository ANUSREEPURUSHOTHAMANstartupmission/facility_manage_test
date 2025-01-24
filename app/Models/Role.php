<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  use UsesUuid;

  protected $fillable = ['name', 'type'];

  public function users(){
    return $this->hasMany('App\Models\User');
  }

  public function permissions(){
      return $this->belongsToMany('App\Models\Permission');
  }
}