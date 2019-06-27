<?php

namespace App\Http\Controllers;

use App\PmSchedule;
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
        $pmSchedules = PmSchedule::with('assets')->where('hospital_id', Auth::user()->hospital_id)->get();

        return view();
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
            'title'             => 'required',
            'recurringSchedule' => 'required',
            'due_date'          => 'required',
            'endDueDate'        => 'required'
        ]);

        $pmSchedule = new PmSchedule();

        $pmSchedule->title             = $request->title;
        $pmSchedule->recurringSchedule = $request->recurringSchedule;
        $pmSchedule->due_date          = date('Y-m-d', strtotime($request->due_date));
        $pmSchedule->endDueDate        = date('Y-m-d', strtotime($request->endDueDate));
        $pmSchedule->cost              = $request->cost;
        $pmSchedule->department_id     = $request->department_id;
        $pmSchedule->unit_id           = $request->unit_id;
        $pmSchedule->priority_id       = $request->priority_id;
        $pmSchedule->hospital_id       = $request->hospital_id;
        $pmSchedule->description       = $request->description;

        if($pmSchedule->save()){
            if($request->asset_id != null){
                $pmSchedule->assets()->attach($request->asset_id);
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
    public function show(PmSchedule $pmSchedule)
    {
        //
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
