<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class RegionListings extends Model
{
    use SpatialTrait;
    protected $fillable = [
        'api_id',
        'region_id',
        'profileUrl',
        'latitude',
        'longitude',
        'hostName',
        'dateCrawled',
        'numReviews',
        'externalId',
        'description',
        'currencySymbol',
        'hostId',
        'source',
        'userId',
        'personCapacity',
        'totalImages',
        'minNights',
        'aboutTheHost',
        'price',
        'detailedAddress',
        'listingUrl',
        'aboutTheListing',
        'currency',
        'roomType',
        'location'
    ];
    protected $spatialFields = [
        'location',
    ];
    public function region(){
        return $this->belongsTo('App\Region');
    }
    public function review(){
        return $this->hasMany('App\RegionListingReview');
    }
    public function region_listing_image(){
        return $this->hasMany('App\RegionListingImage');
    }
    public function region_listing_screeshot(){
        return $this->hasMany('App\RegionListingScreenshot');
    }
}
