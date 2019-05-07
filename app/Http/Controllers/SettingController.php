<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use App\User;
use App\Hospital;
use Auth;
use DB;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $admins = User::where('role', '=', 'Hospital Admin')->where('hospital_id', '=', Auth::user()->hospital_id)->get();
        return view('setting')->with('admins', $admins);
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
            'hospital_id' => 'required',
            'user_id' => 'required'
        ]);

        $settings  = new Setting();

        $settings->hospital_id = $request->hospital_id;
        $settings->user_id = $request->user_id;

        return response()->json([
            'error' => $result,
            'data' => $settings,
            'message' => !$result ? 'Settings created successfully' : 'Error creating settings'
        ]);
    }   

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the spec ified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $status = $setting->update($request->all());

        return response()->json([
            'data' => $setting,
            'status' => $status ? 'Settings Updated Successfully' : 'Error Updating Settings'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }

    public function saveReceivers(Request $request){
        $request->validate([
            'hospital_id' => 'required',
            'user_ids' => 'required',
            'duration' => 'required'
        ]);

        $del = DB::delete("DELETE from settings where hospital_id = '$request->hospital_id'");

        $user_ids = explode(",",$request->user_ids);
        
        foreach($user_ids as $id){
            $temp = new Setting();
            $temp->hospital_id = $request->hospital_id;
            $temp->user_id = $id;

            $temp->save();
        }

        $hospital = Hospital::where('id', '=', $request->hospital_id)->first();
        $hospital->sms_frequency = $request->duration;
        $hospital->update();

        return response()->json([
            'success' => true
        ]);

    }
}
