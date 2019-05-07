<?php

namespace App\Http\Controllers;

use App\Schedule;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Equipment;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipment = Equipment::where('hospital_id', '=', Auth::user()->hospital_id)->get();
        if(strtolower(Auth::user()->role) == 'admin' || strtolower(Auth::user()->role) == 'engineer'){
            return view('schedule')->with('equipment', $equipment);
        }else{
            return abort(403);
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
        $result = true;
        $request->validate([
            'equipment_code' => 'required|string',
            'maintenance_type' => 'required',
            'maintenance_date' => 'required'
        ]);

        $schedule  = new Schedule();

        $schedule->equipment_code = $request->equipment_code;
        $schedule->maintenance_type = $request->maintenance_type;
        $schedule->maintenance_date = $request->maintenance_date;

        if($schedule->save()){
            $result = false;
        }

        return response()->json([
            'error' => $result,
            'data' => $schedule
          ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }

    public function fetchAll(){
        $hospital_id = Auth::user()->hospital_id;
        $events = DB::select("SELECT * from schedules, equipment where schedules.equipment_code = equipment.code and equipment.hospital_id = '$hospital_id'");
        $response = array();
        
        foreach($events as $event){
            $temp = array();
            $temp['id'] = $event->id;
            $temp['title'] = $event->equipment_code.' - '.$event->maintenance_type;
            $temp['start'] = $event->maintenance_date;
            $temp['end'] = $event->maintenance_date;

            array_push($response, $temp);
        }

        return json_encode($response);
    }

}
