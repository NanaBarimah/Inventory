<?php

namespace App\Http\Controllers;
use DB;
use App\WorkOrder;
use Carbon\CarbonPeriod;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function index(){    
        return view('reports');
    }

    public function workOrderIndex(){
        $work_orders = WorkOrder::select("status", DB::raw("COUNT(id) as kount"))->groupBy("status")->get();
        
        $labels = ["Pending", "Open", "In progress", "On hold", "Closed"];
        $data = [0, 0, 0, 0, 0];

        foreach($work_orders as $work_order){
            switch($work_order->status){
                case 5:
                    $data[0] = $work_order->kount;
                    break;
                case 4:
                    $data[1] = $work_order->kount;
                    break;
                case 3:
                    $data[2] = $work_order->kount;
                    break;
                case 2:
                    $data[3] = $work_order->kount;
                    break;
                case 1:
                    $data[4] = $work_order->kount;
                    break;
                default: 
                    break;
            }
        }

        $datasets = array(array("name" => "Work orders", "data" => $data));

        return response()->json([
            "labels" => $labels,
            "datasets" => $datasets
        ]);
    }

    public function workOrderByStatus(Request $request){
        $request->validate([
            "from" => "required",
            "to" => "required",
            "type" => "required"
        ]);

        if($request->type == "cost"){
            $quantifier = "SUM(cost) as cost";
        }else{
            $quantifier = "COUNT(id) as kount";
        }
        
        $from = date('Y-m-d', strtotime($request->from));
        $to = date('Y-m-d', strtotime($request->to));
        
        
        
        if($request->interval == null){
           $statuses = ["Closed", "On hold", "In progress", "Open", "Pending"];
           $results = WorkOrder::select("status", DB::raw($quantifier))->whereDate("created_at", ">=", $from)->whereDate("created_at", "<=", $to)->groupBy("status")->get();
           $data = [0,0,0,0,0]; 
           
           foreach($results as $result){
                switch($result->status){
                    case 5:
                        $data[4] = $result->kount != null ? $result->kount : $result->cost;
                        break;
                    case 4:
                        $data[3] = $result->kount != null ? $result->kount : $result->cost;
                        break;
                    case 3:
                        $data[2] = $result->kount != null ? $result->kount : $result->cost;
                        break;
                    case 2:
                        $data[1] = $result->kount != null ? $result->kount : $result->cost;
                        break;
                    case 1:
                        $data[0] = $result->kount != null ? $result->kount : $result->cost;
                        break;
                    default: 
                        break;
                }
            }

            return response()->json([
                "labels" => $statuses,
                "datasets" => array(array("name" => "Work orders", "data" => $data))
            ]);

        }else if($request->interval == "month"){
            $results = WorkOrder::select("status", DB::raw($quantifier.', DATE_FORMAT(created_at, "%M %Y") as month'))
            ->whereDate("created_at", ">=", $from)->whereDate("created_at", "<=", $to)->groupBy("status", "month")->get();
            
            $labels = $this->monthsBetween($from, $to);
            $open = $pending = $in_progress = $on_hold = $closed = array();

            foreach($labels as $label){
                $found = false;
                foreach($results as $result){
                    if($result->month == $label){
                        switch($result->status){
                            case 5:
                                $pending[] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 4:
                                $open[] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 3:
                                $in_progress[] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 2:
                                $on_hold[] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 1:
                                $closed[] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            default: 
                                break;
                        }
                        $found = true;
                    }
                }
                
                if(!$found){
                    $open[] = $pending[] = $in_progress[] = $on_hold[] = $closed[] = 0;
                }
            }

            return response()->json([
                "labels" => $labels,
                "datasets" => array(
                    array("name" => "Closed" , "data" => $closed),
                    array("name" => "On hold" , "data" => $on_hold),
                    array("name" => "In progress" , "data" => $in_progress),
                    array("name" => "Open" , "data" => $open),
                    array("name" => "Pending" , "data" => $pending)
                )
            ]);
            
        }else if($request->interval == "year"){
            $results = WorkOrder::select("status", DB::raw($quantifier.', DATE_FORMAT(created_at, "%Y") as year'))
            ->whereDate("created_at", ">=", $from)->whereDate("created_at", "<=", $to)->groupBy("status", "year")->get();
            
            $labels = $this->yearsBetween($from, $to);
            $open = $pending = $in_progress = $on_hold = $closed = array();

            foreach($labels as $label){
                $found = false;
                foreach($results as $result){
                    if($result->year == $label){
                        switch($result->status){
                            case 5:
                                $pending[] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 4:
                                $open[] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 3:
                                $in_progress[] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 2:
                                $on_hold[] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 1:
                                $closed[] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            default: 
                                break;
                        }
                        $found = true;
                    }
                }
                
                if(!$found){
                    $open[] = $pending[] = $in_progress[] = $on_hold[] = $closed[] = 0;
                }
            }

            return response()->json([
                "labels" => $labels,
                "datasets" => array(
                    array("name" => "Closed" , "data" => $closed),
                    array("name" => "On hold" , "data" => $on_hold),
                    array("name" => "In progress" , "data" => $in_progress),
                    array("name" => "Open" , "data" => $open),
                    array("name" => "Pending" , "data" => $pending)
                )
            ]);
        }else if($request->interval == "quarter"){
            $results = WorkOrder::select("status", DB::raw($quantifier.', DATE_FORMAT(created_at, "%Y") as year, QUARTER(created_at) as quarter'))
            ->whereDate("created_at", ">=", $from)->whereDate("created_at", "<=", $to)->groupBy("status", "quarter", "year")->get();

            $labels = array();

            foreach($results as $result){
                $labels[] = $result->year.' Qrtr'.$result->quarter;
            }

            $labels = array_unique($labels);
            return response()->json([$labels, $results]);
        }
        
    }

    /*
    public function workOrderByDepartment(Request $request){
        $request->validate([
            "from" => "required",
            "to" => "required"
        ]);
        
        $from = date('Y-m-d', strtotime($request->from));
        $to = date('Y-m-d', strtotime($request->to));

        $result = WorkOrder::select("departement_id", DB::raw("COUNT(id) as kount"))->with("department")->whereDate("created_at", ">=", $from)->whereDate("created_at", "<=", $to)->groupBy("department_id")->get();
        return response()->json($result);
    }

    public function workOrderByDate(Request $request){
        $request->validate([
            "from" => "required",
            "to" => "required"
        ]);
        
        $from = date('Y-m-d', strtotime($request->from));
        $to = date('Y-m-d', strtotime($request->to));

        $result = WorkOrder::select(DB::raw("DATE_FORMAT(created_at, '%M %Y') as month_year"), DB::raw("COUNT(id) as kount"))->whereDate("created_at", ">=", $from)->whereDate("created_at", "<=", $to)->groupBy("month_year")->get();
        return response()->json($result);
    }

    public function workOrderByCost(Request $request){
        $request->validate([
            "from" => "required",
            "to" => "required"
        ]);
        
        $from = date('Y-m-d', strtotime($request->from));
        $to = date('Y-m-d', strtotime($request->to));

        $result = WorkOrder::select(DB::raw("DATE_FORMAT(created_at, '%M %Y') as month_year"), DB::raw("SUM(total_cost) as total"))->whereDate("created_at", ">=", $from)->whereDate("created_at", "<=", $to)->groupBy("month_year")->get();
        return response()->json($result);
    }

    public function workOrderByUnit(Request $request){
        $request->validate([
            "from" => "required", 
            "to" => "required"
        ]);

        $from = date('Y-m-d', strtotime($request->from));
        $to = date('Y-m-d', strtotime($request->to));

        $result = WorkOrder::select("unit_id", DB::raw("COUNT(id) as kount"))->with("unit")->whereDate("created_at", ">=", $from)->whereDate("created_at", "<=", $to)->groupBy("unit_id")->get();
        return response()->json($result);
    }

    public function workOrderByAssetCategory(Request $request){
        $request->validate([
            "from" => "required", 
            "to" => "required"
        ]);

        $from = date('Y-m-d', strtotime($request->from));
        $to = date('Y-m-d', strtotime($request->to));

        $result = WorkOrder::select(DB::raw("asset_categories.name as category_name"), DB::raw("COUNT(id) as kount"))
        ->with("asset", "asset.asset_category")->whereDate("created_at", ">=", $from)
        ->whereDate("created_at", "<=", $to)->groupBy("category_name")->get();
        return response()->json($result);
    }*/
    private function monthsBetween($start, $end){
        $months = array();

        foreach (CarbonPeriod::create($start, '1 month', $end) as $month) {
            $months[] = $month->format('F Y');
        }
        return $months;
    }

    private function yearsBetween($start, $end){
        $years = array();

        foreach (CarbonPeriod::create($start, '1 year', $end) as $year) {
            $years[] = $year->format('Y');
        }
        return $years;
    }
}

