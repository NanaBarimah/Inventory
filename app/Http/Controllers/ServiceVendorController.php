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
        $user = Auth::user();
        if($user->role == 'Admin' || $user->role == 'Regular Technician'){
            $vendors = Service_Vendor::where('hospital_id', '=', $user->hospital_id)->get();

            return view('vendors')->with('vendors', $vendors)->with('user', $user);
        } else {
            abort(403);
        }
        
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
            'name'           => 'required|string',
            'vendor_type'    => 'required|string',
            'hospital_id'    => 'required',
        ]);
            
        $service_vendor  = new Service_vendor();

        $service_vendor->id             = md5($request->name.microtime());
        $service_vendor->name           = $request->name;
        $service_vendor->address        = $request->address;
        $service_vendor->contact_number = $request->contact_number;
        $service_vendor->contact_name   = $request->contact_name;
        $service_vendor->email          = $request->email;
        $service_vendor->vendor_type    = $request->vendor_type;
        $service_vendor->website        = $request->website;
        $service_vendor->hospital_id    = $request->hospital_id;

        if($service_vendor->save()){
            $result = false;
        }

        return response()->json([
            'error'   => $result,
            'data'    => $service_vendor,
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
    public function update(Request $request, Service_Vendor $vendor)
    {
        $request->validate([
            'name'           => 'required',
            'vendor_type'    => 'required',
        ]);

        $vendor->name           = $request->name;
        $vendor->address        = $request->address;
        $vendor->contact_number = $request->contact_number;
        $vendor->contact_name   = $request->contact_name;
        $vendor->email          = $request->email;
        $vendor->vendor_type    = $request->vendor_type;
        $vendor->website        = $request->website;

        $status = $vendor->update();

        return response()->json([
            'error'   => !$status,
            'data'    => $vendor,
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
