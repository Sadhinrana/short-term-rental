<?php

namespace App\Http\Controllers;

use App\MasterProperty;
use Illuminate\Http\Request;
use App\RentDetail;
use App\Region;
use App\RegionListings;
use App\RegionListingImage;
use App\RegionListingReview;
use App\RegionListingScreenshot;
use App\HostDetails;
use App\HostGuestReview;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Property;
use Grimzy\LaravelMysqlSpatial\Types\Point;


class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function regionList(Request $request){
        $data = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/region/list?key=PROCHAMPS-201904'), true);
        foreach ($data['items'] as $item){
            $dataInfo =[
                'api_id'=>$item['id'],
                'latitude'=>$item['lat'],
                'longitude'=>$item['lng'],
                'name'=>$item['name'],
                'type'=>$item['type'],
            ];
            $record = Region::where('api_id',$item['id'])->first();
            if (is_null($record)) {
                Region::create($dataInfo);
            } else {
                $record->update($dataInfo);
            }
        }
        return redirect('/region/listings');
    }
    public  function regionListing(Request $request){
        ini_set('max_execution_time', 0);
        if($request->has('api_id')){
            $regions = Region::where('api_id', $request->api_id)->get();
        }else {
            $regions = Region::where('flag', 0)->get();
        }
        foreach ($regions as $region){
            $data = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/region/listings?key=PROCHAMPS-201904&id='.$region->api_id), true);
            $totalCount = $data['totalCount'];
            $index = ceil($totalCount/50);
            $count = 0;
            $offset = 0;
            $max = 50;
            for($i=$count;$i<$index;$i++){
                $row = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/region/listings?key=PROCHAMPS-201904&id='.$region->api_id.'&offset='.$offset.'&max='.$max), true);
                foreach ($row['items'] as $item) {
                    $record = RegionListings::where('api_id',$item['id'])->first();
                    if (is_null($record)) {
                        $insertData = new RegionListings();
                        $insertData->api_id = $item['id'];
                        $insertData->region_id = $region->id;
                        $insertData->location = new Point($item['lat'],$item['lng']);
                        $insertData->profileUrl = $item['profileUrl'];
                        $insertData->latitude = $item['lat'];
                        $insertData->longitude = $item['lng'];
                        $insertData->hostName = $item['hostName'];
                        $insertData->dateCrawled = $item['dateCrawled'];
                        $insertData->numReviews = $item['numReviews'];
                        $insertData->externalId = $item['externalId'];
                        $insertData->description = $item['description'];
                        $insertData->currencySymbol = $item['currencySymbol'];
                        $insertData->hostId = $item['hostId'];
                        $insertData->source = $item['source'];
                        $insertData->userId = $item['userId'];
                        $insertData->personCapacity = $item['personCapacity'];
                        $insertData->totalImages = $item['totalImages'];
                        $insertData->minNights = $item['minNights'];
                        $insertData->aboutTheHost = $item['aboutTheHost'];
                        $insertData->price = $item['price'];
                        $insertData->detailedAddress = $item['detailedAddress'];
                        $insertData->listingUrl = $item['listingUrl'];
                        $insertData->aboutTheListing = $item['aboutTheListing'];
                        $insertData->currency = $item['currency'];
                        $insertData->roomType = $item['roomType'];
                        $insertData->save();
                    } else {
                        $insertData = RegionListings::find($record->id);
                        $insertData->api_id = $item['id'];
                        $insertData->region_id = $region->id;
                        $insertData->location = new Point($item['lat'],$item['lng']);
                        $insertData->profileUrl = $item['profileUrl'];
                        $insertData->latitude = $item['lat'];
                        $insertData->longitude = $item['lng'];
                        $insertData->hostName = $item['hostName'];
                        $insertData->dateCrawled = $item['dateCrawled'];
                        $insertData->numReviews = $item['numReviews'];
                        $insertData->externalId = $item['externalId'];
                        $insertData->description = $item['description'];
                        $insertData->currencySymbol = $item['currencySymbol'];
                        $insertData->hostId = $item['hostId'];
                        $insertData->source = $item['source'];
                        $insertData->userId = $item['userId'];
                        $insertData->personCapacity = $item['personCapacity'];
                        $insertData->totalImages = $item['totalImages'];
                        $insertData->minNights = $item['minNights'];
                        $insertData->aboutTheHost = $item['aboutTheHost'];
                        $insertData->price = $item['price'];
                        $insertData->detailedAddress = $item['detailedAddress'];
                        $insertData->listingUrl = $item['listingUrl'];
                        $insertData->aboutTheListing = $item['aboutTheListing'];
                        $insertData->currency = $item['currency'];
                        $insertData->roomType = $item['roomType'];
                        $insertData->save();
                    }
                }
                $offset = $max+1;
                $max = $max+50;
                $count++;
            }
            $this->updateRegionFlag($region->id);
        }
        return redirect('/listing/details');
    }
    public function regionListingDetails(){
        ini_set('max_execution_time', 0);
        $regionListings = RegionListings::where('flag',0)->get();
        foreach ($regionListings as $region) {
            $this->listingImages($region);
            $this->listingReviews($region);
            $this->listingScreenshots($region);
            $this->hostDetails($region);
            $this->hostGuestReviews($region);
            $this->updateRegionListingFlag($region->id);
        }
        return 'Successfully Inserted';
    }
    public function listingImages($region){
        ini_set('max_execution_time', 0);
        $data = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/listing/images?key=PROCHAMPS-201904&id='.$region->api_id),true);
        $totalCount = $data['totalCount'];
        $index = ceil($totalCount/50);
        $count = 0;
        $offset = 0;
        $max = 50;
        for($i=$count;$i<$index;$i++){
            $row = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/listing/images?key=PROCHAMPS-201904&id='.$region->api_id.'&offset='.$offset.'&max='.$max),true);
            $i=10;
            foreach ($row['items'] as $item){
                $image = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/listing/image?key=PROCHAMPS-201904&id='.$item['id']),true);
                if($image){
                    $image_url = $this->base64_to_image($image['image'],$item['id']);
                    $image = url($image_url);
                    $object = $this->image_object($image);
                    $image_object = !empty($object->responses[0]) ? json_encode($object->responses[0]):'';
                    $labels = $this->image_labels($image);
                    $image_labels = !empty($labels->responses[0]) ? json_encode($labels->responses[0]):'';
                    $text = $this->image_text($image);
                    $image_text = !empty($text->responses[0]) ? json_encode($text->responses[0]):'';
                }else{
                    $image_url = '';
                    $image_object = '';
                    $image_labels = '';
                    $image_text = '';
                }
                $dataInfo= [
                    'api_id'=>$item['id'],
                    'region_listings_id'=>$region->id,
                    'caption'=>$item['caption'],
                    'index'=>$item['index'],
                    'extension'=>$item['extension'],
                    'image'=>$image_url,
                    'image_object'=>$image_object,
                    'image_labels'=>$image_labels,
                    'image_text'=>$image_text
                ];
                $record = RegionListingImage::where('api_id',$item['id'])->first();
                if (is_null($record)) {
                    RegionListingImage::create($dataInfo);
                } else {
                    $record->update($dataInfo);
                }
                $i++;
            }
            $offset = $max+1;
            $max = $max+50;
            $count++;
        }
    }
    private function image_object($image){
        $postData['requests'] = [
            'features' => [
                'type' => 'OBJECT_LOCALIZATION',
            ],
            'image' => [
                'source' => [
                    'imageUri' => $image
                ]
            ],
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://vision.googleapis.com/v1/images:annotate?key=AIzaSyDE2i7RPzDbo7CajfIwJG2XOsRna7a9n70",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($postData, true),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        return json_decode($response);
//        $err = curl_error($curl);
//        curl_close($curl);
//
//        $tagAll = '';
//        if (!$err) {
//            $response = json_decode($response, true);
//            $x = 0;
//            foreach ($response['responses'][0]['webDetection']['webEntities'] as $val) {
//                if (isset($val['description'])) {
//                    $coma = ($x != 0) ? ', ' : '';
//                    $tagAll .= $val['description'] . $coma;
//
//                    if ($x > 2) {
//                        break;
//                    }
//                    $x++;
//                }
//            }
//        }
//        return $tagAll;
    }
    private function image_labels($image){
        $postData['requests'] = [
            'features' => [
                'type' => 'LABEL_DETECTION',
            ],
            'image' => [
                'source' => [
                    'imageUri' => $image
                ]
            ],
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://vision.googleapis.com/v1/images:annotate?key=AIzaSyDE2i7RPzDbo7CajfIwJG2XOsRna7a9n70",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($postData, true),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        return json_decode($response);
    }
    private function image_text($image){
        $postData['requests'] = [
            'features' => [
                'type' => 'DOCUMENT_TEXT_DETECTION',
            ],
            'image' => [
                'source' => [
                    'imageUri' => $image
                ]
            ],
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://vision.googleapis.com/v1/images:annotate?key=AIzaSyDE2i7RPzDbo7CajfIwJG2XOsRna7a9n70",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($postData, true),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        return json_decode($response);
    }

    public function listingReviews($region){
        $data = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/listing/reviews?key=PROCHAMPS-201904&id='.$region->api_id),true);
        $totalCount = $data['totalCount'];
        $index = ceil($totalCount/50);
        $count = 0;
        $offset = 0;
        $max = 50;
        for($i=$count;$i<$index;$i++){
            $row = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/listing/reviews?key=PROCHAMPS-201904&id='.$region->api_id.'&offset='.$offset.'&max='.$max),true);
            foreach ($row['items'] as $item){
                $dataInfo = [
                    'api_id'=>$item['id'],
                    'region_listings_id'=>$region->id,
                    'comments'=>$item['comments'],
                    'commentsResponseDate'=>$item['commentsResponseDate'],
                    'reviewer'=>$item['reviewer'],
                    'reviewDate'=>$item['reviewDate'],
                    'reviewerPhoto'=>$this->base64_to_image($item['reviewerPhoto'],$item['id'])
                ];
                $record = RegionListingReview::where('api_id',$item['id'])->first();
                if (is_null($record)) {
                    RegionListingReview::create($dataInfo);
                } else {
                    $record->update($dataInfo);
                }
            }
            $offset = $max+1;
            $max = $max+50;
            $count++;
        }
    }
    public function listingScreenshots($region){
        $data = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/listing/screenshots?key=PROCHAMPS-201904&id='.$region->api_id),true);
        $totalCount = $data['totalCount'];
        $index = ceil($totalCount/50);
        $count = 0;
        $offset = 0;
        $max = 50;
        for($i=$count;$i<$index;$i++){
            $row = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/listing/screenshots?key=PROCHAMPS-201904&id='.$region->api_id.'&offset='.$offset.'&max='.$max),true);
            foreach ($row['items'] as $item){
                $image = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/listing/screenshot?key=PROCHAMPS-201904&id='.$item['id'].'&listingId='.$region->api_id),true);
                $dataInfo = [
                    'api_id'=>$region['id'],
                    'region_listings_id'=>$region->id,
                    'index'=>$item['index'],
                    'extension'=>$item['extension'],
                    'type'=>$item['type'],
                    'image'=>$image ? $this->base64_to_image($image['image'],$item['id']) : ''
                ];
                $record = RegionListingScreenshot::where('api_id',$region['id'])->first();
                if (is_null($record)) {
                    RegionListingScreenshot::create($dataInfo);
                } else {
                    $record->update($dataInfo);
                }
            }
            $offset = $max+1;
            $max = $max+50;
            $count++;
        }
    }
    public function hostDetails($region){
        $data = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/host/details?key=PROCHAMPS-201904&id='.$region->hostId),true);
        $images = array();
        foreach ($data['images'] as $image){
            $images[] = $this->base64_to_image($image['thumbnail'],$image['id']);
        }
        $dataInfo=[
            'api_id'=>$data['id'],
            'region_listings_id'=>$region->id,
            'userId'=>$data['userId'],
            'name'=>$data['name'],
            'profileUrl'=>$data['profileUrl'],
            'about'=>$data['about'],
            'address'=>$data['address'],
            'memberSince'=>$data['memberSince'],
            'isVerifiedId'=>$data['isVerifiedId'],
            'image'=>json_encode($images),
            'profileFields'=>json_encode($data['profileFields'])
        ];
        $record = HostDetails::where('api_id',$data['id'])->first();
        if (is_null($record)) {
            HostDetails::create($dataInfo);
        } else {
            $record->update($dataInfo);
        }
    }
    public function hostGuestReviews($region){
        $data = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/host/guestreviews?key=PROCHAMPS-201904&id='.$region->hostId),true);
        $totalCount = $data['totalCount'];
        $index = ceil($totalCount/50);
        $count = 0;
        $offset = 0;
        $max = 50;
        for($i=$count;$i<$index;$i++){
            $row = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/host/guestreviews?key=PROCHAMPS-201904&id='.$region->hostId.'&offset='.$offset.'&max='.$max),true);
            foreach ($row['items'] as $item){
                $dataInfo = [
                    'region_listings_id'=>$region->id,
                    'api_id'=>$item['id'],
                    'fromHostUrl'=>$item['fromHostUrl'],
                    'fromHostName'=>$item['fromHostName'],
                    'createdOn'=>$item['createdOn'],
                    'relationship'=>$item['relationship'],
                    'content'=>$item['content']
                ];
                $record = HostGuestReview::where('api_id',$item['id'])->first();
                if (is_null($record)) {
                    HostGuestReview::create($dataInfo);
                } else {
                    $record->update($dataInfo);
                }
            }
            $offset = $max+1;
            $max = $max+50;
            $count++;
        }
    }
    public function updateRegionFlag($id){
        $region = Region::find($id);
        $region->flag = 1;
        $region->save();
    }
    public function updateRegionListingFlag($id){
        $regionListing = RegionListings::find($id);
        $regionListing->flag = 1;
        $regionListing->save();
    }
    function base64_to_image($base64_string,$imageName) {
        $path = "uploads/".$imageName.".jpg";
        if(!file_exists($path)) {
            file_put_contents($path, base64_decode($base64_string));
        }
        return $path;
    }
    public function regionHistory(Request $request){
        $regions = RegionListings::with('region')
            ->where('hostName','LIKE','%'.$request->q.'%')
            ->orWhere('source','LIKE','%'.$request->q.'%')
            ->orWhereHas('region',function($query) use ($request){
                $query->where('name','LIKE','%'.$request->q.'%');
                $query->orWhere('type','LIKE','%'.$request->q.'%');
            })
            ->paginate(20);
        if($request->q) {
            $regions->setPath('leaseabuse-property-list?q=' . $request->q);
        }
        return view('page.region-history',[
            'regions'=>$regions,
            'keywords'=>$request->q
        ]);
    }
    public function regionDetails(Request $request,$id){
        $details = RegionListings::with('region','review','region_listing_image','region_listing_screeshot')->find($id);
        $items = $details['review'];
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // Create a new Laravel collection from the array data
        $itemCollection = collect($items);
        // Define how many items we want to be visible in each page
        $perPage = 10;
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        // Create our paginator and pass it to the view
        $reviews= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        // set url path for generted links
        $reviews->setPath($request->url());
        if($request->ajax()){
            if($request->has('image_id')){
                $imageDescription = RegionListingImage::find($request->image_id);
                $masterProperty = MasterProperty::find($request->id);
                return view('page.primary-image',[
                    'imageDescription'=>$imageDescription,
                    'region_listins_id'=>$masterProperty->region_listings_id
                ]);
            }
            return view('page.region-listing-review',[
                'details'=>$details,
                'reviews'=>$reviews
            ]);
        }
        return view('page.region-details',[
            'details'=>$details,
            'reviews'=>$reviews
        ]);
    }
    public function inlineRegionEdit(Request $request){
        $region = Region::find($request->region_id);
        $region->latitude = $request->latitude;
        $region->longitude = $request->longitude;
        $region->name = $request->name;
        $region->type = $request->type;
        $region->save();

        $regionListings = RegionListings::find($request->id);
        $regionListings->hostName = $request->host_name;
        $regionListings->price = $request->price;
        $regionListings->source = $request->source;
        $regionListings->save();
        return 1;
    }
    public function region(){
        $regions = Region::get();
        return view('page.regions',[
            'regions'=>$regions
        ]);
    }
    public function PropertyMap(Request $request){
        if($request->ajax()) {
            $properties = Property::all();
            foreach ($properties as $row) {
                $data[] = array(
                    'type' => 'Feature',
                    'geometry' => array(
                        'type' => "Point",
                        'coordinates' => [$row->X_DD,$row->Y_DD]
                    ),
                    'properties' => array(
                        'title' => $row->IDX_Address,
                        'icon'=> 'monument'
                    ),
                );
            }
            return response()->json($data);
        }
        return view('page.show-property-map');
    }
    public function UploadCustomeImage(Request $request){
        if ($request->has('file')) {
            $image = $request->file('file');
            $image_name = $request->PropertyGID.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $image->move($destinationPath,$image_name);
            $image_url = 'uploads/'.$image_name;

            $object = $this->image_object(url($image_url));
            $image_object = !empty($object->responses[0]) ? json_encode($object->responses[0]):'';
            $labels = $this->image_labels(url($image_url));
            $image_labels = !empty($labels->responses[0]) ? json_encode($labels->responses[0]):'';
            $text = $this->image_text(url($image_url));
            $image_text = !empty($text->responses[0]) ? json_encode($text->responses[0]):'';

            $property = Property::find($request->id);
            $property->image = $image_url;
            $property->image_object = $image_object;
            $property->image_labels = $image_labels;
            $property->image_text = $image_text;
            $property->save();
            return back();
        }
    }
}
