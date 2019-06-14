<?php

namespace App\Http\Controllers;

use App\AssetCategory;
use App\FaultCategory;
use App\Priority;

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
        $user = Auth::user();
        $asset_categories = AssetCategory::where('hospital_id', $user->hospital_id)->get();
        $fault_categories = FaultCategory::where('hospital_id', $user->hospital_id)->get();
        $priority_categories = Priority::where('hospital_id', $user->hospital_id)->get();

        return view('categories');
        //return response()->json($categories, 200);
    }
}
