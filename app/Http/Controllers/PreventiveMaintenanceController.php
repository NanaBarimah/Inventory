<?php

namespace App\Http\Controllers;

use App\PreventiveMaintenance;
use App\PmSchedule;

use Auth;
use Illuminate\Http\Request;

class PreventiveMaintenanceController extends Controller
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
     * Show the form for listing resource types.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $pmSchedules = PmSchedule::where("hospital_id", Auth::user()->hospital_id)->with("priority")->get();
        return view("pm-add-step1", \compact("pmSchedules"));
    }

    /**
     * Show the form for creating a new resource
     * 
     * @return \Illuminate\Http\Response
     */
    public function make(PmSchedule $pmSchedule)
    {
        if($pmSchedule == null){
            return abort(403);
        }
        
        return view("pm-add", compact("pmSchedule"));
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
            'pm_schedule_id' => 'required'
        ]);

        $preventiveMaintenance = new PreventiveMaintenance();

        $preventiveMaintenance->pm_schedule_id = $request->pm_schedule_id;
        $preventiveMaintenance->observation    = $request->observation;
        $preventiveMaintenance->recommendation = $request->recommendation;
        $preventiveMaintenance->action_taken   = $request->action_taken;

        if($preventiveMaintenance->save()) {
            return response()->json([
                'error'   => false,
                'data'    => $preventiveMaintenance,
                'message' => 'Preventive Maintenance created successfully.'
            ]);
        }

        return response()->json([
            'error'   => true,
            'message' => 'Could not create preventive maintenance. Try Again!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PreventiveMaintenance  $preventiveMaintenance
     * @return \Illuminate\Http\Response
     */
    public function show(PreventiveMaintenance $preventiveMaintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PreventiveMaintenance  $preventiveMaintenance
     * @return \Illuminate\Http\Response
     */
    public function edit(PreventiveMaintenance $preventiveMaintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PreventiveMaintenance  $preventiveMaintenance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PreventiveMaintenance $preventiveMaintenance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PreventiveMaintenance  $preventiveMaintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(PreventiveMaintenance $preventiveMaintenance)
    {
        //
    }
}
