<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use App\WorkOrder;
use Carbon\CarbonPeriod;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function index(){ 
        $user = Auth::user();
        if($user->role == 'Admin' || $user->role == 'Regular Technician' || $user->role == 'Hospital Head') {
            return view('reports', compact("user"));
        } else {
            abort(403);
        }
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
            "type" => "required"
        ]);

        if($request->type == "cost"){
            $quantifier = "SUM(cost) as cost";
        }else{
            $quantifier = "COUNT(id) as kount";
        }
        
        
        if($request->interval == null){
           $statuses = ["Closed", "On hold", "In progress", "Open", "Pending"];
           $results = WorkOrder::select("status", DB::raw($quantifier))->groupBy("status")->get();
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
                "datasets" => array(array("name" => "Work orders", "data" => $data)),
                "timespan" => "all time",
                "type" => ""
            ]);

        }else if($request->interval == "month"){
            $request->validate([
                "date" => "required"
            ]);

            $results = WorkOrder::select("status", DB::raw($quantifier.', DATE_FORMAT(created_at, "%M") as month'))
            ->whereYear("created_at", "=", $request->date)->groupBy("status", "month")->get();
            
            $labels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            $open = $pending = $in_progress = $on_hold = $closed = array();

            foreach($labels as $key => $label){
                $open[$key] = $pending[$key] = $in_progress[$key] = $on_hold[$key] = $closed[$key] = 0;
                foreach($results as $result){
                    if($result->month == $label){
                        switch($result->status){
                            case 5:
                                $pending[$key] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 4:
                                $open[$key] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 3:
                                $in_progress[$key] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 2:
                                $on_hold[$key] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 1:
                                $closed[$key] = $result->kount != null ? $result->kount : $result->cost;
                            default: 
                                break;
                        }
                    }
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
                ),
                "timespan" => $request->date,
                "type" => "Monthly"
            ]);
            
        }else if($request->interval == "year"){
            
            $from = date('Y-m-d', strtotime($request->from));
            $to = date('Y-m-d', strtotime($request->to));
            
            
            $results = WorkOrder::select("status", DB::raw($quantifier.', DATE_FORMAT(created_at, "%Y") as year'))
            ->whereDate("created_at", ">=", $from)->whereDate("created_at", "<=", $to)->groupBy("status", "year")->get();
            
            $labels = $this->yearsBetween($from, $to);
            $open = $pending = $in_progress = $on_hold = $closed = array();

            foreach($labels as $key => $label){
                $open[$key] = $pending[$key] = $in_progress[$key] = $on_hold[$key] = $closed[$key] = 0;
                foreach($results as $result){
                    if($result->year == $label){
                        switch($result->status){
                            case 5:
                                $pending[$key] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 4:
                                $open[$key] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 3:
                                $in_progress[$key] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 2:
                                $on_hold[$key] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 1:
                                $closed[$key] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            default: 
                                break;
                        }
                    }
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
                ),
                "timespan" => $from.' to '.$to,
                "type" => "Yearly"
            ]);
        }else if($request->interval == "quarter"){
            $results = WorkOrder::select("status", DB::raw($quantifier.', QUARTER(created_at) as quarter'))
            ->whereYear("created_at", "=", $request->date)->groupBy("status", "quarter")->get();

            $labels = ["January - March ".$request->date, "April - June ".$request->date, "July - September ".$request->date, "October - December ".$request->date];
            $comparator = [1, 2, 3, 4];

            $open = $pending = $in_progress = $on_hold = $closed = [0,0,0,0];
            
            foreach($comparator as $key => $label){
                foreach($results as $result){
                    if($result->quarter == $label){
                        switch($result->status){
                            case 5:
                                $pending[$key] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 4:
                                $open[$key] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 3:
                                $in_progress[$key] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 2:
                                $on_hold[$key] = $result->kount != null ? $result->kount : $result->cost;
                                break;
                            case 1:
                                $closed[$key] = $result->kount != null ? $result->kount : $result->cost;
                            default: 
                                break;
                        }
                    }
                }
            }

            $labels = array_unique($labels);
            return response()->json([
                "labels" => $labels,
                "datasets" => array(
                    array("name" => "Closed" , "data" => $closed),
                    array("name" => "On hold" , "data" => $on_hold),
                    array("name" => "In progress" , "data" => $in_progress),
                    array("name" => "Open" , "data" => $open),
                    array("name" => "Pending" , "data" => $pending)
                ),
                "timespan" => $request->date,
                "type" => "Quarterly"
            ]);
        }else if($request->interval == "daily"){
            $request->validate([
                "date" => "required"
            ]);
            $date = $request->date;
            $daysInMonth = Carbon::parse($date)->daysInMonth;

            $results = WorkOrder::select("status", DB::raw($quantifier.', DAY(created_at) as day'))
            ->whereRaw(DB::raw("DATE_FORMAT(created_at, '%M %Y') = '$date'"))->groupBy("status", "day")->get();

            return response()->json($results);
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

    public function getMonths(){
        $months = WorkOrder::select(DB::raw("DISTINCT(DATE_FORMAT(created_at, '%M %Y')) as month"))->get();
        return response()->json($months);
    }

    public function getYears(){
        $years = WorkOrder::select(DB::raw("DISTINCT(YEAR(created_at)) as year"))->get();
        return response()->json($years);
    }
}

