<?php

namespace App\Http\Controllers;

use App\DatafinitiImage;
use App\Exports\CommunityExport;
use App\Exports\NOOPropertyExport;
use App\MatchProperty;
use App\Property;
use App\RegionListingImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\RentDetail;
use App\MasterProperty;
use App\RegionListings;
use App\Place;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use App\Deposit;
use App\Description;
use App\Feature;
use App\Fee;
use App\People;
use App\Price;
use App\Review;
use App\Status;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Maatwebsite\Excel\Facades\Excel;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $sql = MasterProperty::groupBy('name');
        if (role() == false) {
            $sql->join('user_communities', function ($q) {
                $q->on('user_communities.community', '=', 'master_properties.name')
                    ->where('user_communities.user_id', auth()->id());
            });
        }
        $regions = $sql->orderBY('name', 'ASC')->get();

        $roomTypes = MasterProperty::groupBy('room_type')->where('room_type', '!=', null)->get();

        $sql = MasterProperty::select("master_properties.*")->where(function ($q) use ($request) {
            if ($request->region_name) {
                $q->where('master_properties.name', '=', $request->region_name);
            }
            if ($request->room_type) {
                $q->whereIn('master_properties.room_type', $request->room_type);
            }
        });

        if ($request->match) {
            $sql->join('match_properties', function ($q) use ($request) {
                $q->on('match_properties.masterPropertyID', '=', 'master_properties.id')
                    ->where('match_properties.vote', $request->match);
            });
        }
        if (role() == false) {
            $sql->join('user_communities', function ($q) {
                $q->on('user_communities.community', '=', 'master_properties.name')
                    ->where('user_communities.user_id', auth()->id());
            });
        }
        $masterProperty = $sql->paginate(10);
        $roomType = '';
        if (!empty($request->room_type)) {
            foreach ($request->room_type as $rm) {
                $roomType .= '&room_type[]=' . $rm;
            }
        }
        $masterProperty->setPath('master-property?region_name=' . $request->region_name . '&match=' . $request->match . $roomType);
        return view('page/master-property', [
            'masterProperty' => $masterProperty,
            'regions' => $regions,
            'room_types' => $roomTypes,
            'region_name' => $request->region_name,
            'room_type' => (!empty($request->room_type)) ? $request->room_type : [],
            'match' => $request->match
        ]);
    }

    /* Start Atik's function */
    public function getAnalyticalView()
    {
        $community = MasterProperty::select('name', \DB::raw('GROUP_CONCAT(id) AS proIds'))->groupBy('name')->get();
        $communities = [];
        foreach ($community as $com) {
            $pro_ids = explode(",", $com->proIds);
            $obj = [];
            $mall = MatchProperty::whereIn('masterPropertyID', $pro_ids)->get();
            $obj['ids'] = $com->proIds;
            $obj['name'] = $com->name;
            $obj['matched'] = 0;
            $obj['mismatched'] = 0;
            foreach ($mall as $mal) {
                if ($mal->vote == 3) $obj['matched']++;
                elseif ($mal->vote == 1) $obj['mismatched']++;
            }
            $communities[] = $obj;
        }
        return view('page.analytical-view')
            ->with('communities', $communities);
    }


    /* End  Atik's function */
    public function matchPropertyLineGraph(Request $request)
    {
        $pro_ids = explode(",", $request->id);
        $mall = MatchProperty::whereIn('masterPropertyID', $pro_ids)
            ->select(DB::raw('DATE(created_at) as date'))
            ->groupBy('date')
            ->get();
        $mismatched = [];
        foreach ($mall as $row) {
            $date = explode("-", date('Y-m-d', strtotime($row->date)));
            $mismatchedVote = MatchProperty::whereDate('created_at', '=', $row->date)->where('vote', '=', 1)->count();
            $matchVote = MatchProperty::whereDate('created_at', '=', $row->date)->where('vote', '=', 3)->count();
            $mismatched[] = array(
                'day' => $date[2] - 0,
                'month' => $date[1] - 1,
                'year' => $date[0] - 0,
                'vote' => $mismatchedVote,
            );
            $matched[] = array(
                'day' => $date[2] - 0,
                'month' => $date[1] - 1,
                'year' => $date[0] - 0,
                'vote' => $matchVote,
            );
            $total[] = array(
                'day' => $date[2] - 0,
                'month' => $date[1] - 1,
                'year' => $date[0] - 0,
                'vote' => $mismatchedVote+$matchVote
            );
        }
        return view('page.match-property-line-graph', [
            'ids' => $request->id,
            'mismatched' => $mismatched,
            'matched'=>$matched,
            'total'=>$total
        ]);
    }
    public function CombineData()
    {
        ini_set('max_execution_time', 0);
        $rentDetails = RentDetail::with('city', 'price')->get();
        $regions = [];
        foreach ($rentDetails as $index => $row) {
            $data = [
                'rent_details_id' => $row->id,
                'name' => $row->city->city_name,
                'latitude' => $row->latitude,
                'longitude' => $row->longitude,
                'URL' => $row->source_URL,
                'listing_name' => $row->listing_name,
                'room_type' => $row->property_type,
                'floor_size_value' => $row->lot_size_value,
                'floor_size_unit' => $row->lot_size_unit,
                'price' => $row->price['amount_max'],
                'address' => $row->address,
                'no_of_people' => $row->num_people,
                'no_of_bathroom' => $row->num_bathroom,
                'num_bedroom' => $row->num_bedroom,
                'num_floor' => $row->num_floor,
                'num_room' => $row->num_room,
                'data_source' => "Datafiniti Property"
            ];
            $record = MasterProperty::where('rent_details_id', $row->id)->first();
            if (is_null($record)) {
                MasterProperty::create($data);
            } else {
                $record->update($data);
            }
        }
//        for($i=0;$i<count($regions);$i++){
//            $record = Place::where('name',$regions[$i]['name'])->first();
//            if (is_null($record)) {
//                $place = new Place();
//                $place->name = $regions[$i]['name'];
//                $place->location = new Point(40.7484404, -73.9878441);    // (lat, lng)
//                $place->area = new Polygon([new LineString($points[$i])]);
//                $place->save();
//            } else {
//                $place = Place::find($record->id);
//                $place->name = $regions[$i]['name'];
//                $place->location = new Point(40.7484404, -73.9878441);    // (lat, lng)
//                $place->location = new Polygon([new LineString($points[$i])]);
//                return(new Polygon([new LineString($points[$i])]));
//                $place->save();
//            }
//
//        }
        $regionListings = RegionListings::with('region')->get();
        foreach ($regionListings as $row) {
            $data = [
                'region_listings_id' => $row->id,
                'name' => $row->region->name,
                'latitude' => $row->latitude,
                'longitude' => $row->longitude,
                'URL' => $row->listingUrl,
                'listing_name' => $row->aboutTheListing,
                'room_type' => $row->roomType,
                'price' => $row->price,
                'address' => $row->detailedAddress,
                'no_of_people' => $row->personCapacity,
                'data_source' => "LeaseAbuse Property"

            ];
            $record = MasterProperty::where('region_listings_id', $row->id)->first();
            if (is_null($record)) {
                MasterProperty::create($data);
            } else {
                $record->update($data);
            }
        }
        return back();
    }

    public function EditMasterProperty($id)
    {
        $masterProperty = MasterProperty::find($id);
        return view('page.edit-master-property', [
            'masterProperty' => $masterProperty
        ]);
    }

    public function UpdateMasterProperty(Request $request)
    {
        $masterProperty = MasterProperty::find($request->id);
        $masterProperty->name = $request->name;
        $masterProperty->latitude = $request->latitude;
        $masterProperty->longitude = $request->longitude;
        $masterProperty->URL = $request->URL;
        $masterProperty->listing_name = $request->listing_name;
        $masterProperty->room_type = $request->room_type;
        $masterProperty->floor_size_value = $request->floor_size_value;
        $masterProperty->floor_size_unit = $request->floor_size_unit;
        $masterProperty->price = $request->price;
        $masterProperty->address = $request->address;
        $masterProperty->no_of_people = $request->no_of_people;
        $masterProperty->no_of_bathroom = $request->no_of_bathroom;
        $masterProperty->num_bedroom = $request->num_bedroom;
        $masterProperty->num_floor = $request->num_floor;
        $masterProperty->num_room = $request->num_room;
        $masterProperty->data_source = $request->data_source;
        $masterProperty->save();
        return redirect('/master-property');
    }

    public function MasterPropertyDetails(Request $request, $id)
    {
        $masterProperty = MasterProperty::find($id);
        $tableName = "properties";
        $origLat = $masterProperty->latitude;
        $origLon = $masterProperty->longitude;
        $dist = 8000; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
        $data[] = array(
            'type' => 'Feature',
            'geometry' => array(
                'type' => "Point",
                'coordinates' => [$masterProperty->longitude, $masterProperty->latitude]
            ),
            'properties' => array(
                'id' => 0,
                'modelId' => 1,
                'title' => '1) ' . $masterProperty->name
            ),
        );
//        $properties = DB::select("SELECT id,OwnerId, IDX_Address, Y_DD, X_DD,image, 3956 * 2 *
//                                      ASIN(SQRT( POWER(SIN(($origLat - abs(X_DD))*pi()/180/2),2)
//                                      +COS($origLat*pi()/180 )*COS(abs(X_DD)*pi()/180)
//                                      *POWER(SIN(($origLon-Y_DD)*pi()/180/2),   2)))
//                                      as distance FROM $tableName WHERE
//                                      Y_DD between ($origLon-$dist/abs(cos(radians($origLat))*69))
//                                      and ($origLon+$dist/abs(cos(radians($origLat))*69))
//                                      and X_DD between ($origLat-($dist/69))
//                                      and ($origLat+($dist/69)) and id != $id
//                                      having distance < $dist ORDER BY distance limit 30"
//        );
        $properties = DB::select("SELECT id,OwnerId, IDX_Address, Y_DD, X_DD,image, ( 6371 * acos( cos( radians($origLat) ) * cos( radians( Y_DD ) ) * cos( radians( X_DD ) - radians($origLon) ) + sin( radians($origLat) ) * sin(radians(Y_DD)) ) ) AS distance  FROM  properties  HAVING     distance < 200  ORDER BY  distance LIMIT 0,30");
        if ($request->ajax()) {
            $i = 2;
            foreach ($properties as $row) {
                $data[] = array(
                    'type' => 'Feature',
                    'geometry' => array(
                        'type' => "Point",
                        'coordinates' => [$row->X_DD, $row->Y_DD]
                    ),
                    'properties' => array(
                        'id' => $row->id,
                        'title' => $i . ') ' . $row->IDX_Address,
                        'icon' => 'monument',
                    ),
                );
                $i++;
            }
            return response()->json($data);
        }
        if ($masterProperty->rent_details_id) {
            $rentDetails = RentDetail::with('city', 'country')
                ->find($masterProperty->rent_details_id);
            $deposit = Deposit::where('rent_details_id', $id)->get();
            $description = Description::where('rent_details_id', $id)->get();
            $feature = Feature::where('rent_details_id', $id)->get();
            $fees = Fee::where('rent_details_id', $id)->get();
            $people = People::where('rent_details_id', $id)->get();
            $price = Price::where('rent_details_id', $id)->get();
            $review = Review::where('rent_details_id', $id)->get();
            $status = Status::where('rent_details_id', $id)->get();
            $images = explode(",", $rentDetails->image_url);
            $imageData = array();
            foreach ($images as $row) {
                $imageData[] = array(
                    'image' => $row
                );
            }
            return view('page.datafiniti-property-details', [
                'rentDetails' => $rentDetails,
                'deposit' => $deposit,
                'description' => $description,
                'feature' => $feature,
                'fees' => $fees,
                'people' => $people,
                'price' => $price,
                'review' => $review,
                'status' => $status,
                'masterProperty' => $masterProperty,
                'closestsProperty' => $properties,
                'imageData' => $imageData
            ]);
        } else if ($masterProperty->region_listings_id) {
            $details = RegionListings::with('region', 'review', 'region_listing_image', 'region_listing_screeshot')->find($masterProperty->region_listings_id);
            $items = $details['review'];
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            // Create a new Laravel collection from the array data
            $itemCollection = collect($items);
            // Define how many items we want to be visible in each page
            $perPage = 10;
            // Slice the collection to get the items to display in current page
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            // Create our paginator and pass it to the view
            $reviews = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);
            // set url path for generted links
            $reviews->setPath($request->url());
            return view('page.leaseabuse-property-details', [
                'details' => $details,
                'reviews' => $reviews,
                'masterProperty' => $masterProperty,
                'closestsProperty' => $properties
            ]);
        }
    }

    public function MasterPropertyMap(Request $request)
    {
        if ($request->ajax()) {
            $properties = MasterProperty::groupBy('name')->get();
            foreach ($properties as $row) {
                $data[] = array(
                    'type' => 'Feature',
                    'geometry' => array(
                        'type' => "Point",
                        'coordinates' => [$row->longitude, $row->latitude]
                    ),
                    'properties' => array(
                        'title' => $row->name,
                        'icon' => 'harbor'
                    ),
                );
            }
            return response()->json($data);
        }
        return view('page.master-property-map');
    }

    public function imageObject(Request $request)
    {
        $imageDescription = Property::find($request->id);
        return view('page.modal-box-image', [
            'imageDescription' => $imageDescription
        ]);
    }

    public function DatafinitiImage(Request $request)
    {
        if ($request->has('val')) {
            $rentDetails = RentDetail::find($request->id);
            if ($rentDetails->primary_image != $request->image_id) {
                $rentDetails->primary_image = $request->image_id;
            } else {
                $rentDetails->primary_image = null;
            }
            $rentDetails->save();
            return 1;
        } else {
            $rentDetails = RentDetail::find($request->id);
            $images = explode(",", $rentDetails->image_url);
            $image = $images[$request->image_id];
            $primary_image = $rentDetails->primary_image;
            return view('page.datafiniti-image', [
                'image' => $image,
                "image_id" => $request->image_id,
                "id" => $request->id,
                "primary_image" => $primary_image
            ]);
        }
    }

    public function leaseabusePropertyImage(Request $request)
    {
        DB::table('region_listing_images')->where('region_listings_id', $request->region_listing_id)->update(['primary_image' => 0]);
        if ($request->val == "true") {
            DB::table('region_listing_images')->where('id', $request->id)->update(['primary_image' => 1]);
        }
    }

    public function ExportPicture(Request $request)
    {
        $fileName = 'Noo-Property-Picture.zip';

        if (file_exists(public_path($fileName))) {
            unlink(public_path($fileName));
        }
        $NooProperties = Property::where('ParcelCity', '=', $request->city)->get();
        foreach ($NooProperties as $key => $row) {
            if ($row->image) {
                $imageName = explode("/", $row->image);
                $oldPath = $row->image;
                $fileExtension = \File::extension($oldPath);
                $newPathWithName = 'exports/' . $imageName[1];
                \File::copy($oldPath, $newPathWithName);
            }
        }
        $zip = new ZipArchive;
        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::files(public_path('exports'));
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
        }
        foreach ($NooProperties as $key => $row) {
            if ($row->image) {
                $imageName = explode("/", $row->image);
                unlink(public_path('exports/' . $imageName[1]));
            }
        }
        return response()->download(public_path($fileName));
    }

    public function ImportPicture(Request $request)
    {
        $NooProperties = Property::where('ParcelCity', '=', $request->city)->get();
        foreach ($NooProperties as $row) {
            $file = "https://maps.googleapis.com/maps/api/streetview?location=$row->Y_DD,$row->X_DD&size=600x400&key=AIzaSyDE2i7RPzDbo7CajfIwJG2XOsRna7a9n70";
            $no_image = $this->street_view_check($file, 6231);
            if ($no_image) {
                try {
                    $data = file_get_contents($file);
                    $image_url = "uploads/$row->PropertyGID.jpeg";
                    if (!file_exists($image_url)) {
                        file_put_contents(public_path($image_url), $data);
                    }
                    $object = $this->image_object($file);
                    $image_object = !empty($object->responses[0]) ? json_encode($object->responses[0]) : '';
                    $labels = $this->image_labels($file);
                    $image_labels = !empty($labels->responses[0]) ? json_encode($labels->responses[0]) : '';
                    $text = $this->image_text($file);
                    $image_text = !empty($text->responses[0]) ? json_encode($text->responses[0]) : '';
                } catch (\Exception $e) {

                }
            } else {
                $image_url = '';
                $image_object = '';
                $image_labels = '';
                $image_text = '';
            }
            $data = [
                'image' => $image_url,
                'image_object' => $image_object,
                'image_labels' => $image_labels,
                'image_text' => $image_text
            ];
            Property::where('Id', $row->Id)->update($data);
        }
        return back();
    }

    function street_view_check($url, $size_of_blank_image)
    {
        $str = file_get_contents($url);
        if (strlen($str) == $size_of_blank_image) {
            return false;
        }
        return true;
    }

    private function image_object($image)
    {
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
    }

    private function image_labels($image)
    {
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

    private function image_text($image)
    {
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

    public function matchProperty($id, Request $request)
    {
        $masterProperty = MasterProperty::find($request->id);
        return view('page.match-property', [
            'id' => $id,
            'latitude' => $masterProperty->latitude,
            'longitude' => $masterProperty->longitude,
        ]);
    }

    public function matchMapProperty($id, Request $request)
    {
        $nooProperty = Property::get();
        foreach ($nooProperty as $row) {
            $data[] = array(
                'type' => 'Feature',
                'pId' => $row->Id,
                'geometry' => array(
                    'type' => "Point",
                    'coordinates' => [$row->Y_DD, $row->X_DD]
                ),
                'properties' => array(
                    'modelId' => 1,
                    'title' => $row->IDX_Address
                ),
            );
        }

        $masterProperty = MasterProperty::find($id);
        $data[] = array(
            'type' => 'Feature',
            'pId' => $masterProperty->id,
            'geometry' => array(
                'type' => "Point",
                'coordinates' => [$masterProperty->longitude, $masterProperty->latitude]
            ),
            'properties' => array(
                'modelId' => 2,
                'title' => $masterProperty->name
            ),
        );

        return view('page.match-map-property', [
            'id' => $id,
            'data' => $data,
            'latitude' => $masterProperty->latitude,
            'longitude' => $masterProperty->longitude,
        ]);
    }

    public function matchDetachProperty($id)
    {
        $nooProperty = Property::get();
        foreach ($nooProperty as $row) {
            $data[] = array(
                'type' => 'Feature',
                'pId' => $row->Id,
                'geometry' => array(
                    'type' => "Point",
                    'coordinates' => [$row->Y_DD, $row->X_DD]
                ),
                'properties' => array(
                    'modelId' => 1,
                    'title' => $row->IDX_Address
                ),
            );
        }

        $masterProperty = MasterProperty::find($id);
        $data[] = array(
            'type' => 'Feature',
            'pId' => $masterProperty->id,
            'geometry' => array(
                'type' => "Point",
                'coordinates' => [$masterProperty->longitude, $masterProperty->latitude]
            ),
            'properties' => array(
                'modelId' => 2,
                'title' => $masterProperty->name
            ),
        );

        return view('page.match-detach-property', [
            'id' => $id,
            'data' => $data,
            'latitude' => $masterProperty->latitude,
            'longitude' => $masterProperty->longitude,
        ]);
    }

    public function rentalPropertyMap(Request $request)
    {
        $masterProperty = MasterProperty::get();
        if ($request->ajax()) {
            foreach ($masterProperty as $row) {
                $isMatchedProperty = $this->isMatchedProperty($row->id);
                if (is_null($isMatchedProperty)) {
                    $data[] = array(
                        'type' => 'Feature',
                        'pId' => $row->id,
                        'geometry' => array(
                            'type' => "Point",
                            'coordinates' => [$row->longitude, $row->latitude]
                        ),
                        'properties' => array(
                            'modelId' => 1,
                            'title' => $row->name
                        ),
                    );
                } else {
                    $data[] = array(
                        'type' => 'Feature',
                        'pId' => $row->id,
                        'geometry' => array(
                            'type' => "Point",
                            'coordinates' => [$row->longitude, $row->latitude]
                        ),
                        'properties' => array(
                            'modelId' => 2,
                            'title' => $row->name
                        ),
                    );
                }
            }
            return response()->json($data);
        }
        $lat = $masterProperty[0]->latitude;
        $lng = $masterProperty[0]->longitude;
        return view('page.rental-property-map', [
            'lat' => $lat,
            'lng' => $lng,
        ]);
    }

    public function isMatchedProperty($id)
    {
        return MatchProperty::where('masterPropertyID', $id)->where('vote', 3)->first();
    }

    public function ExportNooDetails(Request $request)
    {
        return Excel::download(new NOOPropertyExport($request->city), $request->city . '.csv');
    }

    public function MasterPropertyView($id)
    {
        $masterproperty = MasterProperty::find($id);
        $origLat = $masterproperty->latitude;
        $origLon = $masterproperty->longitude;
        $properties = DB::select("SELECT id,OwnerId, IDX_Address, Y_DD, X_DD,image, ( 6371 * acos( cos( radians($origLat) ) * cos( radians( Y_DD ) ) * cos( radians( X_DD ) - radians($origLon) ) + sin( radians($origLat) ) * sin(radians(Y_DD)) ) ) AS distance  FROM  properties  HAVING     distance < 200  ORDER BY  distance LIMIT 0,30");
        if ($masterproperty->region_listings_id) {
            $leaseAbuseProperty = RegionListings::with('region_listing_image')->find($masterproperty->region_listings_id);
            return view('page.master-property-view', [
                'leaseAbuseProperty' => $leaseAbuseProperty,
                'masterProperty' => $masterproperty
            ]);
        } else if ($masterproperty->rent_details_id) {
            $dataFinitiProperty = RentDetail::with('image', 'review')->find($masterproperty->rent_details_id);
            $comments = MatchProperty::with('user')->where('masterPropertyID',$id)->where('vote',3)->get();
            $votes = MatchProperty::with('user')->where('masterPropertyID',$id)->orderBy('id', 'desc')->get();

            return view('page.datafinit-property-view', [
                'dataFinitiProperty' => $dataFinitiProperty,
                'masterProperty' => $masterproperty,
                'votes' => $votes,
                'comments'=>$comments,
                'closestsProperty'=>$properties
            ]);
        }
    }


    public function exportCommunityCSV(Request $request){
        if($request->community){
            return Excel::download(new CommunityExport($request->community), $request->community . '.csv');
        }
        $properties = Property::groupBy('ParcelCity')->get();
        return view('page.export-community-csv',[
            "properties"=>$properties
        ]);
    }
}
