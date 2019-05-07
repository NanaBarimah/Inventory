<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Auth;

class CategoryController extends Controller
{
    /*public function __construct(){
        $this->middleware('auth');
    }*/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        if(strtolower(Auth::guard('admin')->user()->role) == 'admin'){
            return view('admin.categories', compact('categories'));
        }else{
            return abort(403);
        }
        //return response()->json($categories, 200);
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
            'name' => 'required|string'
        ]);
            
        $category  = new Category();

        $category->name = $request->name;
        //$category->hospital_id = $request->hospital_id;
        if(Category::where('name', '=', $request->name)->get()->count() > 0){
            return response()->json([
                'error' => $result,
                'message' => 'Category name already exists'
            ]);
        }
        
        if($category->save()){
            $result = false;
        }

        return response()->json([
            'error' => $result,
            'data' => $category,
            'message' => !$result ? 'Category created successfully' : 'Error creating category'
          ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json($category, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $status = $category->update(
            $request->only(['name'])
        );

        return response()->json([
            'data' => $category,
            'message' => $status ? 'Category Updated' : 'Error updating category'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
