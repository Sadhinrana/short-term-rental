<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{
    protected $fillable = [
        'user_id',
        'fcm_token',
    ];
}
