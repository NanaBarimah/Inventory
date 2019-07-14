<?php

namespace App\Http\Controllers;
use DB;
use WorkOrder;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function index(){
        return view('reports');
    }


    public function workOrder(Request $request){
        switch($request->type){
            case "status":
                return $this->workOrderByStatus($request);
                break;
            default:
                break;
        }
    }

    public function workOrderByStatus(Request $request){
        $request->validate([
            "from" => "required",
            "to" => "required"
        ]);
        
        $from = date('Y-m-d', strtotime($request->from));
        $to = date('Y-m-d', strtotime($request->to));

        $result = WorkOrder::select("status", DB::raw("COUNT(id) as kount"))->whereDate("created_at", ">=", $from)->whereDate("created_at", "<=", $to)->groupBy("status")->get();
        return response()->json($result);
    }

    public function workOrderByDepartment(Request $request){
        $request->validate([
            "from" => "required",
            "to" => "required"
        ]);
        
        $from = date('Y-m-d', strtotime($request->from));
        $to = date('Y-m-d', strtotime($request->to));

        $result = WorkOrder::select("departement_id", DB::raw("COUNT(id) as kount"))->with("department")->whereDate("created_at", ">=", $from)->whereDate("created_at", "<=", $to)->groupBy("status")->get();
        return response()->json($result);
    }
}
