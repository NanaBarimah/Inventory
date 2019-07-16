<?php

namespace App\Http\Controllers;

use App\Part;
use App\Utils;
use App\PartCategory;
use Illuminate\Http\Request;

use Auth;

class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->role == 'Admin' || $user->role == 'Regular Tech') {
            $parts = Part::with("part_category")->where('hospital_id', Auth::user()->hospital_id)->get();
            $part_categories = PartCategory::where('hospital_id', Auth::user()->hospital_id)->get();
            return view('spare-parts', compact("parts", "part_categories"));
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
        $part->part_category_id   = $request->part_category_id;
        $part->description        = $request->description;
        $part->hospital_id        = $request->hospital_id;
        $part->manufacturer_year  = date('Y-m-d', $request->manufacturer_year);

        if($request->image != null){
            $file = $request->file('image');

            $name = md5($file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
            $file->move(public_path().'/img/assets/parts/', $name);
            
            $part->image = $name;
        }


        if($part->save()){
            return response()->json([
                'error' => false,
                'data' => $part,
                'message' => "Spare part saved successfully"
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => "Could not save this spare part"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function show($part)
    {
        //
        $user = Auth::user();
        if($user->role == 'Admin' || $user->role == 'Regular Technician') {
            $part = Part::with('part_category')->where('id', $part)->where('hospital_id', $user->hospital_id)->first();
            $part_categories = PartCategory::where('hospital_id', $user->hospital_id)->get();
            
            if($part == null){
                return abort(403);
            }

            return view('part-details', compact("part", "part_categories"));
        } else {
            abort(403);
        }
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
    public function update(Request $request, Part $part)
    {
        $request->validate([
            'name'               => 'required',
            'min_quantity'       => 'required',
            'cost'               => 'required',
            'part_category_id' => 'required',
        ]);
        
        $part->name              = $request->name;
        $part->quantity          = $request->quantity;
        $part->min_quantity      = $request->min_quantity;
        $part->cost              = $request->cost;
        $part->area              = $request->area;
        $part->part_category_id  = $request->part_category_id;
        $part->description       = $request->description;
        $part->manufacturer_year  = date('Y-m-d', $request->manufacturer_year);

        if($request->image != null){
            $file = $request->file('image');

           $name = md5($file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
           $file->move(public_path().'/img/assets/parts/', $name);
           
           $part->image = $name;
        }


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
