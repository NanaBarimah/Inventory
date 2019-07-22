<?php

namespace App\Http\Controllers;

use App\PartCategory;
use App\Part;
use Illuminate\Http\Request;

class PartCategoryController extends Controller
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
            'name'        => 'required|string',
            'hospital_id' => 'required'
        ]);

        $partCategory = new PartCategory();

        $partCategory->id          = md5($request->name.microtime());
        $partCategory->name        = $request->name;
        $partCategory->hospital_id = $request->hospital_id;

        if($partCategory->save()) {
            return response()->json([
                'error'   => false,
                'data'    => $partCategory,
                'message' => 'Part category saved successfully!'
            ]);
        } else {
            return response()->json([
                'error'   => true,
                'message' => 'Could not save part category'
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PartCategory  $partCategory
     * @return \Illuminate\Http\Response
     */
    public function show(PartCategory $partCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PartCategory  $partCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(PartCategory $partCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PartCategory  $partCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PartCategory $partCategory)
    {
        $status = $partCategory->update(
            $request->only(['name'])
        );

        return response()->json([
            'data' => $partCategory,
            'message' => $status ? 'Part Category updated' : 'Error updating part category',
            'error' => !$status
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PartCategory  $partCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartCategory $partCategory)
    {
        $status = Part::where('part_category_id', $partCategory->id)->get()->count() < 1;

        if($status){
            $status = $partCategory->delete();
        }

         return response()->json([
            'error'  => !$status,
            'message' => $status ? 'Part Category deleted' : 'The selected part category already has items under it.'
         ]);
    }
}
