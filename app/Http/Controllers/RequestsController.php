<?php

namespace App\Http\Controllers;

use App\Requests;
use App\Equipment;
use App\Equipment_request;
use App\Admin;
use App\User;
use App\Unit;
use App\Department;
use Auth;
use DB;
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
        if(Auth::user()->role == 'Unit Head'){
            $equipment = Equipment::with('unit', 'category', 'unit.department')->where('hospital_id', '=', Auth::user()->hospital_id)->whereHas('unit', function($u){
                $u->where('user_id', Auth::user()->id);
            })->get();
        }elseif (Auth::user()->role == 'Department Head') {
            $equipment = Equipment::with('unit', 'category', 'unit.department')->where('hospital_id', '=', Auth::user()->hospital_id)->whereHas('unit', function($u){
                $u->whereHas('department', function($d){
                    $d->where('user_id', Auth::user()->id);
                });
            })->get();
        }elseif (Auth::user()->role == 'Admin' || Auth::user()->role == 'Engineer') {
            $equipment = Equipment::with('unit', 'category', 'unit.department')->where('hospital_id', '=', Auth::user()->hospital_id)->get(); 
        }else{
            abort(403);
        }

        $region = Hospital::with('district', 'district.region')->where('id', '=', Auth::user()->hospital_id)->first();

        $region = $region->district->region_id;
        return view('request')->with('equipment', $equipment)->with('region', $region);
    }

    public function viewAll(){
        $requests = Requests::with('equipments', 'engineer')->whereHas('equipments', function($q){
            $q->where('hospital_id', Auth::user()->hospital_id);
        })->get();

        /*return response()->json([
            'requests' => $requests
        ]);*/
        return view('requests')->with('requests', $requests);
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
            'maintenance_type' => 'required',
            'description' => 'required',
            'region_id' => 'required'
        ]);

        $requests  = new Requests();
        
        $requests->maintenance_type = $request->maintenance_type;
        $requests->description = $request->description;
        $equipment_codes = $request->equipment_codes;

        if($requests->save()){
            $result = false;
            foreach($equipment_codes as $single){
                $equipment_request = new Equipment_request();

                $equipment_request->requests_id = $requests->id;
                $equipment_request->equipment_code = $single;

                $equipment_request->save();
            }

            $admin = Admin::where([['role', '=', 'Admin'], ['region_id', '=', $request->region_id]])->first();

            $admin->notify(new RequestReceived($requests));
        }

        return response()->json([
            'error' => $result,
            'data' => $requests,
            'equipment' => $equipment_codes,
            'message' => !$result ? 'Requests created successfully' : 'Error creating requests'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Requests  $requests
     * @return \Illuminate\Http\Response
     */
    public function show(Requests $requests)
    {
        //
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

    public function adminIndex(){
        $requests = Requests::with('equipments', 'equipments.hospital')->whereHas('equipments', function($q){
            $q->whereHas('hospital', function($qr){
                $qr->whereHas('district', function($qry){
                    $qry->where('region_id', '=', Auth::guard('admin')->user()->region_id);
                });
            });
        })->orderBy('is_checked', 'desc')->get();
        $engineers = Admin::where('role', '=', 'Biomedical Engineer')->get();
        return view('admin.requests')->with('requests', $requests)->with('engineers', $engineers);
    }

    public function assign(Request $request){

        $request->validate([
            'id' => 'required',
            'assigned_to' => 'required',
            'scheduled_for' => 'required',
            'hospital_id' => 'required'
        ]);

        /*$requests = Requests::find($request->id)->first();
        $requests->assigned_to = $request->assigned_to;
        $requests->scheduled_for = $this->formatDate($request->scheduled_for);

        $status = $requests->save();*/
        $request->scheduled_for = $this->formatDate($request->scheduled_for);
        $status = DB::table('requests')->where('id', $request->id)->update(['assigned_to' => $request->assigned_to, 'scheduled_for' => $request->scheduled_for, 'is_checked' => 1]);

        if($status){
            $temp = new Requests;
            $temp->id = $request->id;
            $temp->assigned_to = $request->assigned_to;
            $temp->scheduled_for = $request->scheduled_for;


            $admin = Admin::where('id', $request->assigned_to)->first();

            $admin->notify(new AssignedToEngineer($temp));   

            $user = User::where([['hospital_id', '=', $request->hospital_id], ['role', '=', 'Admin']])->first();

            $user->notify(new RequestAssigned($temp));
        }

        return response()->json([
            'error' => !$status,
            'message' => $status ? 'Request updated' : 'Could not update request'
        ]);
    }

    public function presentEngineerJobs(){
        $requests = Requests::where('assigned_to', '=', Auth::guard('admin')->user()->id)->with('equipments', 'equipments.hospital')->get();
        return view('admin.engineer-requests')->with('requests', $requests);
    }

    public function handleMaintenance($equipment, $job){
        $requests = Requests::where('id', '=', $job)->first();
        $hospital = Equipment::with('unit', 'unit.department')->where('code', '=', $equipment)->first();
        $hospital = $hospital->unit->department->hospital_id;
        return view('admin.maintenance-form')->with('equipment', $equipment)->with('requests', $requests)->with('hospital', $hospital);
    }

    private function formatDate($date){
        $date = str_replace(',', '', $date);
        $date = str_replace('-', '/', $date);
        return date("Y-m-d H:i:s", strtotime(stripslashes($date)));
    }
}
