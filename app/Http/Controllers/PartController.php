<?php

namespace App\Http\Controllers;

use App\Part;
use Illuminate\Http\Request;

class PartController extends Controller
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
            'name' => 'required|string',
            'cost' => 'required',
        ]);

        $part = new Part();

        $part->id                 = md5($request->name.microtime());
        $part->name               = $request->name;
        $part->quantity           = $request->quantity;
        $part->min_quantity       = $request->min_quantity;
        $part->cost               = $request->cost;
        $part->area               = $request->area;
        $part->part_categories_id = $request->part_categories_id;
        $part->hospital_id        = $request->hospital_id;
        $part->description        = $request->description;
        $part->manufacturer_year  = date($request->manufacturer_year);

        if($request->image != null){
            $fileName        = Utils::saveBase64Image($request->image, microtime().'-'.$part->name, 'assets/images/parts/');
            $part->image = $fileName;
         }else{
            return response()->json(["error" => true,"message" => 'no-image']);
         }

         if($part->save()) {
             return response()->json([
                 'error'   => false,
                 'data'    => $part,
                 'message' => 'Spare part saved successfully!'
             ]);
         } else {
             return response()->json([
                 'error'   => true,
                 'message' => 'Could not save spare part. Try Again!'
             ]);
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function show(Part $part)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function edit(Part $part)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'               => 'required',
            'quantity'           => 'required',
            'min_quantity'       => 'required',
            'cost'               => 'required',
            'area'               => 'required',
            'part_categories_id' => 'required',
            'description'        => 'required',
            'manufacturer_year'  => 'required'
        ]);

        $part = Part::where('id', $request->id)->first();

        $part->name               = $request->name;
        $part->quantity           = $request->quantity;
        $part->min_quantity       = $request->min_quantity;
        $part->cost               = $request->cost;
        $part->area               = $request->area;
        $part->part_categories_id = $request->part_categories_id;
        $part->description        = $request->description;
        $part->manufacturer_year  = date($request->manufacturer_year);

        if($part->update()) {
            return response()->json([
                'error' => false,
                'data'  => $part,
                'message' => 'Spare part updated successfully!'
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Could not update spare part. Try Again!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function destroy(Part $part)
    {
        $delete = $part->delete();

        if($delete) {
            return response()->json([
                'error' => false,
                'message' => 'Spare part deleted successfully!'
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Could not delete spare part. Try Again!'
            ]);
        }
    }
}
