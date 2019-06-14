<?php

namespace App\Http\Controllers;

use App\FaultCategory;
use Illuminate\Http\Request;

class FaultCategoryController extends Controller
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
            'name' => 'required|string'
        ]);

        $faultCategory = new FaultCategory();

        $faultCategory->name = $request->name;

        if($faultCategory->save()){
            return response()->json([
                'error'   => false,
                'data'    => $faultCategory,
                'message' => 'Fault category saved successfully!'
            ]);
        }

        return response()->json([
            'error'   => true,
            'message' => 'Could not save fault category'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FaultCategory  $faultCategory
     * @return \Illuminate\Http\Response
     */
    public function show(FaultCategory $faultCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FaultCategory  $faultCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(FaultCategory $faultCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FaultCategory  $faultCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FaultCategory $faultCategory)
    {
        $status = $faultCategory->update(
            $request->only(['name'])
        );

        return response()->json([
            'data' => $faultCategory,
            'message' => $status ? 'Fault category updated' : 'Error updating fault category'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FaultCategory  $faultCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(FaultCategory $faultCategory)
    {
        //
    }
}
