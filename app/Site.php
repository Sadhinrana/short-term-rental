<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $primaryKey = 'Id';
    protected $fillable = [
        'SiteAddress',
        'SiteUnit',
        'SiteCity',
        'SiteState',
        'SiteZipCode',
        'SiteNeighborhood',
        'SiteStreetNumber',
        'SiteStreetPreDir',
        'SiteStreetName',
        'SiteStreetType',
        'SiteStreetPostDir'
    ];
}
