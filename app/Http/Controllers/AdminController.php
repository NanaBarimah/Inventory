<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use App\Hospital;
use App\District;
use App\Requests;
use Auth;
use App\Region;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitals = Hospital::count();
        $districts = District::count();
        if(Auth::guard('admin')->user()->role == 'Admin'){
            $users = User::count();
            return view('admin.admin')->with('users', $users)->with('districts', $districts)->with('hospitals', $hospitals);
        }elseif(Auth::guard('admin')->user()->role == 'Biomedical Engineer'){
            $jobs = Requests::where('assigned_to', '=', Auth::guard('admin')->user()->id)->count();
            return view('admin.admin')->with('jobs', $jobs)->with('districts', $districts)->with('hospitals', $hospitals);
        }
        
        //$admins = Admin::all();

        //return response()->json($admins, 200);
    }

    public function profile()
    {
        $region = Region::where('id', '=', Auth::guard('admin')->user()->region_id)->first();

        return view('admin.admin-profile')->with('region', $region); 
        //$users = User::all();

        //return response()->json($users, 200);
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
        $request->validate(
            [
            'firstname' => 'required|string',
            'lastname'  => 'required|string',
            'username'  => 'required|string',
            'password'  => 'required|string|min:6|confirmed',
            'region_id' => 'required|string',
            'phone_number' => 'required|string',
            'role' => 'required'
            ]
        );
        
        $admin = new Admin(
            [
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'username'  => $request->username,
            'phone_number' => $request->phone_number,
            'password'  => bcrypt($request->password),
            'region_id' => $request->region_id,
            'role'      => $request->role,
            'id'        => md5($request->username.microtime())
            ]
        );

        if($admin->save()){
            $result = false;
        }

        return response()->json(
            [
            'error'   => $result,
            'data'    => $admin,
            'message' => !$result ? 'Successfully created Admin' : 'Error creating admin'
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return response()->json($admin, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $admin = Admin::where('id', $request->admin)->first();
        $status = true;

        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);
        
        if(request('password_reset') == 'yes'){
            if(Hash::check(request('old_password'), $admin->password)){
                $admin->password = bcrypt(request('new_password'));
            }else{
                return response()->json([
                    'error' => true,
                    'message' => 'The old password you provided is wrong'
                ]);
            }
        }
        
        $admin->firstname = $request->firstname;
        $admin->lastname = $request->lastname;

        if($admin->update()){
            $status = false;
        }
       
        return response()->json(
            [
            'error' => $status,
            'message' => !$status ? 'admin Updated Successfully!' : 'Could not update admin'
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }

    public function showEngineers(){
        $engineers = Admin::where([['role', '=', 'Biomedical Engineer'], ['region_id', '=', Auth::guard('admin')->user()->region_id]])->get();
        return view('admin.engineers')->with('engineers', $engineers);
    }

    public function addEngineer(){
        return view('admin.add-engineer');
    }

    public function is_active(Request $request)
    {
        $admin = Admin::where('id', '=', $request->admin_id)->first();

        $isactive = $request->active;
        $admin->active = $isactive;

        if($admin->save()){
            return response()->json([
                'data' => $admin,
                'message' => 'Biomedical Engineer updated',
                'error' => false
            ]);
        }else{
            return response()->json([
                'message' => 'Could not update the Biomedical engineer',
                'error' => true
            ]);
        }
    }
}
