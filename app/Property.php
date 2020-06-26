<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $primaryKey = 'Id';
    protected $fillable = [
        'OwnerId',
        'SiteId',
        'PropertyGID',
        'ParcelID',
        'ParcelLong',
        'TaxAccount',
        'ParcelCity',
        'LegalDesc',
        'X_DD',
        'Y_DD',
        'GeoType',
        'PropertyUse',
        'ActiveFlag',
        'CommCommunityID',
        'IDX_Address',
        'NumberofUnits',
        'image',
        'image_object',
        'image_labels',
        'image_text'
    ];

    public function owner()
    {
        return $this->hasOne(Owner::class,'Id');
    }

    public function site()
    {
        return $this->hasOne(Site::class, 'Id');
    }
}
