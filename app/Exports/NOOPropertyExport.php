<?php

namespace App\Exports;

use App\Property;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NOOPropertyExport implements  FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $city;

    public function __construct($city)
    {
        $this->city = $city;
    }

    public function view(): View
    {
        $property = Property::with('owner','site')->where('ParcelCity',$this->city)->get();
        return view ('page.noo-property-export',compact('property'));
    }
}
