<?php

namespace App\Http\Controllers;

use App\JobInQueue;
use Illuminate\Http\Request;
use App\Jobs\DataFinityPodcast;
use App\Jobs\NooPropertyPodcast;

class QueueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $jobInQueue = JobInQueue::orderBy('id','DESC')->get();
        $regionsList = json_decode(file_get_contents('https://api.leaseabuse.com/api/v1/region/list?key=PROCHAMPS-201904'), true);
        return view('page.job-in-queue',[
            'jobInQueue'=>$jobInQueue,
            'regionsList'=>$regionsList['items']
        ]);
    }

    public function uploadFile(Request $request)
    {
        if($request->property_type==3){
            $data = [
                'property_type'=>$request->property_type,
                'api_id'=>$request->api_id
            ];
            JobInQueue::create($data);
        }else {
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $directory = 'storage/excel/';
            $file_url = $directory . $file_name;
            $file->move($directory, $file_name);
            $data = [
                'property_type' => $request->property_type,
                'file_url' => $file_url
            ];
            JobInQueue::create($data);
        }
        return back()->with('message','Successfully Upload File');
    }

    public function destroyUploadFile($id)
    {
        $data = JobInQueue::find($id);
        if($data->file_url) {
            unlink($data->file_url);
        }
        $data->delete();
        return back();
    }

    public function jobActive($id)
    {
        $data = JobInQueue::find($id);
        $data->is_active = 1;
        $data->status = 1;
        $data->save();

        if ($data->property_type==1) {
            DataFinityPodcast::dispatch($data)->delay(now()->addMinutes(1));
        } elseif ($data->property_type==2) {
            NooPropertyPodcast::dispatch($data)->delay(now()->addMinutes(1));
        }

        return back();
    }
}
