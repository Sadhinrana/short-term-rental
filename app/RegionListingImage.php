<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegionListingImage extends Model
{
    protected $fillable = [
        'api_id',
        'region_listings_id',
        'caption',
        'index',
        'extension',
        'image',
        'image_object',
        'image_labels',
        'image_text'
    ];
}
