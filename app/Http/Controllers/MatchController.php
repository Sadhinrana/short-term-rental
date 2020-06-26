<?php

namespace App\Http\Controllers;

use DB;
use App\FcmToken;
use App\Property;
use App\MatchProperty;
use App\MasterProperty;
use App\DatafinitiImage;
use tineye\api\TinEyeApi;
use App\RegionListingImage;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Image;

class MatchController extends Controller
{
    public function getNooProperty($id, $index, Request $request)
    {
        $masterProperty = MasterProperty::find($id);
        $origLat = $masterProperty->latitude;
        $origLon = $masterProperty->longitude;
        $properties = DB::select("SELECT properties.Id as propertyId,OwnerId, IDX_Address, Y_DD, X_DD,image,OwnerName1,OwnerAddress,OwnerCity,OwnerState,OwnerZipcode,SiteAddress,SiteCity,SiteState,SiteZipCode, ( 6371 * acos( cos( radians($origLat) ) * cos( radians( Y_DD ) ) * cos( radians( X_DD ) - radians($origLon) ) + sin( radians($origLat) ) * sin(radians(Y_DD)) ) ) AS distance  FROM  properties JOIN  owners ON owners.Id = properties.OwnerId JOIN sites on sites.Id = properties.SiteId HAVING     distance < 1.5  ORDER BY  distance");

        if ($index > 0 && $request->vote) {
            $isMatch = MatchProperty::where('masterPropertyID', $id)->where('nooPropertyID', $properties[$index]->propertyId)->where('user_id', Auth::user()->id)->where('vote', 1)->first();
            if (is_null($isMatch)) {
                $data = [
                    'masterPropertyID'    => $id,
                    'nooPropertyID'       => $properties[$index]->propertyId,
                    'nooPropertyTitle'    => $properties[$index]->IDX_Address,
                    'masterPropertyTitle' => $masterProperty->listing_name,
                    'nooPropertyLat'      => $properties[$index]->Y_DD,
                    'nooPropertylng'      => $properties[$index]->X_DD,
                    'masterPropertylat'   => $masterProperty->latitude,
                    'masterPropertylng'   => $masterProperty->longitude,
                    'vote'                => $request->type,
                    'user_id'             => Auth::user()->id,
                    'comments'            => $request->comment
                ];
                MatchProperty::create($data);
                $serviceAccount = ServiceAccount::fromJsonFile(public_path('FirebaseKey.json'));
                $factory = (new Factory)
                    ->withServiceAccount($serviceAccount);
                $database = $factory->createDatabase();
                $database->getReference('matchProperty')
                    ->push($data);
            }
        }

        $property = [];

        if (count($properties) > 0) {
            $property = $properties[$index];
        }
        return response()->json([
            'total_found' => count($properties),
            'property' => $property,
            'map_data' => $this->getSearchedPropertyClusterData($masterProperty, $properties, $request->index)
        ]);
    }

    public function yesVote(Request $request)
    {
        $imageData = $request->get('picture');

        if($imageData) {
            $fileName =   Carbon::now()->timestamp . '_' . uniqid() . '.' .explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($request->get('picture'))->save(public_path('uploads/comment-image/') . $fileName);
            $image_url =  'uploads/comment-image/' . $fileName;
        }else{
            $image_url =  '';
        }

        $masterProperty = MasterProperty::find($request->id);
        $origLat        = $masterProperty->latitude;
        $origLon        = $masterProperty->longitude;
        $properties     = DB::select("SELECT  properties.id as propertyId,OwnerId, IDX_Address, Y_DD, X_DD,image,OwnerName1,OwnerAddress,OwnerCity,OwnerState,OwnerZipcode, ( 6371 * acos( cos( radians($origLat) ) * cos( radians( Y_DD ) ) * cos( radians( X_DD ) - radians($origLon) ) + sin( radians($origLat) ) * sin(radians(Y_DD)) ) ) AS distance  FROM  properties JOIN  owners ON owners.id = properties.OwnerId  HAVING     distance < 1.5  ORDER BY  distance LIMIT 5000");
        $isMatch        = MatchProperty::where('masterPropertyID', $request->id)->where('user_id', Auth::user()->id)->where('vote', 3)->first();
        $data = [
            'masterPropertyID'    => $request->id,
            'nooPropertyID'       => $properties[$request->index]->propertyId,
            'nooPropertyTitle'    => $properties[$request->index]->IDX_Address,
            'masterPropertyTitle' => $masterProperty->listing_name,
            'nooPropertyLat'      => $properties[$request->index]->Y_DD,
            'nooPropertylng'      => $properties[$request->index]->X_DD,
            'masterPropertylat'   => $masterProperty->latitude,
            'masterPropertylng'   => $masterProperty->longitude,
            'vote'                => 3,
            'user_id'             => Auth::user()->id,
            'comments'            => $request->comment,
            'picture'             =>$image_url
        ];
        if (is_null($isMatch)) {
            MatchProperty::create($data);
            $serviceAccount = ServiceAccount::fromJsonFile(public_path('FirebaseKey.json'));
            $factory = (new Factory)
                ->withServiceAccount($serviceAccount);

            $database = $factory->createDatabase();
            $database->getReference('matchProperty')
                ->push($data);
        }else{
            MatchProperty::where('id',$isMatch->id)->update($data);
        }

        $tokens = FcmToken::all()->pluck('fcm_token')->toArray();
        $post = array(
            "registration_ids" => $tokens,
            "data" => $data
        );
        $this->fcmFire($post);
    }

    private function fcmFire($post)
    {
        $post['data']['tag'] = [];
        $post['data']['tag'] = uniqid();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => json_encode($post, true),
            CURLOPT_HTTPHEADER     => array(
                "authorization:key=AAAAeuTdQsk:APA91bE07kj8qG_YmwWmHXsNKTEMUts7X82sXvsA_IGgTsvX4Bdm1qNgFqmr7e7cC9TjDgj7DOcEZS6eceePk9yjee4ZeTYGS9xYqaZboStmW-1DGMXhLSSRs2H7An6_1VRA7N_QmrOf",
                "content-type:application/json",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }

    public function MatchPropertyByID($id)
    {
        $property = MatchProperty::with('masterProperty')->find($id);

        if ($property->masterProperty->rent_details_id) {
            $masterPropertyImage = DatafinitiImage::where('rent_id', $property->masterProperty->rent_details_id)->first();
        } else {
            $masterPropertyImage = '';
        }

        $nooProperty = Property::with('owner')->find($property->nooPropertyID);
        $data = array(
            'id'                  => $property->id,
            'MasterPropertyTitle' => $property->masterPropertyTitle,
            'NooPropertyTitle'    => $property->nooPropertyTitle,
            'MasterPropertyImage' => $masterPropertyImage ? $masterPropertyImage->image : '',
            'NooPropertyImage'    => '/' . $nooProperty->image,
            'vote'                => $property->vote,
            'name'                => $property->masterProperty->name,
            'roomType'            => $property->masterProperty->room_type,
            'num_bedroom'         => $property->masterProperty->num_bedroom,
            'no_of_bathroom'      => $property->masterProperty->no_of_bathroom,
            'OwnerName1'          => $nooProperty->OwnerName1,
            'OwnerAddress'        => $nooProperty->owner->OwnerAddress,
            'OwnerCity'           => $nooProperty->owner->OwnerCity,
            'OwnerState'          => $nooProperty->owner->OwnerState,
            'OwnerZipcode'        => $nooProperty->owner->OwnerZipcode,
        );
        return response()->json($data);
    }

    public function UpdateVote($id, $type)
    {
        $matchProperty = MatchProperty::find($id);
        $matchProperty->vote = $type;
        $matchProperty->save();
    }

    public function MasterProperty($id)
    {
        $masterProperty   = MasterProperty::find($id);

        $previousProperty = MasterProperty::where('id', '<', $id)->max('id');
        $nextProperty     = MasterProperty::where('id', '>', $id)->min('id');

        if ($masterProperty->region_listings_id) {
            $images = RegionListingImage::where('region_listings_id', $masterProperty->region_listings_id)->get();
        } else if ($masterProperty->rent_details_id) {

            $images = DatafinitiImage::where('rent_id', $masterProperty->rent_details_id)->get();
        }
        $numberArr = [];
        $visionResult = [];

        if (!empty($numberArr)) {
            $number = implode(",", $numberArr);
        } else {
            $number = '';
        }
        return response()->json([
            'masterProperty'   => $masterProperty,
            'nextProperty'     => $nextProperty,
            'previousProperty' => $previousProperty,
            'images'           => $images,
            'number'           => $number,
            'visionResult'     => $visionResult
        ]);
    }


    public function getVisionResult($masterPropertyId)
    {
        $masterProperty = MasterProperty::find($masterPropertyId);

        $previousProperty = MasterProperty::where('id', '<', $masterPropertyId)->max('id');
        $nextProperty = MasterProperty::where('id', '>', $masterPropertyId)->min('id');

        if ($masterProperty->region_listings_id) {
            $images = RegionListingImage::where('region_listings_id', $masterProperty->region_listings_id)->get();
        } else if ($masterProperty->rent_details_id) {

            $images = DatafinitiImage::where('rent_id', $masterProperty->rent_details_id)->get();
        }

        $numberArr = [];
        $visionResult = [];

        foreach($images as $img) {
            $detectText = $this->detect_text($img->image);
            if(! isset($detectText->responses[0]->error)) {
                if (isset($detectText->responses[0]->textAnnotations[0])) {
                    $findNumber = $this->extract_numbers($detectText->responses[0]->textAnnotations[0]->description);
                    $visionResult[] = array(
                        'image'  => $img->image,
                        'text'   => $detectText->responses[0]->textAnnotations[0]->description,
                        'number' => $findNumber ? implode(",",$findNumber) : '',
                    );
                    if($findNumber){
                        $numberArr[] = implode(",", $findNumber);
                    }
                }
            }
        }

        if (!empty($numberArr)) {
            $number = implode(",", $numberArr);
        } else {
            $number = '';
        }

        return [
            'number'           => $number,
            'visionResult'     => $visionResult
        ];
    }

    //atik's code

    private $private_API_Key = "HKg9AXsao-8+wYz=_NOy4jgbyZW6W5h6sjNSeN+e";
    private $public_API_Key  = "8jsbrhP_^sz.P3_6fnig";

    public function getReverseImageResult(Request $r)
    {
        return $tineyeapi = (new TinEyeApi($this->private_API_Key,$this->public_API_Key))->searchUrl($r->imgUrl);
    }

    //end atik's code

    public function NooPropertyData(Request $request)
    {
        $masterProperty = MasterProperty::find($request->id);

        $data[] = array(
            'type' => 'Feature',
            'pId'  => $masterProperty->id,
            'geometry' => array(
                'type'        => "Point",
                'coordinates' => [$masterProperty->longitude, $masterProperty->latitude]
            ),
            'properties' => array(
                'description' => '<strong>'. $masterProperty->SiteAddress .'</strong>',
                'modelId' => 2,
                'icon'    => 'harbor'
            ),
        );

        $origLat = $masterProperty->latitude;
        $origLon = $masterProperty->longitude;
        $nooProperty = DB::select("SELECT properties.Id, OwnerId, SiteAddress, IDX_Address, Y_DD, X_DD,image, ( 6371 * acos( cos( radians($origLat) ) * cos( radians( Y_DD ) ) * cos( radians( X_DD ) - radians($origLon) ) + sin( radians($origLat) ) * sin(radians(Y_DD)) ) ) AS distance  FROM  properties  JOIN sites on sites.Id = properties.SiteId HAVING     distance < 1.5  ORDER BY  distance");

        foreach($nooProperty as $key=>$row) {
            if($request->index==$key){
                $data[] = array(
                    'type' => 'Feature',
                    'pId' => $row->Id,
                    'geometry' => array(
                        'type' => "Point",
                        'coordinates' => [$row->X_DD, $row->Y_DD]
                    ),
                    'properties' => array(
                        'description' => '<strong>'. $row->SiteAddress .'</strong>',
                        'id'=>$key,
                        'modelId' => 3,
                    ),
                );
            }
            $data[] = array(
                'type' => 'Feature',
                'pId' => $row->Id,
                'geometry' => array(
                    'type' => "Point",
                    'coordinates' => [$row->X_DD, $row->Y_DD]
                ),
                'properties' => array(
                    'description' => '<strong>'. $row->SiteAddress .'</strong>',
                    'id'=>$key,
                    'modelId' => 1,
                ),
            );
        }
        return response()->json($data);
    }

    public function detect_text($image){
        $postData['requests'] = [
            'features' => [
                'type' => 'TEXT_DETECTION',
            ],
            'image' => [
                'source' => [
                    'imageUri' => url($image)
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

    function extract_numbers($string)
    {
        preg_match_all('/([\d]+)/', $string, $match);
        return $match[0];
    }

    /**
     * [searchNOOPropertyByStreet Search NOO Properties by street name and number]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function searchNOOPropertyByStreet(Request $request)
    {
        $propertyIndex = 0;

        $masterProperty = MasterProperty::find($request->masterPropertyId);
        $origLat = $masterProperty->latitude;
        $origLon = $masterProperty->longitude;

        $query = "SELECT properties.Id as propertyId,OwnerId, IDX_Address, Y_DD, X_DD,image,OwnerName1,OwnerAddress,OwnerCity,OwnerState,OwnerZipcode,SiteAddress,SiteCity,SiteState,SiteZipCode, ( 6371 * acos( cos( radians($origLat) ) * cos( radians( Y_DD ) ) * cos( radians( X_DD ) - radians($origLon) ) + sin( radians($origLat) ) * sin(radians(Y_DD)) ) ) AS distance FROM  properties JOIN  owners ON owners.Id = properties.OwnerId JOIN sites on sites.Id = properties.SiteId";

        if ($request->StreetNo != null && $request->StreetName != null) {
            $query .= ' WHERE sites.SiteAddress LIKE "%' . $request->StreetNo . '%"';
            $query .= ' OR sites.SiteAddress LIKE "%' . $request->StreetName . '%"';
        } else {

            if ($request->StreetNo != null) {
                $query .= ' WHERE sites.SiteAddress LIKE "%' . $request->StreetNo . '%"';
            }

            if ($request->StreetName != null) {
                $query .= ' AND sites.SiteAddress LIKE "%' . $request->StreetName . '%"';
            }

            if ($request->HasPool == 'true') {
                $query .= ' AND properties.HasPool = 1';
            }
        }

        $query .= ' HAVING distance < 1.5 ORDER BY  distance';

        $properties = DB::select($query);

        if (isset($request->propertyIndex)) {
            $propertyIndex = $request->propertyIndex;
        }

        $property = [];

        if (count($properties) > 0) {
            $property = $properties[$propertyIndex];
        }

        return response()->json([
            'total_found' => count($properties),
            'property' => $property,
            'map_data' => $this->getSearchedPropertyClusterData($masterProperty, $properties, $propertyIndex)
        ]);
    }

    public function getSearchedPropertyClusterData($masterProperty, $properties, $index) {

        $data[] = array(
            'type' => 'Feature',
            'pId'  => $masterProperty->id,
            'geometry' => array(
                'type'        => "Point",
                'coordinates' => [$masterProperty->longitude, $masterProperty->latitude]
            ),
            'properties' => array(
                'description' => '<strong>'. $masterProperty->SiteAddress .'</strong>',
                'modelId'     => 2,
                'icon'        => 'harbor'
            ),
        );

        foreach($properties as $key => $row) {
            if($index == $key){
                $data[] = array(
                    'type' => 'Feature',
                    'pId'  => $row->propertyId,
                    'geometry' => array(
                        'type'        => "Point",
                        'coordinates' => [$row->X_DD, $row->Y_DD]
                    ),
                    'properties' => array(
                        'description' => '<strong>'. $row->SiteAddress .'</strong>',
                        'id'          =>$key,
                        'modelId'     => 3,
                    ),
                );
            }
            $data[] = array(
                'type' => 'Feature',
                'pId'  => $row->propertyId,
                'geometry' => array(
                    'type'        => "Point",
                    'coordinates' => [$row->X_DD, $row->Y_DD]
                ),
                'properties' => array(
                    'description' => '<strong>'. $row->SiteAddress .'</strong>',
                    'id'          =>$key,
                    'modelId'     => 1,
                ),
            );
        }

        return $data;
    }
}
