<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostDetails extends Model
{
    protected $fillable = [
        'api_id',
        'region_listings_id',
        'userId',
        'name',
        'profileUrl',
        'about',
        'address',
        'memberSince',
        'isVerifiedId',
        'image',
        'profileFields',
    ];
}
