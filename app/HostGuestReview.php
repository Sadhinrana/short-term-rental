<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostGuestReview extends Model
{
    protected $fillable = [
        'region_listings_id',
        'api_id',
        'fromHostUrl',
        'fromHostName',
        'createdOn',
        'relationship',
        'content',
    ];
}
