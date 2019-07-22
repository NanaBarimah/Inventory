<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Hospital;
use Auth;
use Mail;
use Notification;
use App\Notifications\UserFormUpdate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $hospital = Hospital::where('id', '=', $user->hospital_id)->first();

        return view('user-profile')->with('hospital', $hospital)->with('user', $user);
        //$users = User::all();

        //return response()->json($users, 200);
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
            'email'  => 'required|string|unique:users',
            'hospital_id' => 'required|string',
            'role' => 'required'
        ]);
        
        $user = new User();

        $user->id           = md5($request->email.microtime());   
        $user->firstname    = $request->firstname;
        $user->lastname     = $request->lastname;
        $user->email        = $request->email;
        $user->role         = $request->role; 
        $user->password     = $request->password;
        $user->phone_number = $request->phone_number;
        $user->job_title    = $request->job_title;
        $user->hospital_id  = $request->hospital_id; 

        if($user->save()){
            $hospital = $user->hospital()->first();
            $result = false;

            $data = array("user" => $user, "hospital" => $hospital);

            $to_name = ucwords($request->firstname.' '. $request->lastname);
            $to_email = $user->email;

            Mail::send('email_templates.new_user', $data, function($message) use($to_name, $to_email) {
                $message->to($to_email, $to_name)
                        ->subject('Welcome To The Team');
                $message->from('noreply@maintainme.com', 'MaintainMe');
            });

            if(count(Mail::failures()) > 0) {
                return response()->json([
                    'error' => true,
                    'message' => 'Could not send the mail. Try again!'
                ]);
            } else {
                return response()->json([
                    'error' => false,
                    'message' => 'User profile completion link sent successfully!'
                ]);
            }
        }

        return response()->json([
            'error'   => $result,
            'data'    => $user,
            'message' => !$result ? 'User created successfully' : 'Error creating user'
            ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::where('id', $request->user)->first();
        $status = true;

        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);
        
        if(request('password_reset') == 'yes'){
            if(Hash::check(request('old_password'), $user->password)){
                $user->password = bcrypt(request('new_password'));
            }else{
                return response()->json([
                    'error' => true,
                    'message' => 'The old password you provided is wrong'
                ]);
            }
        }
        
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;

        if($user->update()){
            $status = false;
        }
       
        return response()->json(
            [
            'error' => $status,
            'message' => !$status ? 'User Updated Successfully!' : 'Could not update user'
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function listAll()
    {
        $user = Auth::user();

        if(strtolower($user->role) == 'admin'){
            $users = User::where('hospital_id', '=', $user->hospital_id)->get();

            return view('all-users')->with('users', $users)->with('user', $user);
        }else{
            return abort(403);
        }
    }

    public function addNew()
    {
        $user = Auth::user();
        if(strtolower($user->role) == 'admin') {
            return view('add-user', compact("user"));
        } else {
            abort(403);
        }
    }

    public function is_active (Request $request)
    {
         $user = User::where('id', $request->user_id)->first();

         $isactive     = $request->active;
         $user->active = $isactive;

         if ($user->save())
         {
            return response()->json([
               'data'    => $user,
               'message' => 'User updated',
               'error' => false
            ]); 
         }
         else
         {
            return response()->json([
               'message' => 'Could not update the user',
               'error'   => true
            ]);
         }
    }

    public function viewAll()
    {
        $user = Auth::user();

        $users = User::with('hospital')->get();
        return view('admin.users')->with('users', $users)->with('user', $user);
    }

    public function completeProfile($id)
    {
        $user = User::with('hospital')->where('id', $id)->where('completed', 0)->first();

        if($user == null){
            return abort(404);
        }

        return view('complete-profile')->with('user', $user);
    }

    public function complete(Request $request, User $user)
    {
        $request->validate([
            'firstname'    => 'required|string',
            'lastname'     => 'required|string',
            'password'     => 'required|string|min:6|confirmed',
            'phone_number' => 'required|string',
            'job_title'    => 'required|string'
        ]);

        $user = User::where('id', $request->id)->first();
        
        if($user == null){
            return response("Forbidden request", 503);
        }

        $user->firstname    = $request->firstname;
        $user->lastname     = $request->lastname;
        $user->password     = $request->password;
        $user->phone_number = $request->phone_number;
        $user->job_title    = $request->job_title;
        $user->completed    = 1;

        if($user->save()){
            $users = User::where([['role', 'Admin'], ['hospital_id', $user->hospital_id]])->get();
            Notification::send($users, new UserFormUpdate($user));
            
            return response()->json([
                'error'   => false,
                'user'    => $user,
                'message' => 'User profile completed successfully!'
            ]);
        }

        return response()->json([
            'error'   => true,
            'message' => 'Could not complete the user profile'
        ]);

    }
}
