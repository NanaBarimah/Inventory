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
                        <span class="float-right">
                        @if($order->status == 2) 
                            <i class="fas fa-circle text-warning"></i> Pending 
                        @elseif($order->status == 1) 
                            <i class="fas fa-circle text-success"></i> Accepted 
                            @if($order->is_fulfilled == 1)
                                &nbsp;&nbsp;<i data-toggle="tooltip" title="Order fulfilled" class="fas fa-check-circle text-info"></i>
                            @endif 
                        @elseif($order->status == 0) <i class="fas fa-circle text-danger"></i> Denied 
                        @endif
                        </span>
                        <div class="dropdown" style="position:absolute; top: 0; right: 0;">
                            <button type="button"
                                class="btn btn-round btn-default dropdown-toggle btn-simple"
                                data-toggle="dropdown" style="border:none;">
                                Actions
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @if($user->role == 'Admin')
                                    <button class="dropdown-item" data-toggle="modal" data-target="#fulfill" <?php if($order->status != 1 || $order->is_fulfilled == 1){echo "disabled";} ?>>Fulfill</button>
                                @endif
                                <button class="dropdown-item" data-toggle="modal" data-target="#send" <?php if($order->status == 1){echo "disabled";} ?>>Send</button>
                            </div>
                        </div>
                    </div>
                    <form id="add_po">
                        <div class="card-body mt-4">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label><b>Title</b> <span class="text-danger">*</span></label>
                                        <input class="form-control" name="title" value="{{$order->title}}" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><b>Hospital Details: </b></label>
                                        <input class="form-control" value="{{$order->hospital_name}}" name="hospital_name" readonly/>
                                        <input class="form-control mt-1" value="{{$order->address}}" name="address"/>
                                        <input class="form-control mt-1" value="{{$order->contact_number}}" placeholder="Phone Number" name="contact_number"/>
                                        <input class="form-control mt-1" value="{{$order->contact_name}}" placeholder = "Contact person name" name="contact_name"/>
                                    </div>
                                </div>
                                <div class="col-md-8 text-right">
                                    <div class="form-group">
                                        <label><b>Service Vendor: </b></label><br/>
                                        <select class="selectpicker" data-style="form-control" title="Service Vendor"
                                        data-live-search="true" required name="service_vendor_id">
                                            @foreach($hospital->services as $vendor)
                                                <option value="{{$vendor->id}}" <?php if($order->service_vendor_id == $vendor->id){echo "selected";} ?>>{{$vendor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-5 pull-right">
                                        <label><b>Date Due: </b></label>
                                        <input class="form-control datepicker" value="{{date('m/d/Y', strtotime($order->due_date))}}" name="due_date"/>
                                    </div>
                                </div>
                            </div>
                            
                            @if($order->status != 1)<p class="text-right"><a href="javascript:void(0)" data-toggle="modal" data-target="#add-item">
                            <i class="fa fa-plus"></i> <b>Add order items</b></a></p>@endif
                            <table class="table table-bordered table-hover table-striped mt-4">
                                <thead>
                                    <tr>
                                        <th>Item name</th>
                                        <th>Unit cost</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        @if($order->status != 1)<th>Action</th>@endif
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                    @foreach($order->order_items as $key=>$item)
                                    <tr data-index="{{$key}}">
                                        <td>{{$item->part_name}}</td>
                                        <td>{{$item->unit_cost}}</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{$item->quantity * $item->unit_cost}}</td>
                                        @if($order->status != 1)
                                        <td><a href="javascript:void(0)" class="text-danger" onclick = "removeItem(this)">Remove Item</a></td>
                                        @endif
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
                                        <input class="form-control" value="{{$order->sales_tax}}" name="sales_tax" id="sales_tax"/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label><b>Shipping Cost</b></label>
                                        <input class="form-control" value="{{$order->shipping_cost}}" name="shipping_cost" id="sales_shipping"/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label><b>Other Costs</b></label>
                                        <input class="form-control" value="{{$order->other_cost}}" name="other_cost" id="sales_other"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label><b>Shipping Method</b></label>
                                        <input class="form-control" value="{{$order->shipping_method}}" name="shipping_method"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><b>Description</b></label>
                                        <textarea name="description" class="form-control">{{$order->description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><b>Extra Notes</b></label>
                                        <textarea name="notes" class="form-control">{{$order->notes}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><b>Terms</b></label>
                                        <textarea name="terms" class="form-control">{{$order->terms}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            @if($order->status != 1)
                            <div class="pull-right pb-4">
                                <button class="btn btn-purple" type="submit">Save</button>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="add-item" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method = "post" id="add_to_cart">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                        <ul class="nav nav-pills nav-pills-primary" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#old_item" role="tablist">Existing Part</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#new_item" role="tablist">New Part</a>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-body">
                        <div class="tab-content tab-space">
                            <div class="tab-pane active" id="old_item">
                                <select class="selectpicker col-md-12" data-style="btn btn-purple" 
                                name="part_id" id="part_id" title="Select Part" data-live-search="true" required>
                                    @foreach($hospital->parts as $part)
                                    <option value="{{$part->id}}" data-name="{{$part->name}}" data-cost="{{$part->cost}}">{{$part->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="tab-pane" id="new_item">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><b>Item Name</b></label>
                                        <input class="form-control" id="name" disabled required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Unit Cost</b> <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="unit_cost" required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Quantity</b> <span class="text-danger">*</span></label>
                                    <input type="number" step="1" class="form-control" id="quantity" required/>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer mt-4">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-purple text-right pull-right">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="send" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                    <h3>Send To Administrator</h3>
                </div>
                <form id="send_recipient">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><b>Select Recepient</b></label>
                                    <select class="selectpicker col-md-12" data-style="form-control" 
                                    name="user_id" id="user_id" title="Select User" data-live-search="true" required>
                                        @foreach($hospital->users as $hospital_user)
                                            <option value="{{$hospital_user->id}}">{{$hospital_user->firstname.' '.$hospital_user->lastname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><b>Extra Notes</b></label>
                                    <textarea class="form-control" name="notes"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-purple text-right pull-right">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="fulfill" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="fulfill_order">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                        <h4>Fulfill Purchase Order</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure this order has been fulfilled? This process cannot be undone. Be very sure you want to mark this purchase order as fulfilled before you proceed.</p>
                    </div>
                    <div class="modal-footer mt-4">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-purple text-right pull-right">Fulfill</button>
                        </div>
                    </div>
                </form>
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
        let temp_cart = {!! $order->order_items !!};
        let cart = [];
        
        for(let i = 0; i < temp_cart.length; i++){
            let temp = {
                unit_cost : temp_cart[i].unit_cost,
                quantity : temp_cart[i].quantity,
                part_id : temp_cart[i].part_id,
                name : temp_cart[i].part_name
            }

            cart.push(temp);
        }
        
        demo.initDateTimePicker();
        $("[data-toggle='tooltip']").tooltip();

        $("#add_to_cart").on("submit", function(e){
            e.preventDefault();
            let active_tab = $(".nav-pills-primary").find(".active");
            data = {
                unit_cost : $("#unit_cost").val(),
                quantity : $("#quantity").val()
            };
            if(active_tab.attr("href") == "#old_item"){
                data.part_id = $("#part_id").val();
                data.name = $("#part_id").find(":selected").data("name");
            }else{
                data.name = $("#name").val();
                data.part_id = null;
            }

            console.log(data);
            cart.push(data);

            const index = cart.length - 1;
            const total_cost = data.unit_cost * data.quantity;

            let temp = `<tr data-index="${index}">
                <td>${data.name}</td>
                <td>${data.unit_cost}</td>
                <td>${data.quantity}</td>
                <td>${total_cost}</td>
                <td><a href="javascript:void(0)" class="text-danger" onclick = "removeItem(this)">Remove Item</a></td>
            </tr>`

            let item_cost = +$("#items_cost").html() + total_cost;
            $("#items_cost").html(item_cost);

            let total = +$("#total_cost").html() + total_cost;
            $("#total_cost").html(total);

            $(this).trigger('reset');
            $("#part_id").val(null).selectpicker("refresh");

            $("#table_body").append(temp);
        });

        $("#part_id").on("change", function(){
            $("#unit_cost").val($("#part_id").find(":selected").data("cost"));
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href");
            if (target == '#new_item') {
                $('#new_item').find('input').prop('disabled', false);
                $('#old_item').find('select').prop('disabled', true);
            } else if(target == '#old_item'){
                $('#new_item').find('input').prop('disabled', true);
                $('#old_item').find('select').prop('disabled', false);
            }
        });

        let removeItem = (element) => {
            let i = +$(element).closest("tr").data("index");
            let temp = cart[i];

            cart = cart.slice(0, i).concat(cart.slice(i + 1, cart.length));

            $(element).closest("tr").remove();
            const total_cost = temp.unit_cost * temp.quantity;
            let item_cost = +$("#items_cost").html() - total_cost;
            $("#items_cost").html(item_cost);

            let total = +$("#total_cost").html() - total_cost;
            $("#total_cost").html(total);
        }

        $("#sales_tax").on("keyup", function(e){
            let value = 0;
            
            if(this.value == null || this.value == ''){
                value = 0;
            }else{
                value = +this.value;
            }

            let total = +$("#total_cost").html();
            let sales = +$("#taxes_cost").html();
            
            temp_total = +total - sales;
            total = +temp_total + value;

            $("#total_cost").html(total);
            $("#taxes_cost").html(value);
        });

        $("#sales_shipping").on("keyup", function(e){
            let value = 0;
            
            if(this.value == null || this.value == ''){
                value = 0;
            }else{
                value = +this.value;
            }

            let total = +$("#total_cost").html();
            let sales = +$("#shipping_cost").html();
            
            temp_total = total - sales;
            total = temp_total + value;

            $("#total_cost").html(total);
            $("#shipping_cost").html(value);
        });

        $("#sales_other").on("keyup", function(e){
            let value = 0;
            
            if(this.value == null || this.value == ''){
                value = 0;
            }else{
                value = +this.value;
            }

            let total = +$("#total_cost").html();
            let sales = +$("#other_cost").html();
            
            temp_total = +total - sales;
            total = +temp_total + value;

            $("#total_cost").html(total);
            $("#other_cost").html(value);
        });

        $("#add_po").on("submit", function(e){
            e.preventDefault();

            if(cart.length == 0){
                presentNotification("You need to add parts to the purchase order", "danger", "bottom", "right");
            }else{
                let data = new FormData(this);
                let item_cost = 0;

                for(i = 0; i < cart.length; i++){
                    item_cost += (cart[i].unit_cost * cart[i].quantity);
                }

                data.append("hospital_id", "{{$user->hospital_id}}");
                data.append("item_cost", item_cost);
                data.append("orderItems", JSON.stringify(cart));
                data.append("added_by", "{{$user->id}}");

                let btn = $(this).find('[type="submit"]');
                submit_file_form("/api/purchase-order/{{$order->id}}/update", "post", data, undefined, btn, false);
            }
        });

        $("#send_recipient").on("submit", function(e){
            e.preventDefault();
            let data = new FormData(this);

            let btn = $(this).find('[type="submit"]');
            submit_file_form("/api/purchase-order/{{$order->id}}/send", "post", data, undefined, btn, false);
        });

        $("#fulfill_order").on("submit", function(e){
            e.preventDefault();
            let data = new FormData(this);

            let btn = $(this).find('[type="submit"]');
            submit_file_form("/api/purchase-order/{{$order->id}}/fulfill", "post", data, undefined, btn, false);
        });
    </script>
@endsection