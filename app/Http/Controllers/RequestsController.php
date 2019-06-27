<?php

namespace App\Http\Controllers;

use App\Requests;
use App\WorkOrder;
use App\User;
use Auth;
use App\Notifications\RequestReceived;
use App\Notifications\RequestAssigned;
use App\Notifications\AssignedToEngineer;
use Illuminate\Http\Request;
use App\Hospital;
class RequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = Requests::where('hospital_id', Auth::user()->hospital_id)->with("priority", "user")->get();
        return view('requests', compact("requests"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $hospital = Hospital::where('id', Auth::user()->hospital_id)->with("priorities", "departments", "departments.units", "assets")->first();
        return view('request-add', compact("hospital"));
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
            'title'       => 'required',
            'hospital_id' => 'required'
        ]);

        $work_request  = new Requests();
        
        $work_request->title         = $request->title;
        $work_request->id            = md5(microtime().$request->title);
        $work_request->description   = $request->description;
        $work_request->priority_id   = $request->priority_id;
        $work_request->department_id = $request->department_id;
        $work_request->unit_id       = $request->unit_id;
        $work_request->asset_id      = $request->asset_id;
        $work_request->hospital_id   = $request->hospital_id;

        if($request->requested_by != null) {
            $work_request->requested_by = $request->requested_by;
        } else {
            $work_request->requester_name   = $request->requester_name;
            $work_request->requester_number = $request->requester_number;
            $work_request->requester_email  = $request->requester_email;
        }

        if($request->image != null) {
            $request->validate([
                'image'   => 'mimes:png,jpg,jpeg'
            ]);

            $file = $request->file('image');

            $name = md5($file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
            $file->move(public_path().'/img/assets/request/', $name);
            
            $work_request->image = $name;
         }

         if($request->hasFile('fileName')) {
             $request->validate([
                'fileName'   => 'required|mimes:doc,pdf,docx,zip'
             ]);
            $file = $request->file('fileName');
            $name = $file->getClientOriginalName();
            $name = time(). '-' . $name;
            $file->move('files', $name);
            $work_request->fileName = $name;
         }

         if($work_request->save()) {
             $user = User::where([['role', 'Admin'], ['hospital_id', $request->hospital_id]])->first();
             if($user != null) {
                $user->notify(new RequestReceived($work_request));
             }
            
            return response()->json([
                'error' => false,
                'data' => $work_request,
                'message' => 'Request created successfully'
            ]);
         }

        return response()->json([
            'error' => true,
            'message' => 'Error creating request'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Requests  $requests
     * @return \Illuminate\Http\Response
     */
    public function show($request)
    {
        //
        $request = Requests::where('id', $request)->with("priority", "user", "asset", "unit", "department")->first();
        return view("request-details", compact("request"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Requests  $requests
     * @return \Illuminate\Http\Response
     */
    public function edit(Requests $requests)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Requests  $requests
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requests $requests)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Requests  $requests
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requests $requests)
    {
        //
    }

    public function approve(Requests $work_request, Request $request)
    {
        $work_request->approve();

        $work_request->response = $request->response;
        $work_request->reason = null;

        if($work_request->save()) {
            $last_order = WorkOrder::where("hospital_id", $request->hospital_id)->latest()->first();
            $work_order = $work_request->toWorkOrder();

            
            if($last_order == null){
             $work_order->wo_number = 1;   
            }else{
                $work_order->wo_number = $last_order->wo_number ++;
            }
            $work_order->user_admin = $request->user_id;

            if($work_order->save()) {
                return response()->json([
                    'error'   => false,
                    'work_order' => $work_order,
                    'message' => 'Request approved. A work order has been generated'
                ]);   
            }
            
            return response()->json([
                'error'   => false,
                'message' => 'Request approved. Could not create a work order. Create a new work order.'
            ]);
        } 

        return response()->json([
            'error'   => true,
            'message' => 'Could not approve work order request. Try Again!'
        ]);
    }

    public function decline(Requests $work_request, Request $request)
    {
        $work_request->decline();

        $work_request->reason = $request->reason;

        if($work_request->save()) {
            return response()->json([
                'error'   => false,
                'message' => 'Work order request declined'
            ]);
        } 

        return response()->json([
            'error'   => true,
            'message' => 'Could not decline work order request. Try Again!'
        ]);
    }

    private function formatDate($date){
        $date = str_replace(',', '', $date);
        $date = str_replace('-', '/', $date);
        return date("Y-m-d H:i:s", strtotime(stripslashes($date)));
    }
}
