<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Service_Vendor;
use App\AssetCategory;
use App\Department;

use Auth;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = Auth::user();

        $vendors = Service_Vendor::where('hospital_id', $user->hospital_id)->get();
        $assets = Asset::where('hospital_id', $user->hospital_id)->get();
        $asset_categories = AssetCategory::where('hospital_id', $user->hospital_id)->get();
        $departments = Department::with('units')->where('hospital_id', $user->hospital_id)->get();
        return view('add-item', compact("vendors", "asset_categories", "departments"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required',
            'asset_code'     => 'required',
            'status'         => 'required',
            'availability'   => 'required'    
         ]);

         $asset = new Asset();

         $asset->id                  = md5($request->name.microtime());
         $asset->parent_id           = $request->parent_id;
         $asset->name                = $request->name;
         $asset->asset_code          = $request->asset_code;
         $asset->asset_category_id   = $request->asset_category_id;
         $asset->purchase_price      = $request->purchase_price;
         $asset->purchase_date       = $request->purchase_date;
         $asset->user_id             = $request->user_id;
         $asset->installation_date   = $request->installation_date;
         $asset->status              = $request->status;
         $asset->availability        = $request->availability;
         $asset->description         = $request->description;
         $asset->area                = $request->area;
         $asset->department_id       = $request->department_id;
         $asset->unit_id             = $request->unit_id;
         $asset->pos_rep_date        = $request->pos_rep_date;
         $asset->serial_number       = $request->serial_number;
         $asset->model_number        = $request->model_number;
         $asset->manufacturer_name   = $request->manufacturer_name;
         $asset->service_vendor_id   = $request->service_vendor_id;
         $asset->hospital_id         = $request->hospital_id;
         $asset->reason              = $request->reason;
         $asset->warranty_expiration = $request->warranty_expiration;

         if($request->image != null) {
             $fileName     = Util::saveBase64Image($request->image, microtime().'-'.$asset->name, 'img/assets/asset/');
             $asset->image = $fileName;
         }

        if($asset->save()) {
            return response()->json([
                'error'   => false,
                'data'    => $asset,
                'message' => 'Asset saved successfully!'
            ]);
        } else {
            return response()->json([
                'error'   => true,
                'message' => 'Could not save asset. Try Again!' 
            ]); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asset $asset)
    {
        $request->installation_time = $this->formatDate($request->installation_time);
        $request->pos_rep_date = $this->formatDate($request->pos_rep_date);

        $equipment->installation_time = $request->installation_time;
        $equipment->pos_rep_date = $request->pos_rep_date;
        $status = $equipment->update(
            $request->only(['name', 'parent_id', 'availability','asset_code', 'serial_number', 
            'model_number', 'manufacturer_name', 'description', 'asset_category_id', 
            'department_id', 'unit_id', 'status', 'area', 'purchase_date', 'purchase_price', 
            'service_vendor_id', 'reason', 'warranty_expiration'])
        );

        return response()->json([
            'data' => $equipment,
            'message' => $status ? 'Equipment Updated' : 'Error updating equipment'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        //
    }

    private function formatDate($date){
        return date("Y-m-d H:i:s", strtotime(stripslashes($date)));
    }
}
