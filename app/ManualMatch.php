<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManualMatch extends Model
{
    protected $fillable = [
        'people_id',
        'owner_id'
    ];
    public function owners(){
       return $this->hasOne(Owner::class,'Id','owner_id');
    }
}
