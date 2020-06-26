<?php

namespace App\Http\Controllers;

use App\City;
use App\ManualMatch;
use App\MasterProperty;
use App\MatchProperty;
use App\Owner;
use App\People;
use App\Property;
use FuzzyWuzzy\Fuzz;
use FuzzyWuzzy\Process;
use Illuminate\Http\Request;

class HostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function hostList(Request $request){
        $sql = People::where('title','Host');
        if($request->city){
            $sql->join('rent_details',function($q) use ($request){
                $q->on('rent_details.id','=','people.rent_details_id')
                ->where('rent_details.city_id',$request->city);
            });
        }
        $hosts = $sql->paginate(10);
        $cities = City::get();
        $hosts->setPath('host-list?city='.$request->city);
        return view('page.host.host-list',[
            'hosts'=>$hosts,
            'cities'=>$cities,
            'city_id'=>$request->city
        ]);
    }
    public function hostDetails($id){
        $hostDetails = People::find($id);
        $owners = Owner::get();
        $fuzz = new Fuzz();
        $process = new Process($fuzz);
        $ownerRatio = $process->extract($hostDetails->name, $owners, null, null,10);
        $masterProperty = MasterProperty::where('rent_details_id',$hostDetails->rent_details_id)->first();
        if($masterProperty != null) {
            $matchProperty = MatchProperty::where('masterPropertyID', $masterProperty->id)
                ->where('vote', 3)
                ->join('properties', 'properties.Id', '=', 'match_properties.nooPropertyID')
                ->join('owners', 'owners.Id', '=', 'properties.OwnerId')
                ->get();
        }else{
            $matchProperty='';
        }
        $nooProperties = Property::with('owner')->get();
        $manualMatch = ManualMatch::with('owners')->where('people_id',$id)->get();
        return view('page.host.host-details',[
            'hostDetails'=>$hostDetails,
            'ownerRatio'=>$ownerRatio,
            'matchProperty'=>$matchProperty,
            'nooProperties'=>$nooProperties,
            'id'=>$id,
            'manualMatch'=>$manualMatch
        ]);
    }
    public function saveManualMatch(Request $request){
       foreach ($request->owner_id as $owner_id){
           $data = array(
               'people_id'=>$request->people_id,
               'owner_id'=>$owner_id
           );
           ManualMatch::create($data);
       }
       return back();
    }
    public function destroyManualMatch($id){
        $data = ManualMatch::find($id);
        $data->delete();
        return back();
    }
    public function updateImageUrl(Request $request){
        $data = array(
            'image_url'=>$request->image_url
        );
        People::where('id',$request->people_id)->update($data);
        return back();
    }
    public function hostInformation($id){
        $masterProperty = MasterProperty::find($id);
        $host = People::where('rent_details_id',$masterProperty->rent_details_id)->first();
        return response()->json($host);
    }
}
