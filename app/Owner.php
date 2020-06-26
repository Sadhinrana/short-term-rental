<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $primaryKey = 'Id';
    protected $fillable = [
        'OwnerName1',
        'OwnerName2',
        'OwnerAddress',
        'OwnerCity',
        'OwnerState',
        'OwnerZipcode',
        'OwnerStreetNumber',
        'OwnerStreetPreDir',
        'OwnerStreetName',
        'OwnerStreetType',
        'OwnerStreetPostDir',
        'OwnerUnit',
        'OwnerOccupiedFlag',
        'OwnerOccupiedCode'
    ];

    public function NOOProperties(){
        return $this->hasMany(Property::class, 'OwnerId');
    }
}
