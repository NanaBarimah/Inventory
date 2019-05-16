<?php

namespace App\Http\Controllers;

use App\Equipment;
use Illuminate\Http\Request;
use App\Category;
use Auth;
use App\Hospital;
use DB;
use App\Department;
use App\Service_Vendor;
class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'Unit Head'){
            $equipment = Equipment::with('unit', 'category', 'unit.department')->where('hospital_id', '=', Auth::user()->hospital_id)->whereHas('unit', function($q){
                $q->where('user_id', Auth::user()->id);
            })->get();
        }else{
        $equipment = Equipment::where('hospital_id','=',Auth::user()->hospital_id)->with('category', 'unit', 'unit.department')->get();
        }
        return view('inventory')->with('equipment', $equipment);
        //return response()->json($equipment, 200);
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
        $validator = $request->validate([
            //'serial_number' => 'required|string',
            //'model_number' => 'required|string',
            //'manufacturer_name' => 'required|string',
            //'description' => 'required',
            //'location'    => 'required',
            //'year_of_purchase' => 'required',
            //'installation_time' => 'required',
            //'pos_rep_date' => 'required',
            //'equipment_cost' => 'required',
            'code'  => 'required',
            'category_id' => 'required',
            'user_id'     => 'required',
            'maintenance_frequency' => 'required',
            'unit_id' => 'required'
        ]);

        $equipment  = new Equipment();

        //$equipment->code = $request->code;
        /*$hospital = Hospital::findOrFail($request->hospital_id);

        $hospital_code = $this->generatePrefix($hospital->name, $request->hospital_id);
        $last_equipment = Equipment::where("hospital_id", "=", $hospital->id)->latest()->first();
        

        if($last_equipment == null){
            $code = 1;
        }else{
            $code = substr($last_equipment->code, -1, 13);
            $code = (int)$code + 1;
        }

        $code = sprintf("%010d", $code);*/

        $request->installation_time = $this->formatDate($request->installation_time);
        $request->pos_rep_date = $this->formatDate($request->pos_rep_date);
        
        $equipment->code = $request->code;   //$hospital_code."-".$code;
        $equipment->serial_number = $request->serial_number != null ?  $request->serial_number : 'N/A';
        $equipment->model_number = $request->model_number != null ? $request->model_number : 'N/A';
        $equipment->manufacturer_name  = $request->manufacturer_name != null ? $request->manufacturer_name : 'N/A';
        $equipment->description = $request->description != null ? $request->description : 'N/A';
        $equipment->category_id = $request->category_id;
        $equipment->status = $request->status;
        $equipment->hospital_id = $request->hospital_id;
        $equipment->user_id = $request->user_id;
        $equipment->maintenance_frequency = $request->maintenance_frequency;
        $equipment->unit_id = $request->unit_id;
        $equipment->location = $request->location != null ? $request->location : 'N/A';
        $equipment->year_of_purchase = $request->year_of_purchase != null ? $request->year_of_purchase : 'N/A';
        $equipment->installation_time = $request->installation_time;
        $equipment->pos_rep_date = $request->pos_rep_date;
        $equipment->equipment_cost = $request->equipment_cost;
        $equipment->service_vendor_id = $request->service_vendor_id;


        if($equipment->save()){
            $result = false;
        }

        return response()->json([
            'error' => $result,
            'data' => $equipment,
            'message' => !$result ? 'Equipment created successfully' : 'Error creating equipment'
          ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $equipment = Equipment::where('code', '=', $code)->with('unit', 'category', 'service_vendor')->first();
        return view('item')->with('equipment', $equipment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipment $equipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipment $equipment){
        $request->installation_time = $this->formatDate($request->installation_time);
        $request->pos_rep_date = $this->formatDate($request->pos_rep_date);

        $equipment->installation_time = $request->installation_time;
        $equipment->pos_rep_date = $request->pos_rep_date;
        $status = $equipment->update(
            $request->only(['code', 'serial_number', 'model_number', 'manufacturer_name', 'description', 'category_id', 'unit_id', 'status', 'location', 'year_of_purchase', 'equipment_cost', 'service_vendor_cost'])
        );

        return response()->json([
            'data' => $equipment,
            'message' => $status ? 'Equipment Updated' : 'Error updating equipment'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $equipment)
    {
        //
    }


    public function presentAddNewBlade(){
        $user_id = Auth::user()->id;
        $categories = Category::all();
        $vendors = Service_Vendor::where('hospital_id', '=', Auth::user()->hospital_id)->get();
        
        if(strtolower(Auth::user()->role) == 'admin' || strtolower(Auth::user()->role) == 'storekeeper' || strtolower(Auth::user()->role) == 'engineer'){
            $departments = Department::with('units')->where('hospital_id', '=', Auth::user()->hospital_id)->get();
            return view('add-item')->with('categories', $categories)->with('departments', $departments)->with('vendors', $vendors);
        }else if(Auth::user()->role == 'Unit Head'){
            $departments = Department::with(['units' => function($query) use ($user_id){
                $query->where('user_id', '=', $user_id);
           }])->get();
            return view('add-item')->with('categories', $categories)->with('departments', $departments)->with('vendors', $vendors);
        }else{
            return abort(403);
        }
    }

    public function editEquipment($code){
        $equipment = Equipment::where('code', '=', $code)->first();
        $categories = Category::all();
        $vendors = Service_Vendor::where('hospital_id', '=', Auth::user()->hospital_id)->get();
        $departments = Department::with('units')->where('hospital_id', '=', Auth::user()->hospital_id)->get();

        if(strtolower(Auth::user()->role) == 'admin' || strtolower(Auth::user()->role) == 'storekeeper' || strtolower(Auth::user()->role) == 'engineer' || strtolower(Auth::user()->role) == 'unit head'){
            return view('edit-item')->with('equipment', $equipment)->with('categories', $categories)->with('departments', $departments)->with('vendors', $vendors);
        }else{
            return abort(403);
        }
    }

    private function generatePrefix($hospital_name, $hospital_id){
            $words = explode(" ", $hospital_name);
            if(sizeof($words) < 1){
                $words = [$hospital_name];
            }
            
            $acronym = "";

            if(sizeof($words) < 2){
                $acronym = substr($hospital_name, 0, 2);
                
                return $acronym.$hospital_id;
            }

            foreach ($words as $w) {
                $acronym .= $w[0];
            }

            $acronym = $acronym.$hospital_id;

            return strtoupper($acronym);
    }

    public function fetchCummulativeReport(Request $request){
        $request->validate([
            'year' => 'required',
            'hospital_id' => 'required'
        ]);
        
        $year = $request->year;
        $hospital_id = $request->hospital_id;

        $report = DB::select("SELECT COUNT(equipment.code) as y, status as name from equipment where hospital_id = '$hospital_id' and YEAR(created_at) <= '$year' GROUP BY status");

        return response()->json([
            'response' => $report
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function fetchCategorizedReport(Request $request){
        $request->validate([
            'year' => 'required',
            'hospital_id' => 'required'
        ]);
        
        $year = $request->year;
        $hospital_id = $request->hospital_id;

        $report = DB::select("SELECT COUNT(equipment.code) as total, status, categories.name as category from equipment,categories where equipment.category_id = categories.id and equipment.hospital_id = '$hospital_id' and YEAR(equipment.created_at) <= '$year' GROUP BY status, category");

        return response()->json([
            'response' => $report
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function fetchUnitReport(Request $request){
        $request->validate([
            'year' => 'required',
            'hospital_id' => 'required'
        ]);
        
        $year = $request->year;
        $hospital_id = $request->hospital_id;

        $report = DB::select("SELECT CAST(COUNT(equipment.code) as UNSIGNED) as total, units.name as unit, categories.name as category from equipment, categories, units where equipment.category_id = categories.id and equipment.unit_id = units.id and equipment.hospital_id = '$hospital_id' and YEAR(equipment.created_at) <= '$year' GROUP BY unit, category");
        
        return response()->json([
            'response' => $report
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function fetchDepartmentReport(Request $request){
        $request->validate([
            'year' => 'required',
            'hospital_id' => 'required'
        ]);
        
        $year = $request->year;
        $hospital_id = $request->hospital_id;

        
        $report = DB::select("SELECT COUNT(equipment.code) as total, departments.name as department, categories.name as category from equipment, categories, units, departments where equipment.category_id = categories.id and equipment.unit_id = units.id and equipment.hospital_id = '$hospital_id' and YEAR(equipment.created_at) <= '$year' and units.department_id = departments.id GROUP BY department, category");
        return response()->json([
            'response' => $report
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    private function formatDate($date){
        return date("Y-m-d H:i:s", strtotime(stripslashes($date)));
    }
}
