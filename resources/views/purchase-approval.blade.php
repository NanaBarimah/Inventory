@extends('layouts.user-dashboard', ['page_title' => $order->title])
@section('styles')
<style>
.absolute{
    position: absolute;
}
</style>
@endsection
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="heading">Total</h4>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        Items Cost
                                    </td>
                                    <td class="text-right">
                                        $<span id="items_cost">{{$order->item_cost != null ? $order->item_cost : 0}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Taxes 
                                    </td>
                                    <td class="text-right">
                                        $<span id="taxes_cost">{{$order->sales_tax != null ? $order->sales_tax : 0}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Shipping Cost 
                                    </td>
                                    <td class="text-right">
                                        $<span id="shipping_cost">{{$order->shipping_cost != null ? $order->shipping_cost : 0}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Other Costs
                                    </td>
                                    <td class="text-right">
                                        $<span id="other_cost">{{$order->other_cost != null ? $order->other_cost : 0}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Total</b>
                                    </td>
                                    <td class="text-right">
                                        <b>$<span id="total_cost">{{$order->item_cost + $order->shipping_cost + $order->other_cost + $order->sales_tax != null ? $order->item_cost + $order->shipping_cost + $order->other_cost + $order->sales_tax : 0}}</span></b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title pb-2">{{$order->title}}</h5>
                        <strong>{{date('jS F Y', strtotime($order->created_at))}}</strong> 
                        <span class="float-right">@if($order->status == 2) <i class="fas fa-circle text-warning"></i> Pending @elseif($order->status == 1) <i class="fas fa-circle text-success"></i> Accepted @elseif($order->status == 0) <i class="fas fa-circle text-danger"></i> Denied @endif</span>
                        <div class="dropdown" style="position:absolute; top: 0; right: 0;">
                            <button type="button"
                                class="btn btn-round btn-default dropdown-toggle btn-simple"
                                data-toggle="dropdown" style="border:none;">
                                Actions
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" onclick="accept()" <?php if($order->status == 1){echo "disabled";} ?>>Approve</button>
                                <button class="dropdown-item" onclick="decline()" <?php if($order->status == 0){echo "disabled";} ?>>Decline</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body mt-4">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label><b>Title</b> <span class="text-danger">*</span></label>
                                    <p>{{$order->title}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Hospital Details: </b></label>
                                    <p>{{$order->hospital_name}}<br/>{{$order->address}}<br/>{{$order->contact_number}}<br/>{{$order->contact_name}}</p>
                                </div>
                            </div>
                            <div class="col-md-8 text-right">
                                <div class="form-group">
                                    <label><b>Service Vendor: </b></label><br/>
                                    <p>{{$order->service_vendor->name}}</p>
                                </div>
                                <div class="form-group col-md-5 pull-right">
                                    <label><b>Date Due: </b></label>
                                    <p>{{date('js F, Y', strtotime($order->due_date))}}</p>
                                </div>
                            </div>
                        </div>
                    
                        <table class="table table-bordered table-hover table-striped mt-4">
                            <thead>
                                <tr>
                                    <th>Item name</th>
                                    <th>Unit cost</th>
                                    <th>Quantity</th>
                                    <th class="text-right">Total ($)</th>
                                </tr>
                            </thead>
                            <tbody id="table_body">
                                @foreach($order->order_items as $key=>$item)
                                <tr data-index="{{$key}}">
                                    <td>{{$item->part_name}}</td>
                                    <td>{{$item->unit_cost}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td class="text-right">{{$item->quantity * $item->unit_cost}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row mt-4">
                            <div class="col-md-12 col-sm-12">
                                <h6><b>Cost and Details</b></h6>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label><b>Taxes</b></label>
                                    <p>{{$order->sales_tax != null ? '$'.$order->sales_tax : 'N/A'}}</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label><b>Shipping Cost</b></label>
                                    <p>{{$order->shipping_cost != null ? '$'.$order->shipping_cost : 'N/A'}}</p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label><b>Other Costs</b></label>
                                    <p>{{$order->other_cost != null ? '$'.$order->other_cost : 'N/A'}}</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Shipping Method</b></label>
                                    <p>{{$order->shipping_method != null ? $order->shipping_method : 'N/A'}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Description</b></label>
                                    <p>{{$order->description != null ? $order->description : 'N/A'}}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Extra Notes</b></label>
                                    <p>{{$order->notes != null ? $order->notes : 'N/A'}}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Terms</b></label>
                                    <p>{{$order->terms != null ? $order->terms : 'N/A'}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="approve" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer mt-4">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-purple text-right pull-right">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
    <script>
        const accept = (element) => {
            let btn = $(element);
            submit_form("/api/purchase-order/{{$order->id}}/approve", "post", null, undefined, btn, true);
        }

        const decline = (element) => {
            let btn = $(element);
            submit_form("/api/purchase-order/{{$order->id}}/decline", "post", null, undefined, btn, true);
        }
    </script>
@endsection