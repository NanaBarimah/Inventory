<?php

namespace App\Http\Controllers;

use App\AssetCategory;
use Illuminate\Http\Request;

class AssetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assetCategory = AssetCategory::with('parent', 'children')->get();

        return view('asset-category')->with('assetCategory', $assetCategory);
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
            'name'        => 'required|string',
            'hospital_id' => 'required'
        ]);

        $assetCategory = new AssetCategory();

        $assetCategory->name        = $request->name;
        $assetCategory->hospital_id = $request->hospital_id;

        if($assetCategory->save()){
            return response()->json([
                'error'   => false,
                'data'    => $assetCategory,
                'message' => 'Asset category saved successfully!'
            ]);
        }

        return response()->json([
            'error'   => true,
            'message' => 'Could not save asset category'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AssetCategory  $assetCategory
     * @return \Illuminate\Http\Response
     */
    public function show(AssetCategory $assetCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AssetCategory  $assetCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(AssetCategory $assetCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AssetCategory  $assetCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssetCategory $assetCategory)
    {
        $status = $assetCategory->update(
            $request->only(['name'])
        );

        return response()->json([
            'data' => $assetCategory,
            'message' => $status ? 'Asset category updated' : 'Error updating asset category'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AssetCategory  $assetCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetCategory $assetCategory)
    {
        //
    }
}