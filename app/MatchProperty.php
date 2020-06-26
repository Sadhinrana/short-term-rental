<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchProperty extends Model
{
    protected $fillable = [
        'masterPropertyID',
        'nooPropertyID',
        'nooPropertyTitle',
        'masterPropertyTitle',
        'nooPropertyLat',
        'nooPropertylng',
        'masterPropertylat',
        'masterPropertylng',
        'vote',
        'user_id',
        'comments',
        'picture'
    ];
    public function masterProperty(){
        return $this->belongsTo('App\MasterProperty','masterPropertyID');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
