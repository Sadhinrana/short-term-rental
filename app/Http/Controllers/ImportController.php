<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RentImport;
use App\RentDetail;
use App\Country;
use App\City;
use App\Deposit;
use App\Description;
use App\Feature;
use App\Fee;
use App\People;
use App\Price;
use App\Review;
use App\Status;
use App\Owner;
use App\Site;
use App\Property;
use Storage;
use DB;
use App\Imports\NooPropertyImport;

class ImportController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('page.import-excel');
    }
    public function savepropertyImport(Request $request){
        if ($request->post()) {
            Excel::import(new NooPropertyImport,$request->file('file'));
            return back()->with('message', 'Successfully Import Excel.');
        }
    }

    public function propertyImport(Request $request) {
        return view('page.import-property');
    }


    public function import(Request $request) {
        Excel::import(new RentImport, $request->file('file'));
        return back()->with('message', 'Successfully Import Excel.');
    }

    public function uploadFile(Request $request) {
        // Validate form data
        $request->validate([
            'input_file.*' => 'required|mimes:csv,xlsx,xls',
        ]);

        // Checks if the file exists
        if ($request->hasFile('input_file')){
            // Get file name with extension
            $fileNameWithExt = $request->file('input_file')->getClientOriginalName();
            // Get only file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get only extension
            $extension = $request->file('input_file')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $fileName . rand(0000000, 9999999) . "." . $extension;
            // Directory to upload
            $request->file('input_file')->storeAs('public/excel/', $fileNameToStore);
        }
        return response()->json([asset('/storage/excel/'.$fileNameToStore), $fileNameToStore]);
    }

    public function importHistory(Request $request) {
        $importHistories = RentDetail::with('country', 'city')
                        ->where(function($q) use ($request) {
                            if ($request->city) {
                                $q->where('city_id', '=', $request->city);
                            }
                            if ($request->country) {
                                $q->where('country_id', '=', $request->country);
                            }
                        })->paginate(10);
        $importHistories->setPath('datafiniti-property-list?country='.$request->country.'&city='.$request->city);
        $countries = Country::get();
        $cities = City::get();
        return view('page.import-history', [
            'importHistories' => $importHistories,
            'countries' => $countries,
            'cities' => $cities,
            'country'=>$request->country,
            'city'=>$request->city
        ]);
    }

    public function importHistoryDetails($id) {
        $rentDetails = RentDetail::with('city', 'country','image')
                ->find($id);
        $deposit = Deposit::where('rent_details_id', $id)->get();
        $description = Description::where('rent_details_id', $id)->get();
        $feature = Feature::where('rent_details_id', $id)->get();
        $fees = Fee::where('rent_details_id', $id)->get();
        $people = People::where('rent_details_id', $id)->get();
        $price = Price::where('rent_details_id', $id)->get();
        $review = Review::where('rent_details_id', $id)->get();
        $status = Status::where('rent_details_id', $id)->get();
        return view('page.import-history-details', [
            'rentDetails' => $rentDetails,
            'deposit' => $deposit,
            'description' => $description,
            'feature' => $feature,
            'fees' => $fees,
            'people' => $people,
            'price' => $price,
            'review' => $review,
            'status' => $status
        ]);
    }
    public function editRental($id){
        $rentDetails = RentDetail::with('city', 'country')
            ->find($id);
        $deposit = Deposit::where('rent_details_id', $id)->get();
        $description = Description::where('rent_details_id', $id)->get();
        $feature = Feature::where('rent_details_id', $id)->get();
        $fees = Fee::where('rent_details_id', $id)->get();
        $people = People::where('rent_details_id', $id)->get();
        $price = Price::where('rent_details_id', $id)->get();
        $review = Review::where('rent_details_id', $id)->get();
        $status = Status::where('rent_details_id', $id)->get();
        $cities = City::get();
        $countries = Country::get();
        return view('page.edit-rental',[
            'rentDetails' => $rentDetails,
            'deposit' => $deposit,
            'description' => $description,
            'feature' => $feature,
            'fees' => $fees,
            'people' => $people,
            'price' => $price,
            'review' => $review,
            'status' => $status,
            'cities'=>$cities,
            'countries' => $countries
        ]);
    }
    public function updateRental(Request $request){
        $rentDetails = RentDetail::find($request->id);
        $rentDetails->rent_id = $request->rent_id;
        $rentDetails->address = $request->address;
        $rentDetails->available_date = $request->available_date != null ? date('Y-m-d H:i:s', strtotime($request->available_date)) : NULL;
        $rentDetails->brokers =  $request->brokers;
        $rentDetails->building_name = $request->building_name;
        $rentDetails->city_id =  $request->city_id;
        $rentDetails->country_id =  $request->country_id;
        $rentDetails->date_added =  $request->date_added != null ? date('Y-m-d H:i:s', strtotime($request->date_added)) : NULL;
        $rentDetails->date_updated =  $request->date_updated != null ? date('Y-m-d H:i:s', strtotime( $request->date_updated)) : NULL;
        $rentDetails->floor_size_value =  $request->floor_size_value;
        $rentDetails->floor_size_unit =  $request->floor_size_unit;
        $rentDetails->geo_location =  $request->geo_location;
        $rentDetails->hours =  $request->hours;
        $rentDetails->image_url =  $request->image_url;
        $rentDetails->key =  $request->key;
        $rentDetails->languages_spoken =  $request->languages_spoken;
        $rentDetails->latitude =  $request->latitude;
        $rentDetails->leasing_terms =  $request->leasing_terms;
        $rentDetails->listing_name =  $request->listing_name;
        $rentDetails->longitude =  $request->longitude;
        $rentDetails->lot_size_value =  $request->lot_size_value;
        $rentDetails->lot_size_unit =  $request->lot_size_unit;
        $rentDetails->managed_by =  $request->managed_by;
        $rentDetails->most_recent_status =  $request->most_recent_status;
        $rentDetails->most_recent_status_date = $request->most_recent_status_date != null ? date('Y-m-d H:i:s', strtotime( $request->most_recent_status_date)) : NULL;
        $rentDetails->mls_number =  $request->mls_number;
        $rentDetails->near_by_school =  $request->near_by_school;
        $rentDetails->neighborhood =  $request->neighborhood;
        $rentDetails->num_bathroom = $request->num_bathroom;
        $rentDetails->num_bedroom =  $request->num_bedroom;
        $rentDetails->num_floor =  $request->num_floor;
        $rentDetails->num_people =  $request->num_people;
        $rentDetails->num_room =  $request->num_room;
        $rentDetails->num_unit =  $request->num_unit;
        $rentDetails->parking =  $request->parking;
        $rentDetails->payment_type =  $request->payment_type;
        $rentDetails->pet_policy =  $request->pet_policy;
        $rentDetails->phones =  $request->phones;
        $rentDetails->postal_code =  $request->postal_code;
        $rentDetails->property_tax =  $request->property_tax;
        $rentDetails->property_type =  $request->property_type;
        $rentDetails->province =  $request->province;
        $rentDetails->rules =  $request->rules;
        $rentDetails->source_URL =  $request->source_URL;
        $rentDetails->tax_ID =  $request->tax_ID;
        $rentDetails->unavailable_date = $request->unavailable_date != null ? date('Y-m-d H:i:s', strtotime($request->unavailable_date)) : NULL;
        $rentDetails->website_id =  $request->website_id;
        $rentDetails->save();
        if($request->has('deposit_amount')){
           DB::table('deposits')->where('rent_details_id',$request->id)->delete();
            $this->updateDeposit($request);
        }
        if($request->has('description_value')){
            DB::table('descriptions')->where('rent_details_id',$request->id)->delete();
            $this->updateDescription($request);
        }
        if($request->has('feature_key')){
            DB::table('features')->where('rent_details_id',$request->id)->delete();
            $this->updateFeature($request);
        }
        if($request->has('fees_type')){
            DB::table('fees')->where('rent_details_id',$request->id)->delete();
            $this->updateFees($request);
        }
        if($request->has('people_name')){
            DB::table('people')->where('rent_details_id',$request->id)->delete();
            $this->updatePeople($request);
        }
        if($request->has('price_amount_max')){
            DB::table('prices')->where('rent_details_id',$request->id)->delete();
            $this->updatePrice($request);
        }
        if($request->has('review_date')){
            DB::table('reviews')->where('rent_details_id',$request->id)->delete();
            $this->updateReview($request);
        }
        if($request->has('status_type')){
            DB::table('statuses')->where('rent_details_id',$request->id)->delete();
            $this->updateStatus($request);
        }
        return 1;
    }
    public function updateDeposit($request){
        for($i=0;$i<count($request->deposit_amount);$i++){
            $deposit = new Deposit();
            $deposit->rent_details_id = $request->id;
            $deposit->currency = $request->deposit_currency[$i];
            $deposit->amount = $request->deposit_amount[$i];
            $deposit->date_seen = json_encode(explode(', ',$request->deposit_date_seen[$i]));
            $deposit->source_URL = json_encode(explode(', ',$request->deposit_source_url[$i]));
            $deposit->save();
        }
    }
    public function updateDescription($request){
        for($i=0;$i<count($request->description_value);$i++){
            $description = new Description();
            $description->rent_details_id = $request->id;
            $description->value = $request->description_value[$i];
            $description->source_URL = json_encode(explode(', ',$request->description_source_url[$i]));
            $description->date_seen = isset($request->description_date_seen[$i]) ? date('Y-m-d H:i:s', strtotime($request->description_date_seen[$i])) : NULL;
            $description->save();
        }
    }
    public function updateFeature($request){
        for($i=0;$i<count($request->feature_key);$i++){
            $feature = new Feature();
            $feature->rent_details_id = $request->id;
            $feature->key = $request->feature_key[$i];
            $feature->value = json_encode(explode(', ',$request->feature_value[$i]));
            $feature->save();
        }
    }
    public function updateFees($request){
        for($i=0;$i<count($request->fees_type);$i++){
            $fees = new Fee();
            $fees->rent_details_id = $request->id;
            $fees->type = $request->fees_type[$i];
            $fees->date_seen = json_encode(explode(', ',$request->fees_date_seen[$i]));
            $fees->source_URL =  json_encode(explode(', ',$request->fees_source_url[$i]));
            $fees->currency = $request->fees_currency[$i];
            $fees->amount_min = $request->fees_amount_min[$i];
            $fees->amount_max = $request->fees_amount_max[$i];
            $fees->save();
        }
    }
    public function updatePeople($request){
        for($i=0;$i<count($request->people_name);$i++){
            $people = new People();
            $people->rent_details_id = $request->id;
            $people->name = $request->people_name[$i];
            $people->title = $request->people_title[$i];
            $people->date_seen = isset($request->people_date_seen[$i]) ? date('Y-m-d H:i:s', strtotime($request->people_date_seen[$i])) : NULL;
            $people->save();
        }
    }
    public function updatePrice($request){
        for($i=0;$i<count($request->price_amount_max);$i++){
            $price = new Price();
            $price->rent_details_id =$request->id;
            $price->amount_max = $request->price_amount_max[$i];
            $price->amount_min = $request->price_amount_min[$i];
            $price->currency = $request->price_currency[$i];
            $price->date_seen =json_encode(explode(', ',$request->price_date_seen[$i]));
            $price->is_sale = isset($request->isSale) ? $request->isSale : NULL;
            $price->source_URL = json_encode(explode(', ',$request->price_source_url[$i]));
            $price->save();
        }
    }
    public function updateReview($request){
        for($i=0;$i<count($request->review_date);$i++){
            $review = new Review();
            $review->rent_details_id = $request->id;
            $review->date = isset($request->review_date[$i]) ? date('Y-m-d H:i:s', strtotime($request->review_date[$i])) : NULL;
            $review->date_seen = isset($request->review_date_seen[$i]) ? date('Y-m-d H:i:s', strtotime($request->review_date_seen[$i])) : NULL;
            $review->rating = isset($request->review_rating[$i]) ? $request->review_rating[$i] : NULL;
            $review->source_URL = json_encode(explode(', ',$request->review_source_url[$i]));
            $review->description = isset($request->review_description[$i]) ? $request->review_description[$i] : NULL;
            $review->user_name = isset($request->review_user_name[$i]) ? $request->review_user_name[$i] : NULL;
            $review->save();
        }
    }
    public function updateStatus($request){
        for($i=0;$i<count($request->status_type);$i++){
            $status = new Status();
            $status->rent_details_id = $request->id;
            $status->type = $request->status_type[$i];
            $status->date = isset($request->status_date[$i]) ? date('Y-m-d H:i:s', strtotime($request->status_date[$i])) : NULL;
            $status->source_URL = json_encode(explode(', ',$request->status_source_url[$i]));
            $status->date_seen = json_encode(explode(', ',$request->status_date_seen[$i]));
            $status->save();
        }
    }
    public function propertiesHistory(Request $request){
        $properties = Property::with('owner','site')
            ->where('ParcelCity','LIKE','%'.$request->q.'%')
            ->orWhereHas('owner',function($query) use ($request){
                  $query->where('OwnerName1', 'LIKE', '%' . $request->q . '%');
            })
            ->orWhereHas('site',function($query) use ($request){
                 $query->where('SiteAddress', 'LIKE', '%' . $request->q . '%');
            })
            ->paginate(10);
        $properties->setPath('noo-property-list?q=' . $request->parcelCity);
        $cities = Property::groupBy('ParcelCity')->get();
        return view('page.properties-history',[
            'properties'=>$properties,
            'q'=>$request->q,
            'cities'=>$cities
        ]);
    }
    public function propertyDetails($id){
        $property = Property::with('owner','site')->find($id);
        return view('page.property-details',[
            'property'=> $property,
        ]);
    }
    function street_view_check($url,$size_of_blank_image){
        $str=file_get_contents($url);
        if(strlen($str)==$size_of_blank_image){
            return false;
        }
        return true;
    }
    public function propertyEdit($id){
        $property = Property::with('owner','site')->find($id);
        return view('page.property-edit',[
            'property'=> $property
        ]);
    }
    public function updateProperty(Request $request){
        $property = Property::find($request->Id);
        $property->PropertyGID = $request->PropertyGID;
        $property->ParcelID = $request->ParcelID;
        $property->ParcelLong = $request->ParcelLong;
        $property->TaxAccount = $request->TaxAccount;
        $property->ParcelCity = $request->ParcelCity;
        $property->LegalDesc = $request->LegalDesc;
        $property->X_DD = $request->X_DD;
        $property->Y_DD = $request->Y_DD;
        $property->GeoType = $request->GeoType;
        $property->PropertyUse = $request->PropertyUse;
        $property->ActiveFlag = $request->ActiveFlag;
        $property->CommCommunityID = $request->CommCommunityID;
        $property->IDX_Address = $request->IDX_Address;
        $property->NumberofUnits = $request->NumberofUnits;
        $property->save();

       $owner = Owner::find($request->OwnerId);
       $owner->OwnerName1 = $request->OwnerName1;
       $owner->OwnerName2 = $request->OwnerName2;
       $owner->OwnerAddress = $request->OwnerAddress;
       $owner->OwnerCity = $request->OwnerCity;
       $owner->OwnerState = $request->OwnerState;
       $owner->OwnerZipcode = $request->OwnerZipcode;
       $owner->OwnerStreetNumber = $request->OwnerStreetNumber;
       $owner->OwnerStreetPreDir = $request->OwnerStreetPreDir;
       $owner->OwnerStreetName = $request->OwnerStreetName;
       $owner->OwnerStreetType = $request->OwnerStreetType;
       $owner->OwnerStreetPostDir = $request->OwnerStreetPostDir;
       $owner->OwnerUnit = $request->OwnerUnit;
       $owner->OwnerOccupiedFlag = $request->OwnerOccupiedFlag;
       $owner->OwnerOccupiedCode = $request->OwnerOccupiedCode;
       $owner->save();

       $site = Site::find($request->SiteId);
       $site->SiteAddress = $request->SiteAddress;
       $site->SiteUnit = $request->SiteUnit;
       $site->SiteCity = $request->SiteCity;
       $site->SiteState = $request->SiteState;
       $site->SiteZipCode = $request->SiteZipCode;
       $site->SiteNeighborhood = $request->SiteNeighborhood;
       $site->SiteStreetNumber = $request->SiteStreetNumber;
       $site->SiteStreetPreDir = $request->SiteStreetPreDir;
       $site->SiteStreetName = $request->SiteStreetName;
       $site->SiteStreetType = $request->SiteStreetType;
       $site->SiteStreetPostDir = $request->SiteStreetPostDir;
       $site->save();

        return 1;
    }
    public function inlineRentalEdit(Request $request){
        $rentDetials = RentDetail::find($request->id);
        $rentDetials->country_id = $request->country_id;
        $rentDetials->city_id = $request->city_id;
        $rentDetials->date_added = $request->date_added;
        $rentDetials->date_updated = $request->date_updated;
        $rentDetials->geo_location = $request->geo_location;
        $rentDetials->latitude = $request->latitude;
        $rentDetials->longitude = $request->longitude;
        $rentDetials->save();
        return 1;
    }
    public function inlinePropertylEdit(Request $request){
        $property = Property::find($request->id);
        $property->PropertyGID = $request->PropertyGID;
        $property->save();

        $site = Site::find($request->siteId);
        $site->SiteAddress = $request->SiteAddress;
        $site->SiteCity = $request->SiteCity;
        $site->SiteState = $request->SiteState;
        $site->save();

        $owner = Owner::find($request->ownerId);
        $owner->OwnerName1 = $request->OwnerName1;
        $owner->save();
        return 1;
    }
}
