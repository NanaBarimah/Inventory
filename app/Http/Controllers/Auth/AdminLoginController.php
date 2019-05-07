<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Config;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        Config::set('auth.providers.users.model', \App\Admin::class);
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        //Validate the form data
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|min:6'
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'active' => 1,
        ];

        //Attempt to log the user in
        if(Auth::guard('admin')->attempt($credentials, $request->remember)){
            //if successful, then redirect to intended location
            //dd(Auth::guard('admin')->user()->id);
        
            return redirect()->intended(route('admin.dashboard'));
        }
        
        //if unsuccessful, the redirect back to login page with the form data
        return redirect()->back()
            ->withInput($request->only('username', 'remember'))
            ->withErrors([
                'active' => 'This account has been deactived.'
            ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    /*public function adminLogin(Request $request)
    {
        //Validate the form
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:6'
        ]);

        $username = $request->username;
        $password = $request->password;
        $active = 1;

        $admin = Admin::where([['username', '=', $request->username], ['password', '=', $request->password], ['active', '=', 1]])->first();

        if($admin != null){
            return response()->json([
                "error" => false,
                "admin" => $admin
            ]);
        }else{
            return response()->json([
                "error" => true,
                "admin" => "No admin with specified username and password"
            ]);
        }
    }*/

}
