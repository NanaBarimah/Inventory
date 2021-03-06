<?php

namespace App\Http\Controllers;

use App\District;
use Illuminate\Http\Request;
use Auth;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districts = District::all();

        return response()->json($districts, 200);
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
            'region_id' => 'required'
        ]);

        $district = new District();

        $district->name = $request->name;
        $district->region_id = $request->region_id;

        if(District::where('name', '=', $request->name)->get()->count() > 0){
            return response()->json([
                'error' => $result,
                'message' => 'District name already exists'
            ]);
        }

        if($district->save()){
            $result = false;
        }

        return response()->json([
            'error' => $result,
            'data' => $district,
            'message' => !$result ? 'District created successfully' : 'Error creating district'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        return response()->json($district, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, District $district)
    {
        $status = $district->update(
            $request->only(['name'])
        );

        return response()->json([
            'data' => $district,
            'message' => $status ? 'District Updated' : 'Error updating district'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        //
    }

    public function viewAll(){
        $districts = District::where('region_id', Auth::guard('admin')->user()->region_id)->get();

        return view('admin.districts')->with('districts', $districts);
    }
}
