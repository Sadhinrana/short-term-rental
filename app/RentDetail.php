<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentDetail extends Model
{

    protected $fillable = [
        'rent_id',
        'address',
        'available_date',
        'brokers',
        'building_name',
        'city_id',
        'country_id',
        'date_added',
        'date_updated',
        'deposit_id',
        'description_id',
        'feature_id',
        'fee_id',
        'floor_size_value',
        'floor_size_unit',
        'geo_location',
        'hours',
        'image_url',
        'key',
        'languages_spoken',
        'latitude',
        'leasing_terms',
        'listing_name',
        'longitude',
        'lot_size_value',
        'lot_size_unit',
        'managed_by',
        'most_recent_status',
        'most_recent_status_date',
        'mls_number',
        'near_by_school',
        'neighborhood',
        'num_bathroom',
        'num_bedroom',
        'num_floor',
        'num_people',
        'num_room',
        'num_unit',
        'parking',
        'payment_type',
        'people_id',
        'pet_policy',
        'phones',
        'postal_code',
        'price_id',
        'property_tax',
        'property_type',
        'province',
        'review_id',
        'rules',
        'source_URL',
        'status_id',
        'tax_ID',
        'unavailable_date',
        'website_id',
    ];

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function price()
    {
        return $this->belongsTo('App\Price');
    }

    public function image()
    {
        return $this->hasMany('App\DatafinitiImage', 'rent_id');
    }

    public function review()
    {
        return $this->hasMany('App\Review','rent_details_id');
    }

}
