<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobInQueue extends Model
{
    protected $fillable=[
        'property_type',
        'status',
        'is_active',
        'file_url',
        'api_id'
    ];
}
