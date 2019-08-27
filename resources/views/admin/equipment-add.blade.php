<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Inventory Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <!--link href="{{ asset('css/app.css') }}" rel="stylesheet"-->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/now-ui-dashboard.min.css?v=1.2.0')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/main.css')}}" />
</head>

<body>
    <div class="wrapper ">
        @include('layouts.admin_sidebar')
        <div class="main-panel">
            @include('layouts.admin_navbar', ['page_title' => 'Add Equipment'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="col-md-12 mr-auto ml-auto">
                    <div>
                        <div class="card">
                            <form action="#" method="POST" id="add_new_item">
                                <div class="card-header text-center">
                                    <h3 class="card-title">
                                        Add New Equipment
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <div class="row justify-content-center">
                                            <div class="col-sm-11">
                                                <div class="row">
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label><b>Device Name</b> <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control resetable" name="name" required="true"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label><b>Equipment Code</b> <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control resetable" name="equipment_code" required="true"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label><b>Type</b> <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <select class="col-md-12 selectpicker" data-style="form-control" data-show-tick="true"
                                                            name="type" title="Type" required>
                                                                <option>Equipment</option>
                                                                <option>Spare Part</option>
                                                            </select>
                                                        </div>
                                                        <p class="refresh-picker pr-4 text-right">Reset</p>
                                                    </div>
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label><b>Category</b> <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <select class="col-md-12 selectpicker" data-style="form-control" data-show-tick="true"
                                                            name="admin_category_id" data-live-search="true" title="Category" required>
                                                                @foreach($categories as $category)
                                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <p class="refresh-picker pr-4 text-right">Reset</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-11 mt-2">
                                                <div class="row">
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label><b>Serial Number</b></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control resetable" name="serial_number"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label><b>Model Number</b></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control resetable" name="model_number"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label><b>Manufacturer Name</b></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control resetable" name="manufacturer_name"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label><b>Warranty Expiration</b></label>
                                                        <div class="input-group">
                                                            <input type="text" class="datepicker form-control resetable" name="warranty_expiration"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-11 mt-2">
                                                <div class="row">
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label><b>Status</b> <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <select class="col-md-12 selectpicker" data-style="form-control" data-show-tick="true"
                                                            name="status" title="Status" required>
                                                                <option>Good</option>
                                                                <option>Bad</option>
                                                            </select>
                                                        </div>
                                                        <p class="refresh-picker pr-4 text-right">Reset</p>
                                                    </div>
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label><b>Procurement Type</b></label>
                                                        <div class="input-group">
                                                            <select class="col-md-12 selectpicker" data-style="form-control" data-show-tick="true"
                                                            name="procurement_type" id="procurement_type" title="Procurement Type">
                                                                <option>Self Purchase</option>
                                                                <option>Donation</option>
                                                            </select>
                                                        </div>
                                                        <p class="refresh-picker pr-4 text-right">Reset</p>
                                                    </div>
                                                    <div id="self-purchase-info" class="col-md-6 col-sm-12">
                                                        <div class="row">
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label><b>Purchase Price</b></label>
                                                            <div class="input-group">
                                                                <input type="number" step="0.01" class="form-control resetable" name="purchase_price"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label><b>Purchase Date</b></label>
                                                            <div class="input-group">
                                                                <input type="text" class="datepicker form-control resetable" name="purchase_date"/>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div id="donor-info" class="col-md-6 col-sm-12" style="display:none">
                                                        <div class="form-group col-md-6 col-sm-12">
                                                            <label><b>Donor</b></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control resetable" name="donor"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-11 mt-3">
                                                <div class="row">
                                                    <div class="form-group col-md-4 col-sm-12">
                                                        <label><b>Description</b></label>
                                                        <div class="input-group">
                                                            <textarea type="text" class="form-control" name="description" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4 col-sm-12">
                                                        <label><b>Location</b></label>
                                                        <div class="input-group">
                                                            <textarea type="text" class="form-control" name="area" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-file-upload form-file-simple col-md-4">
                                                        <label><b>Image</b></label>
                                                        <input type="text" class="form-control inputFileVisible" placeholder="Select file...">
                                                        <input type="file" class="inputFileHidden" name="image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="pull-right">
                                        <button type='submit' class='btn btn-purple btn-fill btn-rose btn-wd mb-4'>Save</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.admin_core_scripts')
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script>
        demo.initDateTimePicker();
        
        $('#procurement_type').on("change", function(){
            if($(this).val() == "Donation"){
                $("#donor-info").css("display", "block");
                $("#self-purchase-info").css("display", "none");
                $("#self-purchase-info").find("input").val(null);
            }else{
                $("#donor-info").css("display", "none");
                $("#self-purchase-info").css("display", "block");
                $('[name="donor"]').val(null);
            } 
        });

        $("#add_new_item").on("submit", function(e){
            e.preventDefault();
            let data = new FormData(this);
            data.append("region_id", '{{$admin->region_id}}');
            data.append("admin_id", '{{$admin->id}}');
            let btn = $(this).find('[type="submit"]');
            submit_file_form("/api/equipment/add", "post", data, undefined, btn, true);
        });
    </script>
</body>

</html>