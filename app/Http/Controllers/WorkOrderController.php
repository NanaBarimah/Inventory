<?php

namespace App\Http\Controllers;

use App\User;
use App\WorkOrder;
use Illuminate\Http\Request;

use Auth;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $work_orders = WorkOrder::where("hospital_id", Auth::user()->hospital_id)->with("priority", "user", "asset")->get();
        return view("work-orders", compact("work_orders"));
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
    public function store(Request $request, WorkOrder $work_order)
    {
        $request->vaildate([
            'id'          => 'required',
            'title'       => 'required',
            'wo_number'   => 'required',
            'hospital_id' => 'required'
        ]);

        $workOrder = new WorkOrder();

        $workOrder->id                  = md5($request->title.microtime());
        $workOrder->title               = $request->title;
        $workOrder->description         = $request->description;
        $workOrder->due_date            = date('Y-m-d', strtotime($request->due_date)); 
        $workOrder->estimated_durartion = $request->estimated_duration; 
        $workOrder->priority_id         = $request->priority_id;
        $workOrder->hospital_id         = $request->hospital_id;
        $workOrder->fault_category_id   = $request->fault_category_id;
        $workOrder->assigned_to         = $request->assigned_to;
        $workOrder->admin_id            = $request->admin_id;
        $workOrder->department_id       = $request->department_id;
        $workOrder->unit_id             = $request->unit_id;
        $workOrder->service_vendor_id   = $request->service_vendor_id;
        $workOrder->request_id          = $request->request_id;

        $last_wo_number = WorkOrder::where('hospital_id', Auth::user()->hospital_id)->latest()->get();
        if($last_wo_number == null) {
            $workOrder->wo_number = 1;
        } else {
            $workOrder->wo_number = $last_wo_number->wo_number + 1;
        }

        if($request->image != null) {
            $request->validate([
                'image' => 'required|mime:png,jpg,jpeg'
            ]);

            $file = $request->file('image');
            $name = md5($file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
            $file->move(public_path().'/img/assets/work_orders', $name);

            $workOrder->image = $name;
        }

        if($request->hasFile('fileName')) {
            $request->validate([
                'fileName' => 'required|mime:doc,pdf,docx,zip'
            ]);

            $file = $request->file('fileName');
            $name = time().'-'.md5($file->getClientOriginalName());
            $file->move('files/work_orders', $name);

            $workOrder->fileName = $name;
        }

        $user = User::where("role", "Regular Technician")->orWhere("role", "Limited Technician")->get();

        if($user) {
            $work_order->pending();
        } else {
            $work_order->open();
        }

        if($workOrder->save()) {
            if($request->additionalWorkers != null) {
                $workOrder->teams()->attach($request->additionalWorkers);
            }

            return response()->json([
                'error'      => false,
                'work_order' => $workOrder,
                'message'    => 'New work order created successfully!'
            ]);
        }

        return response()->json([
            'error'   => true,
            'message' => 'Could not create a new work order. Try Again!'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WorkOrder  $workOrder
     * @return \Illuminate\Http\Response
     */
    public function show($workOrder)
    {
        //
        $work_order = WorkOrder::with("user", "users", "priority", "asset" )->where("id", $workOrder)->first();
        return view("work-order-details", compact("work_order"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WorkOrder  $workOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkOrder $workOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WorkOrder  $workOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkOrder $workOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WorkOrder  $workOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkOrder $workOrder)
    {
        //
    }

    public function on_hold(WorkOrder $workOrder)
    {
        $workOrder->on_hold();

        if($workOrder->save()){
            $users = User::where([['role', 'Admin'], ['hospital_id', $workOrder->hospital_id]])->get();
            Notification::send($users, new WorkOrderStatus($workOrder));

            return response()->json([
                'error' => false,
                'message' => 'Work Order is on hold'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Error changing the status of work order. Try again!'
        ]);
    }

    public function in_progress(WorkOrder $workOrder)
    {
        $workOrder->in_progress();

        if($workOrder->save()){
            $users = User::where([['role', 'Admin'], ['hospital_id', $workOrder->hospital_id]])->get();
            Notification::send($users, new WorkOrderStatus($workOrder));

            return response()->json([
                'error' => false,
                'message' => 'Work Order is in progress'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Error changing the status of work order. Try again!'
        ]);
    }

    public function complete(WorkOrder $workOrder)
    {
        $workOrder->complete();

        if($workOrder->save()){

            $users = User::where([['role', 'Admin'], ['hospital_id', $workOrder->hospital_id]])->get();
            Notification::send($users, new WorkOrderStatus($workOrder));

            return response()->json([
                'error' => false,
                'message' => 'Work Order completed'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Error changing the status of work order. Try again!'
        ]);
    }
}
