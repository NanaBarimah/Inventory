<?php

namespace App\Http\Controllers;

use App\Hospital;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\District;
use App\User;
use App\Service_Vendor;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitals = Hospital::with('district')->get();

        return view('admin.hospitals')->with('hospitals', $hospitals);
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
            'name'           => 'required|string',
            'address'        => 'required|string',
            'district_id'    => 'required',
            'contact_number' => 'required'
        ]);

        $hospital  = new Hospital();

        $hospital->id             = md5($request->name.microtime());
        $hospital->name           = $request->name;
        $hospital->address        = $request->address;
        $hospital->district_id    = $request->district_id;
        $hospital->contact_number = $request->contact_number;

        if($d = $hospital->save()){
            $service = new Service_Vendor();

            $service->name           = 'None';
            $service->contact_number = 'No contact';
            $service->hospital_id    = $hospital->id;

            $ghs = new Service_Vendor();

            $ghs->name = 'Ghana Health Service';
            $ghs->contact_number = 'No contact';
            $ghs->hospital_id = $hospital->id;

            if($service->save() && $ghs->save()){
                $user = new User();

                $user->id           = md5($request->username.microtime());
                $user->firstname    = $request->firstname;
                $user->lastname     = $request->lastname;
                $user->username     = $request->username;
                $user->phone_number = $request->phone_number;
                $user->password     = bcrypt('Password');
                $user->hospital_id  = $hospital->id;
                $user->role         = 'Admin';
    
                if($user->save()){
                    $result = false;
                }   
            }
        }
        

        return response()->json([
            'error'   => $result,
            'data'    => $hospital,
            'message' => !$result ? 'Hospital created successfully' : 'Error creating hospital'
          ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function show(Hospital $hospital)
    {
        return response()->json($hospital, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function edit(Hospital $hospital)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hospital $hospital)
    {
        $status = $hospital->update(
            $request->only(['name', 'address', 'district_id', 'contact_number'])
        );

        return response()->json([
            'data'    => $hospital,
            'message' => $status ? 'Hospital Updated' : 'Error updating hospital'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hospital $hospital)
    {
        //
    }

    public function viewHospital($code){
        $hospital = Hospital::where('id', $code)->with(['users', 'district', 'equipments'])->first();
        $years = DB::select('SELECT DISTINCT(YEAR(created_at)) as year FROM maintenances');
        return view('admin.single_hospital')->with('hospital', $hospital)->with('years', $years);
}

    public function addHospital(){
        $districts = District::where('region_id', Auth::guard('admin')->user()->region_id)->get();
        return view('admin.add-hospital')->with('districts', $districts);
    }

    public function updateHospital($code){
        if(Auth::guard('admin')->user()->role == 'Admin'){
            $hospital = Hospital::where('id', $code)->first();
            $districts = District::where('region_id', Auth::guard('admin')->user()->region_id)->get();

            return view('admin.edit-hospital')->with('districts', $districts)->with('hospital', $hospital);
        }else{
            abort(403);
        }
    }

    public function updateSettings(Request $request){
        $request->validate([
            'hospital_id' => 'required',
            'sms_number' => 'required',
            'sms_frequency' => 'required'
        ]);

        $hospital = Hospital::find($request->hospital_id);
        $hospital->sms_number = $request->sms_number;
        $hospital->sms_frequency = $request->sms_frequency;

        $status = $hospital->update();

        return response()->json([
            'success' => $status
        ]);
    }
}
