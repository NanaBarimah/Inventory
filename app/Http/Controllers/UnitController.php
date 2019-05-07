<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use App\Department;
use Auth;
use App\User;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::all();

        return response()->json($units, 200);
    }

    public function getUnitEquipment()
    {
        $unit = Unit::with('equipments')->get();

        return response()->json($unit, 200);
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
            'name' => 'required|string',
            'department_id' => 'required'
        ]);
       
        
        if($request->user_id == null || $request->user_id == 'add_new'){
    
            $user = new User();

            $user->id        = md5($request->username.microtime());
            $user->firstname = $request->firstname;
            $user->lastname  = $request->lastname;
            $user->username  = $request->username;
            $user->password  = bcrypt($request->password);
            $user->phone_number = $request->phone_number;
            $user->hospital_id = $request->hospital_id;
            $user->role = 'Unit Head';
            
            if($user->save()){
                $unit  = new Unit();
    
                $unit->name = $request->name;
                $unit->department_id = $request->department_id;
                $unit->user_id = $user->id;    
                
                if(Unit::where([['name', $request->name], ['department_id', $request->department_id]])->get()->count() > 0){
                    return response()->json([
                        'error' => $result,
                        'message' => 'Unit name already exists in this department'
                    ]);
                }
                if($unit->save()){
                    $result = false;
                }
    
            }
    
            return response()->json([
                'error' => $result,
                'data' => $unit,
                'message' => !$result ? 'Unit created successfully' : 'Error creating unit'
              ]);
        }else{
            $unit  = new Unit();
    
            $unit->name = $request->name;
            $unit->department_id = $request->department_id;
            $unit->user_id = $request->user_id;    
                
            if(Unit::where([['name', $request->name], ['department_id', $request->department_id]])->get()->count() > 0){
                return response()->json([
                    'error' => $result,
                    'message' => 'Unit name already exists in this department'
                ]);
            }
            
            if($unit->save()){
                $result = false;

                $user = User::where('id', $request->user_id)->first();
                if($user){
                    $is_unit_head = 1;
                    $user->is_unit_head = $is_unit_head;

                    $user->save();
                }else{
                    //rollback
                    $result = true;
                    return response()->json([
                        'error' => $result,
                        'data' => $unit,
                        'message' => !$result ? 'Unit created successfully' : 'Error creating unit. Unit head could not be assigned.'
                      ]);
                }
            }
            
            return response()->json([
                'error' => $result,
                'data' => $unit,
                'message' => !$result ? 'Unit created successfully' : 'Error creating unit'
              ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        return response()->json($unit, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        $status = $unit->update(
            $request->only(['name', 'department_id'])
        );

        return response()->json([
            'data' => $unit,
            'message' => $status ? 'Unit Updated' : 'Error updating unit'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        //
    }

   

    public function viewAll(){
        $department = Department::where('hospital_id', Auth::user()->hospital_id)->get();
        $users = User::where('hospital_id', Auth::user()->hospital_id)->get();
        if(strtolower(Auth::user()->role) == 'admin' || strtolower(Auth::user()->role) == 'storekeeper'){
            return view('units')->with('departments', $department)->with('users', $users);
        }else{
            return abort(403);
        }
    }
}
