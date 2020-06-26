<?php

namespace App\Imports;

use App\DatafinitiImage;
use App\MasterProperty;
use App\RentDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\User;
use App\City;
use App\Country;
use App\Description;
use App\Deposit;
use App\Feature;
use App\Fee;
use App\People;
use App\Price;
use App\Review;
use App\Status;
use Illuminate\Support\Str;
use DB;

class RentImport implements ToCollection
{

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        ini_set('max_execution_time', 0);
        $i = 0;
        foreach ($rows as $row) {
            if ($i > 0) {
                $country = Country::where('country_name', (Str::slug($row[6], '-')))->first();
                if ($country) {
                    $country_id = $country->id;
                } else {
                    $country = new Country();
                    $country->country_name = $row[6];
                    $country->slug = Str::slug($row[6], '-');
                    $country->save();
                    $country_id = $country->id;
                }
                $city = City::where('slug', (Str::slug($row[5], '-')))->first();
                if ($city) {
                    $city_id = $city->id;
                } else {
                    $city = new City();
                    $city->city_name = $row[5];
                    $city->slug = Str::slug($row[5], '-');
                    $city->country_id = $country_id;
                    $city->save();
                    $city_id = $city->id;
                }
                $propertyExists = RentDetail::where('rent_id', $row[0])->first();
                if (!$propertyExists) {
                    $data = [
                        'rent_id' => $row[0],
                        'address' => $row[1],
                        'available_date' => $row[2] != null ? date('Y-m-d H:i:s', strtotime($row[2])) : NULL,
                        'brokers' => $row[3],
                        'building_name' => $row[4],
                        'city_id' => $city_id,
                        'country_id' => $country_id,
                        'date_added' => $row[7] != null ? date('Y-m-d H:i:s', strtotime($row[7])) : NULL,
                        'date_updated' => $row[8] != null ? date('Y-m-d H:i:s', strtotime($row[8])) : NULL,
                        'floor_size_value' => $row[13],
                        'floor_size_unit' => $row[14],
                        'geo_location' => $row[15],
                        'hours' => $row[16],
                        'image_url' => $row[17],
                        'key' => $row[18],
                        'languages_spoken' => $row[19],
                        'latitude' => $row[20],
                        'leasing_terms' => $row[21],
                        'listing_name' => $row[22],
                        'longitude' => $row[23],
                        'lot_size_value' => $row[24],
                        'lot_size_unit' => $row[25],
                        'managed_by' => $row[26],
                        'most_recent_status' => $row[27],
                        'most_recent_status_date' => $row[28] != null ? date('Y-m-d H:i:s', strtotime($row[28])) : NULL,
                        'mls_number' => $row[29],
                        'near_by_school' => $row[30],
                        'neighborhood' => $row[31],
                        'num_bathroom' => $row[32],
                        'num_bedroom' => $row[33],
                        'num_floor' => $row[34],
                        'num_people' => $row[35],
                        'num_room' => $row[36],
                        'num_unit' => $row[37],
                        'parking' => $row[38],
                        'payment_type' => $row[39],
                        'pet_policy' => $row[41],
                        'phones' => $row[42],
                        'postal_code' => $row[43],
                        'property_tax' => $row[45],
                        'property_type' => $row[46],
                        'province' => $row[47],
                        'rules' => $row[49],
                        'source_URL' => $row[50],
                        'tax_ID' => $row[52],
                        'unavailable_date' => $row[53] != null ? date('Y-m-d H:i:s', strtotime($row[53])) : NULL,
                        'website_id' => $row[54],
                    ];
                    $rentDetails = RentDetail::create($data);
                    $id = $rentDetails->id;
                    $this->SaveMasterProperty($id);
                     if ($row[9]) {
                         $this->saveDeposit($id, $row[9]);
                     }
                     if ($row[10]) {
                         $this->saveDescription($id, $row[10]);
                     }
                     if ($row[11]) {
                         $this->saveFeature($id, $row[11]);
                     }
                     if ($row[12]) {
                         $this->saveFees($id, $row[12]);
                     }
                     if ($row[40]) {
                         $this->savePeople($id, $row[40]);
                     }
                     if ($row[44]) {
                         $this->savePrice($id, $row[44]);
                     }
                     if ($row[48]) {
                         $this->saveReview($id, $row[48]);
                     }
                     if ($row[51]) {
                         $this->saveStatus($id, $row[51]);
                     }
                     if ($row[17]) {
                         $this->saveImage($id, $row[17], $row[0]);
                     }
                } else {
                    $this->updateImage($propertyExists->id, $row[17], $row[0]);
                }
            }
            $i++;
        }
    }

    public function updateImage($id, $images, $rent_id)
    {
        DB::table('datafiniti_images')->where('rent_id', $id)->delete();
        $imageLink = explode(",", $images);
        foreach ($imageLink as $key => $row) {
            try {
                $data = file_get_contents($row);
                $image_url = "/uploads/$rent_id$key.jpg";
                if (!file_exists($image_url)) {
                    file_put_contents(public_path($image_url), $data);
                    $object = $this->image_object($row);
                    $image_object = !empty($object->responses[0]) ? json_encode($object->responses[0]) : '';
                    $labels = $this->image_labels($row);
                    $image_labels = !empty($labels->responses[0]) ? json_encode($labels->responses[0]) : '';
                    $text = $this->image_text($row);
                    $image_text = !empty($text->responses[0]) ? json_encode($text->responses[0]) : '';

                    $datafinitiImage = new DatafinitiImage();
                    $datafinitiImage->rent_id = $id;
                    $datafinitiImage->image = $image_url;
                    $datafinitiImage->image_link = $row;
                    $datafinitiImage->image_object = $image_object;
                    $datafinitiImage->image_labels = $image_labels;
                    $datafinitiImage->image_text = $image_text;
                    $datafinitiImage->save();
                }
            } catch (\Exception $e) {

            }

        }
    }

    public function saveImage($id, $images, $rent_id)
    {
        $imageLink = explode(",", $images);
        foreach ($imageLink as $key => $row) {
            try {
                $data = file_get_contents($row);
                $image_url = "/uploads/$rent_id$key.jpg";
                if (!file_exists($image_url)) {
                    file_put_contents(public_path($image_url), $data);
                }
                $object = $this->image_object(url($image_url));
                $image_object = !empty($object->responses[0]) ? json_encode($object->responses[0]) : '';
                $labels = $this->image_labels(url($image_url));
                $image_labels = !empty($labels->responses[0]) ? json_encode($labels->responses[0]) : '';
                $text = $this->image_text(url($image_url));
                $image_text = !empty($text->responses[0]) ? json_encode($text->responses[0]) : '';

                $datafinitiImage = new DatafinitiImage();
                $datafinitiImage->rent_id = $id;
                $datafinitiImage->image = $image_url;
                $datafinitiImage->image_link = $row;
                $datafinitiImage->image_object = $image_object;
                $datafinitiImage->image_labels = $image_labels;
                $datafinitiImage->image_text = $image_text;
                $datafinitiImage->save();
            } catch (\Exception $e) {

            }
        }
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

    public function saveDeposit($id, $data)
    {
        $jsonDatas = json_decode($data);
        //dd($jsonDatas);
        if ($jsonDatas) {
            foreach ($jsonDatas as $row) {
                $deposit = new Deposit();
                $deposit->rent_details_id = $id;
                $deposit->currency = $row->currency;
                $deposit->amount = $row->amount;
                $deposit->date_seen = json_encode($row->dateSeen);
                $deposit->source_URL = json_encode($row->sourceURLs);
                $deposit->save();
            }
            // exit();
        }
    }

    public function saveDescription($id, $data)
    {
        $jsonDatas = json_decode($data);
        if ($jsonDatas) {
            foreach ($jsonDatas as $row) {
                $description = new Description();
                $description->rent_details_id = $id;
                $description->value = $row->value;
                $description->source_URL = json_encode($row->sourceURLs);
                $description->date_seen = isset($row->dateSeen) ? date('Y-m-d H:i:s', strtotime($row->dateSeen)) : NULL;
                $description->save();
            }
        }
    }

    public function saveFeature($id, $data)
    {
        $jsonDatas = json_decode($data);
        if ($jsonDatas) {
            foreach ($jsonDatas as $row) {
                $feature = new Feature();
                $feature->rent_details_id = $id;
                $feature->key = $row->key;
                $feature->value = json_encode($row->value);
                $feature->save();
            }
        }
    }

    public function saveFees($id, $data)
    {
        $jsonDatas = json_decode($data);
        if ($jsonDatas) {
            foreach ($jsonDatas as $row) {
                $fees = new Fee();
                $fees->rent_details_id = $id;
                $fees->type = $row->type;
                $fees->date_seen = json_encode($row->dateSeen);
                $fees->source_URL = json_encode($row->sourceURLs);
                $fees->currency = $row->currency;
                $fees->amount_min = $row->amountMin;
                $fees->amount_max = $row->amountMax;
                $fees->save();
            }
        }
    }

    public function savePeople($id, $data)
    {
        $jsonDatas = json_decode($data);
        if ($jsonDatas) {
            foreach ($jsonDatas as $row) {
                $people = new People();
                $people->rent_details_id = $id;
                $people->name = $row->name;
                $people->title = $row->title;
                $people->date_seen = isset($row->dateSeen) ? date('Y-m-d H:i:s', strtotime($row->dateSeen)) : NULL;
                $people->save();
            }
        }
    }

    public function savePrice($id, $data)
    {
        $jsonDatas = json_decode($data);
        if ($jsonDatas) {
            foreach ($jsonDatas as $row) {
                $price = new Price();
                $price->rent_details_id = $id;
                $price->amount_max = $row->amountMax;
                $price->amount_min = $row->amountMin;
                $price->currency = $row->currency;
                $price->date_seen = json_encode($row->dateSeen);
                $price->is_sale = isset($row->isSale) ? $row->isSale : NULL;
                $price->source_URL = json_encode($row->sourceURLs);
                $price->save();
            }
        }
    }

    public function saveReview($id, $data)
    {
        $jsonDatas = json_decode($data);
        if ($jsonDatas) {
            foreach ($jsonDatas as $row) {
                $review = new Review();
                $review->rent_details_id = $id;
                $review->date = isset($row->date) ? date('Y-m-d H:i:s', strtotime($row->date)) : NULL;
                $review->date_seen = isset($row->dateSeen) ? date('Y-m-d H:i:s', strtotime($row->dateSeen)) : NULL;
                $review->rating = isset($row->rating) ? $row->rating : NULL;
                $review->source_URL = json_encode($row->sourceURLs);
                $review->description = isset($row->text) ? $row->text : NULL;
                $review->user_name = isset($row->username) ? $row->username : NULL;
                $review->save();
            }
        }
    }

    public function saveStatus($id, $data)
    {
        $jsonDatas = json_decode($data);
        if ($jsonDatas) {
            foreach ($jsonDatas as $row) {
                $status = new Status();
                $status->rent_details_id = $id;
                $status->type = $row->type;
                $status->date = isset($row->date) ? date('Y-m-d H:i:s', strtotime($row->date)) : NULL;
                $status->source_URL = json_encode($row->sourceURLs);
                $status->date_seen = json_encode($row->dateSeen);
                $status->save();
            }
        }
    }

    public function SaveMasterProperty($id)
    {
        $datafinitiProperty = RentDetail::with('city', 'price')->find($id);
        $data = [
            'rent_details_id' => $datafinitiProperty->id,
            'name' => $datafinitiProperty->city->city_name,
            'latitude' => $datafinitiProperty->latitude,
            'longitude' => $datafinitiProperty->longitude,
            'URL' => $datafinitiProperty->source_URL,
            'listing_name' => $datafinitiProperty->listing_name,
            'room_type' => $datafinitiProperty->property_type,
            'floor_size_value' => $datafinitiProperty->lot_size_value,
            'floor_size_unit' => $datafinitiProperty->lot_size_unit,
            'price' => $datafinitiProperty->price['amount_max'],
            'address' => $datafinitiProperty->address,
            'no_of_people' => $datafinitiProperty->num_people,
            'no_of_bathroom' => $datafinitiProperty->num_bathroom,
            'num_bedroom' => $datafinitiProperty->num_bedroom,
            'num_floor' => $datafinitiProperty->num_floor,
            'num_room' => $datafinitiProperty->num_room,
            'data_source' => "Datafiniti Property"
        ];
        $record = MasterProperty::where('rent_details_id', $id)->first();
        if (is_null($record)) {
            MasterProperty::create($data);
        } else {
            $record->update($data);
        }
    }

    }
