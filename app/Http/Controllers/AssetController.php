<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Hospital;

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
        $assets = Asset::with('asset_category')->where('hospital_id', Auth::user()->hospital_id)->get();
        return view("assets", compact("assets"));
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
        
        $hospital = Hospital::with("assets", "asset_categories", "departments",
         "departments.units", "services", "parts", "users")->where("id", $user->hospital_id)->first();
        
        return view('add-item', compact("hospital"));
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
         $asset->purchase_date       = $request->purchase_date != null ? date('Y-m-d', strtotime($request->purchase_date)) : null;
         $asset->user_id             = $request->user_id;
         $asset->installation_date   = $request->installation_date != null ? date('Y-m-d', strtotime($request->installation_date)) : null;
         $asset->status              = $request->status;
         $asset->availability        = $request->availability;
         $asset->description         = $request->description;
         $asset->area                = $request->area;
         $asset->department_id       = $request->department_id;
         $asset->unit_id             = $request->unit_id;
         $asset->pos_rep_date        = $request->pos_rep_date != null ? date('Y-m-d', strtotime($request->pos_rep_date)) : null;
         $asset->serial_number       = $request->serial_number;
         $asset->model_number        = $request->model_number;
         $asset->manufacturer_name   = $request->manufacturer_name;
         $asset->service_vendor_id   = $request->service_vendor_id;
         $asset->hospital_id         = $request->hospital_id;
         $asset->reason              = $request->reason;
         $asset->warranty_expiration = $request->warranty_expiration != null ? date('Y-m-d', strtotime($request->warranty_expiration)) : null;

         if($request->image != null) {
            $request->validate([
                'image'   => 'mimes:png, jpg, jpeg'
            ]);

            $file = $request->file('image');

            $name = md5($file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
            $file->move(public_path().'/img/assets/equipment/', $name);
            
            $asset->image = $name;
         }

        if($asset->save()) {

            if($request->parts != null){
                $asset->parts()->attach($request->parts);
            }

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
        return view("asset-details", compact("asset"));
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
