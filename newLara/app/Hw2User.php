<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Hw2User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'username', 'email', 'password', 'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hw2Posts() {
        return $this->hasMany('App\Hw2Post');
    }

    public function hw2Posts_like() {
        return $this->belongsToMany('App\Hw2Post');
    }

    public function hw2Users_follower() {
        return $this->belongsToMany('App\Hw2User', 'hw2_user_follow', 'followed', 'follower');
    }
    public  function hw2Users_followed() {
        return $this->belongsToMany('App\Hw2User', 'hw2_user_follow', 'follower', 'followed');
    }
}
