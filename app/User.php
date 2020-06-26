<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use  Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
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

    public function all_vote(){
        return $this->hasMany('App\MatchProperty','user_id');
    }

    public function match_vote(){
        return $this->hasMany('App\MatchProperty','user_id')->where('vote',3);
    }

    public function missmatch_vote(){
        return $this->hasMany('App\MatchProperty','user_id')->where('vote',1);
    }

    public function unsure_vote(){
        return $this->hasMany('App\MatchProperty','user_id')->where('vote',2);
    }

    public function communities(){
        return $this->hasMany('App\UserCommunity');
    }
}
