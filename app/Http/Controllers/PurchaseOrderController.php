<?php

namespace App\Http\Controllers;

use App\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
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
        $request->validate([
            'title'             => 'required',
            'due_date'          => 'required',
            'service_vendor_id' => 'required',
            'added_by'          => 'required',
            'item_cost'         => 'required',
            'hospital_id'       => 'required',
        ]);

        $purchaseOrder = new PurchaseOrder();
        
        $purchaseOrder->id                = md5($request->title.microtime());
        $purchaseOrder->service_vendor_id = $request->service_vendor_id;
        $purchaseOrder->added_by          = $request->added_by;
        $purchaseOrder->due_date          = $request->due_date;
        $purchaseOrder->item_cost         = $request->item_cost;
        $purchaseOrder->sales_tax         = $request->sales_tax;
        $purchaseOrder->shipping_cost     = $request->shipping_cost;
        $purchaseOrder->other_cost        = $request->other_cost;
        $purchaseOrder->description       = $request->description;
        $purchaseOrder->shipping_method   = $request->shipping_method;
        $purchaseOrder->terms             = $request->terms;
        $purchaseOrder->notes             = $request->notes;
        $purchaseOrder->hospital_id       = $request->hospital_id;
        $purchaseOrder->hospital_name     = $request->hospital_name;
        $purchaseOrder->address           = $request->address;
        $purchaseOrder->contact_number    = $request->contact_number;
        $purchaseOrder->contact_name      = $request->contact_name;
 
        $last_PO_number = PurchaseOrder::where('hospital_id', Auth::user()->id)->latest()->first();

        if($last_PO_number == null) {
            $purchaseOrder->PO_number = 1;
        } else {
            $purchaseOrder->PO_number = $last_PO_number->PO_number + 1;
        }

        if(User::where([['id', $request->added_by], ['role', 'Admin']])->first() != null) {
            $purchaseOrder->approve();
        } else {
            $purchaseOrder->status = 2;
        }

        if($purchaseOrder->save()) {
            if($request->orderitems != null) {
                $orderItems = array();
                foreach($request->orderitems as $item){
                    $orderItem = new OrderItem();
                    $orderItem->purchase_order_id = $purchaseOrder->id;
                    $orderItem->part_id = $item['part_id'];
                    $orderItem->quantity = $item['quantity'];
                    $orderItem->unit_cost = $item['unit_cost'];
                    $orderItem->part_name = $item['part_name'];

                    array_push($orderItems, $orderItem);
                }

                OrderItem::insert($orderItems);
            }
            return response()->json([
                'error'   => false,
                'data'    => $purchaseOrder,
                'message' => 'Purchase order saved successfully!'
            ]);
        } else {
            return response()->json([
                'error'   => true,
                'message' => 'Could not save purchase order. Try Again!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }

    public function approve(PurchaseOrder $purchaseOrder) 
    {
        $purchaseOrder->approve();
        
        if($purchaseOrder->save()){
            return response()->json([
                'error' => false,
                'message' => "Purchase order approved"
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => "Could not approve purchase order, try again!"
        ]);
    }

    public function fulfill(Request $request)
    {
        $purchaseOrder = PurchaseOrder::with("order_items")->where('id', $request->id)->first();

        $purchaseOrder->is_fulfilled = 1;

        if($purchaseOrder->save()){
            foreach($purchaseOrder->order_items as $item){
                if($item->part_id == null){
                    $part = new Part();
                    $part->name = $item->name;
                    $part->id = md5($part->name.microtime());
                    $part->quantity = $item->quantity;
                    $part->min_quantity = 0;
                    $part->hospital_id = $purchaseOrder->hospital_id;
                }else{
                    $part = Part::where('id', $item->part_id)->first();
                    $part->quantity += $item->quantity;
                }

                $part->save();
            }
        }

    }

    public function decline(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->decline();

        if($purchaseOrder->save()) {
            return response()->json([
                'error'   => false,
                'message' => 'Purchase order declined'
            ]);
        }

        return response()->json([
            'error'   => true,
            'message' => 'Could not decline purchase order, try again!'
        ]);
    }
}
