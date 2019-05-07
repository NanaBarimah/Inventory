<?php

namespace App\Http\Controllers;

use App\Service_Vendor;
use Illuminate\Http\Request;
use Auth;

class ServiceVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Service_Vendor::where('hospital_id', '=', Auth::user()->hospital_id)->get();

        return view('vendors')->with('vendors', $vendors);
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
        $result = true;
        $request->validate([
            'name' => 'required|string',
            'contact_number' => 'required|string',
            'hospital_id' => 'required'
        ]);
            
        $service_Vendor  = new Service_Vendor();

        $service_Vendor->name = $request->name;
        $service_Vendor->contact_number = $request->contact_number;
        $service_Vendor->hospital_id = $request->hospital_id;

        if($service_Vendor->save()){
            $result = false;
        }

        return response()->json([
            'error' => $result,
            'data' => $service_Vendor,
            'message' => !$result ? 'Service Vendor created successfully' : 'Error creating service vendor'
          ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service_Vendor  $service_Vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Service_Vendor $service_Vendor)
    {
        return response()->json($service_Vendor, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service_Vendor  $service_Vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Service_Vendor $service_Vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service_Vendor  $service_Vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'contact_number' => 'required'
        ]);
        /*$status = $service_Vendor->update(
            $request->only(['name', 'contact_number'])
        );*/

        $vendor = Service_Vendor::find($request->id)->first();
        $vendor->name = $request->name;
        $vendor->contact_number = $request->contact_number;

        $status = $vendor->update();

        return response()->json([
            'error' => !$status,
            'data' => $vendor,
            'message' => $status ? 'Service Vendor Updated' : 'Error updating service vendor'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service_Vendor  $service_Vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service_Vendor $service_Vendor)
    {
        //
    }
}
