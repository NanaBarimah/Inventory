@extends('layouts.user-dashboard', ['page_title' => 'Create Purchase Order'])
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
                                        GHS <span id="items_cost">0</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Taxes 
                                    </td>
                                    <td class="text-right">
                                        GHS <span id="taxes_cost">0</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Shipping Cost 
                                    </td>
                                    <td class="text-right">
                                        GHS <span id="shipping_cost">0</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Other Costs
                                    </td>
                                    <td class="text-right">
                                        GHS <span id="other_cost">0</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Total</b>
                                    </td>
                                    <td class="text-right">
                                        <b>GHS <span id="total_cost">0</span></b>
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
                        <h5 class="title pb-2">New Purchase Order</h5>
                        <strong>{{date('jS F Y')}}</strong> 
                        <span class="float-right"> <strong>Status: </strong> Pending</span>
                    </div>
                    <form id="add_po">
                        <div class="card-body mt-4">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label><b>Title</b> <span class="text-danger">*</span></label>
                                        <input class="form-control" name="title" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><b>Hospital Details: </b></label>
                                        <input class="form-control" value="{{$hospital->name}}" name="hospital_name" readonly/>
                                        <input class="form-control mt-1" value="{{$hospital->address}}" name="address"/>
                                        <input class="form-control mt-1" value="{{$hospital->phone_number}}" placeholder="Phone Number" name="contact_number"/>
                                        <input class="form-control mt-1" placeholder = "Contact person name" name="contact_person_name"/>
                                    </div>
                                </div>
                                <div class="col-md-8 text-right">
                                    <div class="form-group">
                                        <label><b>Service Vendor: </b></label><br/>
                                        <select class="selectpicker" data-style="form-control" title="Service Vendor"
                                        data-live-search="true" required name="service_vendor_id">
                                            @foreach($hospital->services as $vendor)
                                                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-5 pull-right">
                                        <label><b>Date Due: </b></label>
                                        <input class="form-control datepicker" name="due_date"/>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-right"><a href="javascript:void(0)" data-toggle="modal" data-target="#add-item">
                            <i class="fa fa-plus"></i> <b>Add order items</b></a></p>
                            <table class="table table-bordered table-hover table-striped mt-4">
                                <thead>
                                    <tr>
                                        <th>Item name</th>
                                        <th>Unit cost</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                
                                </tbody>
                            </table>
                            <div class="row mt-4">
                                <div class="col-md-12 col-sm-12">
                                    <h6><b>Cost and Details</b></h6>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label><b>Taxes</b></label>
                                        <input class="form-control" name="sales_tax" id="sales_tax"/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label><b>Shipping Cost</b></label>
                                        <input class="form-control" name="shipping_cost" id="sales_shipping"/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label><b>Other Costs</b></label>
                                        <input class="form-control" name="other_cost" id="sales_other"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label><b>Shipping Method</b></label>
                                        <input class="form-control" name="shipping_method"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><b>Description</b></label>
                                        <textarea name="description" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><b>Extra Notes</b></label>
                                        <textarea name="notes" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><b>Terms</b></label>
                                        <textarea name="terms" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="pull-right pb-4">
                                <button class="btn btn-purple" type="submit">Save</button>
                            </div>
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
@endsection
@section('scripts')
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
    <script>
        let cart = [];
        demo.initDateTimePicker();

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
                data.append("hospital_id", "{{Auth::user()->hospital_id}}");
                data.append("item_cost", item_cost);
                data.append("orderItems", JSON.stringify(cart));
                data.append("added_by", "{{Auth::user()->id}}");

                let btn = $(this).find('[type="submit"]');
                
                //console.log(data);
                submit_file_form("/api/purchase-order/add", "post", data, undefined, btn, true);
            }
        })
    </script>
@endsection