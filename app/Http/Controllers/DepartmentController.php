<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Auth;
use App\Hospital;
use App\User;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();

        return response()->json($departments, 200);
    }

    public function getDepartmentUnits()
    {
        $department = Department::with('units')->get();

        return response()->json($department, 200);
    }

    public function getAll()
    {
        $department = Department::with(['units', 'equipments'])->get();

        return response()->json($department, 200);
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
            'name'        => 'required|string',
            'hospital_id' => 'required'
        ]);

        if(Department::where([['hospital_id', $request->hospital_id], ['name', $request->name]])->get()->count() > 0){
            return response()->json([
                'error'   => $result,
                'message' => 'Department name already exists'
            ]);
        }

        $department = new Department;

        $department->id           = md5($request->name.microtime());
        $department->name         = $request->name;
        $department->hospital_id  = $request->hospital_id;
        $department->user_id      = $request->user_id;
        $department->location     = $request->location;
        $department->phone_number = $request->phone_number;

        if($department->save()){
            $result = false;
        }

        return response()->json([
            'error'   => $result,
            'data'    => $department,
            'message' => !$result ? 'Department created successfully' : 'Error creating department'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        return response()->json($department, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $status = $department->update(
            $request->only(['name'])
        );

        return response()->json([
            'data'    => $department,
            'message' => $status ? 'Department Updated' : 'Error updating department'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
    }

    public function viewAll(){
        $departments = Department::with('units')->where('hospital_id', Auth::user()->hospital_id)->orderBy('name', 'ASC')->paginate(20);
        return view('departments')->with('departments', $departments);
    }
    
    public function view($department){
        $department = Department::where([['id' , $department], ['hospital_id', Auth::user()->hospital_id]])->first();

        if($department == null){
            return abort(404);
        }

        return view('department-details', compact('department'));
    }
}
