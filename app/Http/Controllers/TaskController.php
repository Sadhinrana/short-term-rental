<?php

namespace App\Http\Controllers;

use App\HostDetails;
use App\HostGuestReview;
use App\Imports\NooPropertyImport;
use App\Imports\RentImport;
use App\JobInQueue;
use App\MasterProperty;
use App\Region;
use App\RegionListingImage;
use App\RegionListingReview;
use App\RegionListings;
use App\RegionListingScreenshot;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    public function index()
    {
        $data = JobInQueue::where(['is_active' => 1, 'status' => 0])->first();
        if ($data) {
            $data->status = 1;
            $data->save();
            if ($data->property_type == 1) {
                Excel::import(new RentImport, public_path($data->file_url));
            } else if ($data->property_type == 2) {
                Excel::import(new NooPropertyImport, public_path($data->file_url));
            } else if ($data->property_type == 3) {
                $regionsList = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/region/list?key=PROCHAMPS-201904'), true);
                $key = array_search($data->api_id, array_column($regionsList['items'], 'id'));
                $region = $regionsList['items'][$key];
                $region_id = $this->saveRegion($region);
                $this->saveRegionList($data->api_id, $region_id);
            }
            return $data->id;
        } else {
            return 0;
        }
    }

    public function updateStatus($id)
    {
        $data = JobInQueue::find($id);
        $data->status = 2;
        $data->save();
    }

    public function saveRegion($item)
    {
        $dataInfo = [
            'api_id' => $item['id'],
            'latitude' => $item['lat'],
            'longitude' => $item['lng'],
            'name' => $item['name'],
            'type' => $item['type'],
        ];
        $record = Region::where('api_id', $item['id'])->first();
        if (is_null($record)) {
            $data = Region::create($dataInfo);
            return $data->id;
        } else {
            $record->update($dataInfo);
            return $record->id;
        }
    }

    public function saveRegionList($api_id, $region_id)
    {
        $regionListing = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/region/listings?key=PROCHAMPS-201904&id=' . $api_id), true);
        $totalCount = $regionListing['totalCount'];
        $index = ceil($totalCount / 50);
        $count = 0;
        $offset = 0;
        $max = 50;
        for ($i = $count; $i < $index; $i++) {
            $row = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/region/listings?key=PROCHAMPS-201904&id=' . $api_id . '&offset=' . $offset . '&max=' . $max), true);
            foreach ($row['items'] as $item) {
                $dataInfo = [
                    'api_id' => $item['id'],
                    'region_id' => $region_id,
                    'location' => new Point($item['lat'], $item['lng']),
                    'profileUrl' => $item['profileUrl'],
                    'latitude' => $item['lat'],
                    'longitude' => $item['lng'],
                    'hostName' => $item['hostName'],
                    'dateCrawled' => $item['dateCrawled'],
                    'numReviews' => $item['numReviews'],
                    'externalId' => $item['externalId'],
                    'description' => $item['description'],
                    'currencySymbol' => $item['currencySymbol'],
                    'hostId' => $item['hostId'],
                    'source' => $item['source'],
                    'userId' => $item['userId'],
                    'personCapacity' => $item['personCapacity'],
                    'totalImages' => $item['totalImages'],
                    'minNights' => $item['minNights'],
                    'aboutTheHost' => $item['aboutTheHost'],
                    'price' => $item['price'],
                    'detailedAddress' => $item['detailedAddress'],
                    'listingUrl' => $item['listingUrl'],
                    'aboutTheListing' => $item['aboutTheListing'],
                    'currency' => $item['currency'],
                    'roomType' => $item['roomType'],
                ];
                $record = RegionListings::where('api_id', $item['id'])->first();
                if (is_null($record)) {
                    $data = RegionListings::create($dataInfo);
                    $this->saveMasterProperty($data->id);
                    $this->saveListingImage($item['id'],$data->id);
                    $this->listingReview($item['id'],$data->id);
                    $this->listingScreenshots($item['id'],$data->id);
                    $this->hostDetails($data->hostId,$data->id);
                    $this->hostGuestReviews($data->hostId,$data->id);
                } else {
                    $record->update($dataInfo);
                    $this->updateMasterProperty($record);
                    $this->saveListingImage($item['id'],$record->id);
                    $this->listingReview($item['id'],$record->id);
                    $this->listingScreenshots($item['id'],$record->id);
                    $this->hostDetails($record->hostId,$record->id);
                    $this->hostGuestReviews($record->hostId,$record->id);
                }
            }
            $offset = $max + 1;
            $max = $max + 50;
            $count++;
        }
    }

    public function saveMasterProperty($id)
    {
        $regionListing = RegionListings::with('region')->find($id);
        $dataInfo = [
            'region_listings_id' => $id,
            'name' => $regionListing->region->name,
            'latitude' => $regionListing->latitude,
            'longitude' => $regionListing->longitude,
            'URL' => $regionListing->listingUrl,
            'listing_name' => $regionListing->aboutTheListing,
            'room_type' => $regionListing->roomType,
            'price' => $regionListing->price,
            'address' => $regionListing->detailedAddress,
            'no_of_people' => $regionListing->personCapacity,
            'data_source' => "LeaseAbuse Property"
        ];
        MasterProperty::create($dataInfo);
    }

    public function updateMasterProperty($data)
    {
        $record = MasterProperty::where('region_listings_id',$data->id)->first();
        $dataInfo = [
            'region_listings_id' => $data->id,
            'latitude' => $data->latitude,
            'longitude' => $data->longitude,
            'URL' => $data->listingUrl,
            'listing_name' => $data->aboutTheListing,
            'room_type' => $data->roomType,
            'price' => $data->price,
            'address' => $data->detailedAddress,
            'no_of_people' => $data->personCapacity,
            'data_source' => "LeaseAbuse Property"
        ];
        $record->update($dataInfo);
    }
    public function saveListingImage($api_id,$id){
        $data = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/listing/images?key=PROCHAMPS-201904&id='.$api_id),true);
        $totalCount = $data['totalCount'];
        $index = ceil($totalCount/50);
        $count = 0;
        $offset = 0;
        $max = 50;
        for($i=$count;$i<$index;$i++){
            $row = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/listing/images?key=PROCHAMPS-201904&id='.$api_id.'&offset='.$offset.'&max='.$max),true);
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
                    'region_listings_id'=>$id,
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
    function base64_to_image($base64_string,$imageName) {
        $path = "uploads/".$imageName.".jpg";
        if(!file_exists($path)) {
            file_put_contents(public_path($path), base64_decode($base64_string));
        }
        return $path;
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
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($response);
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
        $err = curl_error($curl);
        curl_close($curl);
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
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($response);
    }
    public function listingReview($api_id,$id){
        $data = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/listing/reviews?key=PROCHAMPS-201904&id='.$api_id),true);
        $totalCount = $data['totalCount'];
        $index = ceil($totalCount/50);
        $count = 0;
        $offset = 0;
        $max = 50;
        for($i=$count;$i<$index;$i++){
            $row = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/listing/reviews?key=PROCHAMPS-201904&id='.$api_id.'&offset='.$offset.'&max='.$max),true);
            foreach ($row['items'] as $item){
                $dataInfo = [
                    'api_id'=>$item['id'],
                    'region_listings_id'=>$id,
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
    public function listingScreenshots($api_id,$id){
        $data = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/listing/screenshots?key=PROCHAMPS-201904&id='.$api_id),true);
        $totalCount = $data['totalCount'];
        $index = ceil($totalCount/50);
        $count = 0;
        $offset = 0;
        $max = 50;
        for($i=$count;$i<$index;$i++){
            $row = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/listing/screenshots?key=PROCHAMPS-201904&id='.$api_id.'&offset='.$offset.'&max='.$max),true);
            foreach ($row['items'] as $item){
                $image = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/listing/screenshot?key=PROCHAMPS-201904&id='.$item['id'].'&listingId='.$api_id),true);
                $dataInfo = [
                    'api_id'=>$item['id'],
                    'region_listings_id'=>$id,
                    'index'=>$item['index'],
                    'extension'=>$item['extension'],
                    'type'=>$item['type'],
                    'image'=>$image ? $this->base64_to_image($image['image'],$item['id']) : ''
                ];
                $record = RegionListingScreenshot::where('api_id',$item['id'])->first();
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
    public function hostDetails($hostId,$id){
        $data = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/host/details?key=PROCHAMPS-201904&id='.$hostId),true);
        $images = array();
        foreach ($data['images'] as $image){
            $images[] = $this->base64_to_image($image['thumbnail'],$image['id']);
        }
        $dataInfo=[
            'api_id'=>$data['id'],
            'region_listings_id'=>$id,
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
    public function hostGuestReviews($hostId,$id){
        $data = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/host/guestreviews?key=PROCHAMPS-201904&id='.$hostId),true);
        $totalCount = $data['totalCount'];
        $index = ceil($totalCount/50);
        $count = 0;
        $offset = 0;
        $max = 50;
        for($i=$count;$i<$index;$i++){
            $row = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/host/guestreviews?key=PROCHAMPS-201904&id='.$hostId.'&offset='.$offset.'&max='.$max),true);
            foreach ($row['items'] as $item){
                $dataInfo = [
                    'region_listings_id'=>$id,
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


}
