<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Schedule;
use DB;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospital_id = Auth::user()->hospital_id;
        $schedules = DB::select("SELECT * from schedules, equipment where schedules.equipment_code = equipment.code and equipment.hospital_id = '$hospital_id' and maintenance_date >= curdate() order by maintenance_date asc limit 0, 5");
        return view('home')->with('schedules', $schedules);
    }
}
