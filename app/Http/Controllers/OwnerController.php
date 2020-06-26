<?php

namespace App\Http\Controllers;

use App\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get all resources
        $owners = Owner::where(function($q) use ($request) {
                if (isset($request->city) && !empty($request->city)) {
                    $q->where('OwnerCity', $request->city);
                }
                if (isset($request->keyword)  && !empty($request->keyword)) {
                    $q->where('OwnerName1', 'like', '%' . $request->keyword . '%')
                        ->orWhere('OwnerName2', 'like', '%' . $request->keyword . '%')
                        ->orWhere('OwnerAddress', 'like', '%' . $request->keyword . '%')
                        ->orWhere('OwnerCity', 'like', '%' . $request->keyword . '%')
                        ->orWhere('OwnerState', 'like', '%' . $request->keyword . '%')
                        ->orWhere('OwnerStreetNumber', 'like', '%' . $request->keyword . '%')
                        ->orWhere('OwnerStreetPreDir', 'like', '%' . $request->keyword . '%')
                        ->orWhere('OwnerStreetName', 'like', '%' . $request->keyword . '%')
                        ->orWhere('OwnerStreetType', 'like', '%' . $request->keyword . '%')
                        ->orWhere('OwnerStreetPostDir', 'like', '%' . $request->keyword . '%')
                        ->orWhere('OwnerUnit', 'like', '%' . $request->keyword . '%')
                        ->orWhere('OwnerUnit', 'like', '%' . $request->keyword . '%')
                        ->orWhere('OwnerOccupiedFlag', 'like', '%' . $request->keyword . '%')
                        ->orWhere('OwnerOccupiedCode', 'like', '%' . $request->keyword . '%')
                        ->orWhere('OwnerZipcode', 'like', '%' . $request->keyword . '%');
                }
            })->groupBy('OwnerName1')->paginate(10);
        $owners->setPath('noo-property-owner?keyword='.$request->keyword.'&city='.$request->city);
        $cities = Owner::groupBy('OwnerCity')->get();
        $selectedCity = $request->city;
        $selectedkeyword = $request->keyword;

        return view('page.noo-owner-property', compact('owners', 'cities', 'selectedCity', 'selectedkeyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        // Get the resource
        $owner = Owner::with('NOOProperties')->findOrFail($id);

        return view('page.noo-owner-property-details', compact('owner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
