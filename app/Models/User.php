<?php

namespace App\Models;

use App\Notifications\LoginUrlNotification;
use App\Traits\UsesUuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable, UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'organisation',
        'phone',
        'uid',
        'category',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendLoginToken(){
        $plaintext = Str::random(32);
        $token = $this->loginTokens()->create([
            'token' => hash('sha256', $plaintext),
            'expires_at' => now()->addMinutes(15),
        ]);
        $this->notify(new LoginUrlNotification($plaintext, $token->expires_at));
    }

    public function role(){
        return $this->belongsTo('App\Models\Role');
    }

    public function entity(){
        return $this->morphTo();
    }

    public function locations(){
        return $this->belongsToMany('App\Models\Location');
    }

    public function facilities(){
        return $this->belongsToMany('App\Models\Facility');
    }

    public function loginTokens()
    {
    return $this->hasMany(LoginToken::class);
    }
}
