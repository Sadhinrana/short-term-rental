<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterProperty extends Model
{
    //
    protected $fillable = [
        'rent_details_id',
        'name',
        'latitude',
        'longitude',
        'URL',
        'listing_name',
        'room_type',
        'floor_size_value',
        'floor_size_unit',
        'price',
        'address',
        'no_of_people',
        'no_of_bathroom',
        'num_bedroom',
        'num_floor',
        'num_room',
        'region_listings_id',
        'data_source'
    ];
}
