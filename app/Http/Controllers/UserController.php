<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Hospital;
use Auth;
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
        $hospital = Hospital::where('id', '=', Auth::user()->hospital_id)->first();

        return view('user-profile')->with('hospital', $hospital);
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
        $request->validate(
            [
            'firstname' => 'required|string',
            'lastname'  => 'required|string',
            'username'  => 'required|string|unique:users',
            'password'  => 'required|string|min:6|confirmed',
            'hospital_id' => 'required|string',
            'phone_number' => 'required|string',
            'role' => 'required'
            ]
        );
        
        $user = new User(
            [
            'id'        => md5($request->username.microtime()),    
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'username'  => $request->username,
            'phone_number' => $request->phone_number,
            'password'  => bcrypt($request->password),
            'hospital_id' => $request->hospital_id,
            'role'      => $request->role  
            ]
        );

        if($user->save()){
            $result = false;
        }

        return response()->json(
            [
            'error'   => $result,
            'data'    => $user,
            'message' => !$result ? 'Successfully created user' : 'Error creating user'
            ],
            201
        );
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
        $user = User::findOrFail($request->user)->first();
        $status = true;

        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required'
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
        $user->username = $request->username;

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

    public function listAll(){
        if(strtolower(Auth::user()->role) == 'admin'){
            $users = User::where('hospital_id', '=', Auth::user()->hospital_id)->get();

            return view('all-users')->with('users', $users);
        }else{
            return abort(403);
        }
    }

    public function addNew(){
        return view('add-user');
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

      public function viewAll(){
          $users = User::with('hospital')->get();
          return view('admin.users')->with('users', $users);
      }

      public function userLogin(Request $request)
      {
          //validate the form
          $request->validate([
              'username' => 'required|string',
              'password' => 'required|min:6'
          ]);

          $username = $request->username;
          $password = $request->password;
          $active = 1;

          $user = User::where([['username', '=', $request->username], ['password', '=', $request->password], ['active', '=', 1]])->first();

          if($user != null){
              $user->api_token = bin2hex(openssl_random_pseudo_bytes(30));
              return response()->json([
                  "error" => false,
                  "user" => $user
              ]);
          }else{
              return response()->json([
                  "error" => true,
                  "user" => "No user with specified username and password"
              ]);
          }
      }
}
