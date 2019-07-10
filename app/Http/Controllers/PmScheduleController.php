<?php

namespace App\Http\Controllers;

use App\PmSchedule;
use App\Hospital;
use App\PmAction;

use Auth;
use Illuminate\Http\Request;

class PmScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pmSchedules = PmSchedule::with("priority")->where('hospital_id', Auth::user()->hospital_id)->get();

        return view("pm-types", compact("pmSchedules"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $hospital = Hospital::where("id", Auth::user()->hospital_id)->with("priorities", "asset_categories", "assets", "departments", "departments.units")->first();
        return view('pm-types-add', \compact("hospital"));
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
            'title'             => 'required',
            'recurringSchedule' => 'required',
            'due_date'          => 'required'
        ]);

        $pmSchedule = new PmSchedule();
        
        $pmSchedule->id                = md5($request->title.microtime());
        $pmSchedule->title             = $request->title;
        $pmSchedule->recurringSchedule = $request->recurringSchedule;
        $pmSchedule->due_date          = date('Y-m-d H:i:s', strtotime($request->due_date));
        $pmSchedule->endDueDate        = $request->endDueDate != null ? date('Y-m-d', strtotime($request->endDueDate)) : null;
        $pmSchedule->department_id     = $request->department_id;
        $pmSchedule->unit_id           = $request->unit_id;
        $pmSchedule->priority_id       = $request->priority_id;
        $pmSchedule->hospital_id       = $request->hospital_id;
        $pmSchedule->description       = $request->description;
        $pmSchedule->asset_category_id = $request->asset_category_id;
        
        if($request->rescheduledBasedOnCompletion == "on"){
            $pmSchedule->rescheduledBasedOnCompletion = 1;
        }else if($request->rescheduledBasedOnCompletion == "off"){
            $pmSchedule->rescheduledBasedOnCompletion = 0;
        }

        if($pmSchedule->save()){
            if($request->assets != null){
                $pmSchedule->assets()->attach($request->assets);
            }

            if($request->actions != null){
                $actions = explode("," , $request->actions);
                $pmActions = array();
                
                foreach($actions as $action){
                    array_push($pmActions, array("pm_schedule_id" => $pmSchedule->id, "name" => $action, "created_at" => date('Y-m-d H:i:s')));
                }

                PmAction::insert($pmActions);
            }

            
            return response()->json([
                'error'       => false,
                'Pm Schedule' => $pmSchedule,
                'message'     => 'Preventive Maintenance Schedule created successfully'
            ]);
        }

        return response()->json([
            'error'   => true,
            'message' => 'Could not create prevent maintenance schedule. Try Again!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PmSchedule  $pmSchedule
     * @return \Illuminate\Http\Response
     */
    public function show($pmSchedule)
    {
        //
        $pmSchedule = PmSchedule::with("preventive_maintenances", "priority", "department", "unit", "assets", "actions")->where("id", $pmSchedule)->first();
        $hospital = Hospital::where("id", Auth::user()->hospital_id)->with("priorities", "asset_categories", "assets", "departments", "departments.units")->first();
        return view("pm-type-details", compact("pmSchedule", "hospital"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PmSchedule  $pmSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(PmSchedule $pmSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PmSchedule  $pmSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PmSchedule $pmSchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PmSchedule  $pmSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(PmSchedule $pmSchedule)
    {
        $status = $pmSchedule->delete();

        if($status) {
            $pmSchedule->assets()->detach();

            return response()->json([
                'error'   => false,
                'message' => 'Preventive Maintenance Schedule deleted successfully'
            ]); 
        }

        return response()->json([
            'error'  => true,
            'message' => 'Could not delete preventive maintenance schedule. Try Again!'
        ]);
    }

    public function getPmSchedule($id)
    {
        $pmSchedule = PmSchedule::with('assets')->where([['id', $id], ['hospital_id', Auth::user()->hospital_id]])->first();

        return view();
    }
}
