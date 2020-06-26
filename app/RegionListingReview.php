<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegionListingReview extends Model
{
    protected $fillable = [
        'api_id',
        'region_listings_id',
        'comments',
        'commentsResponseDate',
        'reviewer',
        'reviewDate',
        'reviewerPhoto',
    ];
}
