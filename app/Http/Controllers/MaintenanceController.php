<?php

namespace App\Http\Controllers;

use App\Maintenance;
use Illuminate\Http\Request;
use Auth;
use App\Equipment;
use App\Unit;
use DB;
use App\User;
use App\Notifications\MaintenanceCarriedOut;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'action_taken' => 'required|string',
            'recommendation' => 'nullable|string',
            'equipment_code' => 'required|string',
            'mtce_officer' => 'required',
            'type' => 'required|string',
            'cost' => 'required',
            'duration' => 'required',
            'hospital_id' => 'required'
        ]);

        if($request->type != "Planned Maintenance"){
            $request->validate([
                'duration_units' => 'required',
                'down_time' => 'required',
                'reason' => 'required',
                'date_reported' => 'required',
                'date_inspected' => 'required',
                'problem_found' => 'required',
                'faulty_category' => 'required'
            ]);
        }

        $maintenance  = new Maintenance();

        $maintenance->action_taken = $request->action_taken;
        $maintenance->recommendation = $request->recommendation;
        $maintenance->equipment_code = $request->equipment_code;
        $maintenance->mtce_officer = $request->mtce_officer;
        $maintenance->type = $request->type;
        $maintenance->cost = $request->cost;
        $maintenance->duration = $request->duration;
        //$maintenance->job_number = $request->job_number;
        $maintenance->problem_found = $request->problem_found;
        $maintenance->faulty_category = $request->faulty_category;
        if($request->function_check == 'on'){
            $maintenance->function_check = 1;
        }else{
            $maintenance->function_check = 0;
        }

        if($request->safety_check == 'on'){
            $maintenance->safety_check = 1;
        }else{
            $maintenance->safety_check = 0;
        }

        if($request->calibration_check == 'on'){
            $maintenance->calibration_check = 1;
        }else{
            $maintenance->calibration_check = 0;
        }
        $maintenance->duration_units = $request->duration_units;
        $maintenance->down_time = $request->down_time;
        $maintenance->reason = $request->reason;
        $maintenance->date_inspected = $this->formatDate($request->date_inspected);
        $maintenance->date_reported = null;
        $maintenance->date_out = null;

        if($maintenance->type != "Planned Maintenance"){
            $maintenance->date_reported = $this->formatDate($request->date_reported);
            $maintenance->date_out = date("Y-m-d H:i:s", time());
        }

        if(Maintenance::where([['equipment_code', '=', $request->equipment_code], ['job_number', '=', $request->job_number]])->get()->count() > 0){
            return response()->json([
                'error' => $result,
                'message' => 'Maintenance has already been carried out!'
            ]);
        }
        
        if($maintenance->save()){
            $result = false;
        }

        $unit_head = Equipment::with('unit')->where('code', '=', $request->equipment_code)->first();
        $unit_head = $unit_head->unit->user_id;

        $unit_head = User::where('id', '=', $unit_head)->first();

        $unit_head->notify(new MaintenanceCarriedOut($maintenance)); 

        $admin = User::where([['role', '=', 'Admin'], ['hospital_id', '=', $request->hospital_id], ['id', '<>', $request->mtce_officer]])->first();
        if($admin != null){
            $admin->notify(new MaintenanceCarriedOut($maintenance));  
        }
        
        return response()->json([
            'error' => $result,
            'data' => $maintenance,
            'message' => !$result ? 'Maintenance recorded successfully' : 'Error recording maintenance'
          ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function show(Maintenance $maintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function edit(Maintenance $maintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maintenance $maintenance)
    {
        //
    }

    public function presentUnscheduled(){
        $equipment = Equipment::where('hospital_id','=',Auth::user()->hospital_id)->with('category', 'unit')->get();

        if(strtolower(Auth::user()->role) == 'admin' || strtolower(Auth::user()->role) == 'engineer'){
            return view('maintenance-form')->with('equipment', $equipment);
        }else{
            return abort(403);
        }
    }

    public function presentMaintenanceForm($code){
        if(strtolower(Auth::user()->role) == 'admin' || strtolower(Auth::user()->role) == 'engineer'){
            return view('maintenance-form')->with('code', $code);
        }else{
            return abort(403);
        }
    }


    public function presentScheduledMaintenanceForm($code){
        if(strtolower(Auth::user()->role) == 'admin' || strtolower(Auth::user()->role) == 'engineer'){
            return view('scheduled-maintenance-form')->with('code', $code);
        }else{
            return abort(403);
        }
    }

    public function presentHistoryTable(){
        if(strtolower(Auth::user()->role) == 'admin' || strtolower(Auth::user()->role) == 'engineer'){
            $equipment = Equipment::where('hospital_id','=',Auth::user()->hospital_id)->with('category', 'unit')->get();
            return view('maintenance-history')->with('equipment', $equipment);
        }else if(Auth::user()->role == 'Unit Head'){
            $equipment = array();
            $equipments = Unit::with('equipments')->where('user_id', '=', Auth::user()->id)->get();
            
            foreach($equipments as $single){
                foreach($single->equipments as $one){
                    array_push($equipment, $one);
                }
            }

            return view('maintenance-history')->with('equipment', $equipment);
        }else{
            return abort(403);
        }
    }

    public function presentHistory($code){
        if(strtolower(Auth::user()->role) == 'admin' || strtolower(Auth::user()->role) == 'engineer' || strtolower(Auth::user()->role) == 'hospital admin' || Auth::user()->role == 'Unit Head'){
            $maintenances = Maintenance::where('equipment_code','=',$code)->with('equipment')->get();
            return view('maintenance-timeline')->with('maintenances', $maintenances);
        }else{
            return abort(403);
        }
    }

    public function plannedMaintenances(){
        $hospital_id = Auth::user()->hospital_id;
        $equipment = DB::select('SELECT * FROM equipment where code not in (SELECT equipment.code FROM equipment, maintenances where maintenances.equipment_code = equipment.code and DATE(DATE_ADD(maintenances.created_at, INTERVAL equipment.maintenance_frequency month)) <=  DATE_ADD(CURDATE(), INTERVAL equipment.maintenance_frequency month) and maintenances.type = "Planned Maintenance") and hospital_id = '.$hospital_id);
        if(strtolower(Auth::user()->role) == 'admin' || strtolower(Auth::user()->role) == 'engineer'){
            return view('planned-maintenance-list')->with('equipment', $equipment);
        }else{
            return abort(403);
        }
    }

    public function getCummulativeReport(Request $request){
        $request->validate([
            'year' => 'required',
            'hospital_id' => 'required'
        ]);
        $year = $request->year;
        $hospital_id = $request->hospital_id;

        $maintenances = DB::select("SELECT COUNT(id) as maintenances, MONTH(maintenances.created_at) as month FROM `maintenances`, equipment WHERE year(maintenances.created_at) = '$year' and equipment.hospital_id = '$hospital_id' and maintenances.equipment_code = equipment.code GROUP BY month");

        return response()->json([
            'response' => $maintenances
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getCategorizedReport(Request $request){
        $request->validate([
            'year' => 'required',
            'hospital_id' => 'required'
        ]);
        $year = $request->year;
        $hospital_id = $request->hospital_id;

        $maintenances = DB::select("SELECT COUNT(maintenances.id) as y, categories.name as name FROM `maintenances`, categories, equipment WHERE year(maintenances.created_at) = '$year' and maintenances.equipment_code = equipment.code AND equipment.category_id = categories.id and equipment.hospital_id = '$hospital_id' GROUP BY categories.name");

        return response()->json([
            'response' => $maintenances
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getUnitReport(Request $request){
        $request->validate([
            'year' => 'required',
            'hospital_id' => 'required'
        ]);

        $year = $request->year;
        $hospital_id = $request->hospital_id;

        $maintenances = DB::select("SELECT COUNT(maintenances.id) as y, units.name as name, units.id as unit_id FROM maintenances, units, equipment where year(maintenances.created_at) = '$year' and maintenances.equipment_code = equipment.code and equipment.unit_id = units.id and equipment.hospital_id = '$hospital_id' group by units.id, units.name    ");

        return response()->json([
            'response' => $maintenances
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getDepartmentReport(Request $request){
        $request->validate([
            'year' => 'required',
            'hospital_id' => 'required'
        ]);

        $year = $request->year;
        $hospital_id = $request->hospital_id;

        $maintenances = DB::select("SELECT COUNT(maintenances.id) as y, departments.name as name FROM maintenances, units, equipment, departments where year(maintenances.created_at) = '$year' and maintenances.equipment_code = equipment.code and equipment.unit_id = units.id and equipment.hospital_id = '$hospital_id' and units.department_id = departments.id group by departments.name");

        return response()->json([
            'response' => $maintenances
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function costPerMonth(Request $request){
        $request->validate([
            'year' => 'required', 
            'hospital_id' => 'required'
        ]);

        $year = $request->year;
        $hospital_id = $request->hospital_id;

        $costs = DB::select("SELECT SUM(cost) as total, MONTH(maintenances.created_at) as month FROM `maintenances`,equipment where equipment.hospital_id = '$hospital_id' and YEAR(maintenances.created_at) = '$year' and equipment.code = maintenances.equipment_code GROUP BY MONTH(maintenances.created_at)");

        return response()->json([
            'response' => $costs
        ], 200, [], JSON_NUMERIC_CHECK);
    }   

    public function costPerType(Request $request){
        $request->validate([
            'year' => 'required', 
            'hospital_id' => 'required'
        ]);

        $year = $request->year;
        $hospital_id = $request->hospital_id;

        $costs = DB::select("SELECT SUM(cost) as total, categories.name as category FROM  maintenances, equipment, categories where equipment.hospital_id = '$hospital_id' and YEAR(maintenances.created_at) = '$year' and equipment.code = maintenances.equipment_code and equipment.category_id = categories.id GROUP BY category");

        return response()->json([
            'response' => $costs
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function costPerUnit(Request $request){
        $request->validate([
            'year' => 'required', 
            'hospital_id' => 'required'
        ]);

        $year = $request->year;
        $hospital_id = $request->hospital_id;

        $costs = DB::select("SELECT SUM(cost) as y, units.name as name, units.id as unit_id FROM  maintenances, equipment, units where equipment.hospital_id = '$hospital_id' and YEAR(maintenances.created_at) = '$year' and equipment.code = maintenances.equipment_code and equipment.unit_id = units.id GROUP BY units.name, units.id");

        return response()->json([
            'response' => $costs
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function costPerDepartment(Request $request){
        $request->validate([
            'year' => 'required', 
            'hospital_id' => 'required'
        ]);

        $year = $request->year;
        $hospital_id = $request->hospital_id;

        $costs = DB::select("SELECT SUM(cost) as y, departments.name as name FROM  maintenances, equipment, units, departments where equipment.hospital_id = '$hospital_id' and YEAR(maintenances.created_at) = '$year' and equipment.code = maintenances.equipment_code and equipment.unit_id = units.id and units.department_id = departments.id GROUP BY departments.name");

        return response()->json([
            'response' => $costs
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    private function formatDate($date){
        $date = str_replace(',', '', $date);
        $date = str_replace('-', '/', $date);
        return date("Y-m-d H:i:s", strtotime(stripslashes($date)));
    }

    public function approve(){
        $user = Auth::user();

        if($user->role == 'Unit Head' || $user->is_unit_head == 1){
            $maintenances = Maintenance::with('equipment', 'equipment.unit')->whereHas(
                'equipment', function($query){
                    $query->whereHas('unit', function($q){
                        $q->where('user_id', '=', Auth::user()->id);
                    });
                })->get();

            return view('approve')->with('maintenances', $maintenances);
        }else{
            return abort(403);
        }
    }

    public function hospitalApprove(Request $request)
    {
        $request->validate([
            'is_hospital_approved' => 'required',
            'id' => 'required'
        ]);

        $maintenance = Maintenance::where('id', $request->id)->first();

        $isapprove = $request->is_hospital_approved;
        $maintenance->is_hospital_approved = $isapprove;

        if($maintenance->save()){
            return response()->json([
                'data' => $maintenance,
                'message' => 'Maintenance approved',
                'error' => false
            ]);
        }else{
            return response()->json([
                'message' => 'Maintenance could not be approved',
                'error' => true
            ]);
        }
    }

    public function adminApprove(Request $request)
    {
        $request->validate([
            'is_approved' => 'required',
            'id' => 'required'
        ]);

        $maintenance = Maintenance::where('id', $request->id)->first();

        $isapprove = $request->is_approved;
        $maintenance->is_approved = $isapprove;

        if($maintenance->save()){
            return response()->json([
                'data' => $maintenance,
                'message' => 'Maintenance approved',
                'error' => false
            ]);
        }else{
            return response()->json([
                'message' => 'Maintenance could not be approved',
                'error' => true
            ]);
        }
    }


    public function adminApprovals(){
        if(Auth::guard('admin')->user()->role== 'Admin'){
            $maintenances = Maintenance::with('equipment', 'equipment.unit', 'equipment.hospital')->whereHas(
                'equipment', function($query){
                    $query->whereHas('hospital', function($q){
                        $q->whereHas('district', function($q){
                            $q->where('region_id', '=', Auth::guard('admin')->user()->region_id);
                        });
                    });
                }
            )->get();
            return view('admin.approve')->with('maintenances', $maintenances);
        }else{
            return abort(403);
        }
    }
}
