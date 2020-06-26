<?php

namespace App\Imports;

use App\Owner;
use App\Property;
use App\Site;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class NooPropertyImport implements ToCollection
{

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        ini_set('max_execution_time', 0);
        $i = 0;
        foreach ($collection as $row){
            if($i>0){
                $propertyExists = $this->propertyExists($row[0]);
                $fileName = implode(',', [
                    str_replace(' ', '+', ($row[5])),
                    str_replace(' ', '+', ($row[4])),
                    str_replace(' ', '+', ($row[9])),
                    str_replace(' ', '+', ($row[10]))
                ]);
                $file = "https://maps.googleapis.com/maps/api/streetview?size=600x400&key=AIzaSyDE2i7RPzDbo7CajfIwJG2XOsRna7a9n70&location=".$fileName;
                //$file = "https://maps.googleapis.com/maps/api/streetview?size=500x400&location=60+Arroyo+Pkwy,+Ormond+Beach,+FL+32174&key=AIzaSyDE2i7RPzDbo7CajfIwJG2XOsRna7a9n70";
                $no_image = $this->street_view_check($file,6231);
                if($no_image) {
                    try{
                        $data = file_get_contents($file);
                        $image_url = "uploads/$row[0].jpeg";
                        if(!file_exists($image_url)) {
                            file_put_contents(public_path($image_url), $data);
                        }
                        $object = $this->image_object(url($image_url));
                        $image_object = !empty($object->responses[0]) ? json_encode($object->responses[0]):'';
                        $labels = $this->image_labels(url($image_url));
                        $image_labels = !empty($labels->responses[0]) ? json_encode($labels->responses[0]):'';
                        $text = $this->image_text(url($image_url));
                        $image_text = !empty($text->responses[0]) ? json_encode($text->responses[0]):'';
                    }catch (\Exception $e){

                    }
                }else{
                    $image_url = '';
                    $image_object = '';
                    $image_labels = '';
                    $image_text = '';
                }
                if(!$propertyExists){
                    $ownerId = $this->saveOwner($row);
                    $siteId = $this->saveSite($row);
                    $property =  new Property();
                    $property->PropertyGID = $row[0];
                    $property->OwnerId = $ownerId;
                    $property->SiteId = $siteId;
                    $property->ParcelID = $row[3];
//                    $property->ParcelLong = $row[4];
//                    $property->TaxAccount = $row[5];
                    $property->ParcelCity = $row[4];
                    $property->LegalDesc = $row[11];
                    $property->X_DD = $row[12];
                    $property->Y_DD = $row[13];
                    $property->GeoType = $row[14];
                    $property->PropertyUse = $row[15];
                    $property->ActiveFlag = $row[16];
//                    $property->CommCommunityID = $row[24];
                    $property->IDX_Address = $row[5];
                    $property->NumberofUnits = $row[26];
                    $property->image = $image_url;
                    $property->image_object = $image_object;
                    $property->image_labels = $image_labels;
                    $property->image_text = $image_text;
                    $property->save();
                }else{
                    $property =  Property::find($propertyExists->Id);
                    $property->PropertyGID = $row[0];
                    $property->ParcelID = $row[3];
//                    $property->ParcelLong = $row[4];
//                    $property->TaxAccount = $row[5];
                    $property->ParcelCity = $row[4];
                    $property->LegalDesc = $row[11];
                    $property->X_DD = $row[12];
                    $property->Y_DD = $row[13];
                    $property->GeoType = $row[14];
                    $property->PropertyUse = $row[15];
                    $property->ActiveFlag = $row[16];
//                    $property->CommCommunityID = $row[24];
                    $property->IDX_Address = $row[5];
                    $property->NumberofUnits = $row[26];
                    $property->image = $image_url;
                    $property->image_object = $image_object;
                    $property->image_labels = $image_labels;
                    $property->image_text = $image_text;
                    $property->save();
                }
            }
            $i++;
        }
    }

    public function saveOwner($row)
    {
        return Owner::firstOrCreate(['OwnerName1' => $row[1]], [
            'OwnerName1' => $row[1],
            'OwnerName2' => $row[2],
            'OwnerAddress' => $row[22],
            'OwnerCity' => $row[23],
            'OwnerState' => $row[24],
            'OwnerZipcode' => $row[25],
        ])->id;

//        $owner->OwnerStreetNumber = $row[26];
//        $owner->OwnerStreetPreDir = $row[31];
//        $owner->OwnerStreetName = $row[32];
//        $owner->OwnerStreetType = $row[33];
//        $owner->OwnerStreetPostDir = $row[34];
        //  $owner->OwnerUnit = $row[26];
//        $owner->OwnerOccupiedFlag = $row[36];
//        $owner->OwnerOccupiedCode = $row[37];
    }
    public function saveSite($row){
        $site = new Site();
        $site->SiteAddress = $row[5];
        $site->SiteUnit = $row[6];
        $site->SiteCity = $row[7];
        $site->SiteState = $row[9];
        $site->SiteZipCode = $row[10];
//        $site->SiteNeighborhood = $row[10];
//        $site->SiteStreetNumber = $row[19];
//        $site->SiteStreetPreDir = $row[20];
//        $site->SiteStreetName = $row[21];
//        $site->SiteStreetType = $row[22];
//        $site->SiteStreetPostDir = $row[23];
        $site->save();
        return $site->Id;
    }
    function street_view_check($url,$size_of_blank_image){
        $str = file_get_contents($url);
        if(strlen($str)==$size_of_blank_image){
            return false;
        }
        return true;
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
    public function propertyExists($id){
        return Property::where('PropertyGID',$id)->first();
    }

}
