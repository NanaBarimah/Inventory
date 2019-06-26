@extends('layouts.user-dashboard', ['page_title' => 'Purchase Orders'])
@section('content')
<div class="content">
    <div class="row">
    <div class="col-md-12 center">
            <div class="card">
                <div class="card-header">
                    <h4 class="inline-block">Purchase Orders</h4>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Order #</th>
                                <th>Item Count</th>
                                <th>Total Cost</th>
                                <th>Requester</th>
                                <th>Vendor</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Title</th>
                                <th>Order #</th>
                                <th>Item Count</th>
                                <th>Total Cost</th>
                                <th>Requester</th>
                                <th>Vendor</th>
                                <th>Created At</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td><b><a href="/purchase-order/{{$order->id}}">{{$order->title}}</a></b></td>
                                <td>{{$order->PO_number}}</td>
                                <td>{{$order->order_items->count()}}</td>
                                <td>GHS {{$order->item_cost + $order->sales_tax + $order->shipping_cost + $order->other_cost}}</td>
                                <td>{{$order->user->firstname.' '.$order->user->lastname}}</td>
                                <td>{{$order->service_vendor->name}}</td>
                                <td>{{date('jS F Y', strtotime($order->created_at))}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="/purchase-orders/add">
    <div class="fab">
        <i class="fas fa-plus"></i>
    </div>
</a>
@endsection
@section('scripts')
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jasny-bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            let orders = generateDtbl("#datatable", "No purchase order requests made yet", "Search orders");
        })
    </script>
@endsection