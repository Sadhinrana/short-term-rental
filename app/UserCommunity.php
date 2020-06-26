<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCommunity extends Model
{
    protected $fillable = [
        'user_id',
        'community'
    ];
}
