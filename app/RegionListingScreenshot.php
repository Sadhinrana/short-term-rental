<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegionListingScreenshot extends Model
{
    protected $fillable = [
        'api_id',
        'region_listings_id',
        'index',
        'extension',
        'type',
        'image',
    ];
}
