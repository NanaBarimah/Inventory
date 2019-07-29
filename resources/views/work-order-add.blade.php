@extends('layouts.user-dashboard', ['page_title' => 'Add Work Order'])
@section('content')
    <div class="content">
        <div class="col-md-12 mr-auto ml-auto">
            <div>
                <div class="card" data-color="primary">
                    <form method="post" action="#" id="add_wo_form" class="p=4">
                        <div class="card-header">
                            <h4 class="inline-block">
                                New Work Order
                            </h4>
                        </div>

                        
                    <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6 pr-1">
                                    <div class="form-group">
                                        <label><b>Title</b> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-line resetable" placeholder="Title" name="title" required>
                                    </div>
                                </div>
                                <div class="col-md-3 pl-1">
                                    <div class="form-group">
                                        <label class="pl-3"><b>Priority</b>  <span class="text-danger">*</span></label>
                                        <select class="selectpicker col-md-12" data-style="btn btn-purple btn-round" name="priority_id" title="Priority" required>
                                            @foreach($hospital->priorities as $priority)
                                            <option value="{{$priority->id}}">{{$priority->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 pl-1">
                                    <div class="form-group">
                                        <label class="pl-3"><b>Fault Category</b> <span class="text-danger">*</span></label>
                                        <select class="selectpicker col-md-12" data-style="btn btn-purple btn-round" name="fault_category_id" title="Fault Type" required>
                                            @foreach($hospital->fault_categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4 pr-1">
                                    <div class="form-group">
                                        <label><b>Equipment</b> <span class="text-danger">*</span></label>
                                        <select class="selectpicker col-md-12" data-style="btn form-control" name="asset_id" title="Equipment" 
                                        data-show-tick="true" data-live-search="true" data-show-subtext="true">
                                            @if($hospital->assets->count() > 0)
                                                @foreach($hospital->assets as $asset)
                                                <option value="{{$asset->id}}" data-subtext="{{$asset->name}}">{{$asset->serial_number}}</option>
                                                @endforeach
                                            @else
                                                <option disabled>No equipment recorded</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 pr-1">
                                    <div class="form-group">
                                        <label><b>Estimated Duration (in hours)</b></label>
                                        <input type="text" class="form-control resetable" name="estimated_duration">
                                    </div>
                                </div>
                                @if($user->role == "Admin")
                                <div class="col-md-4 pr-1">
                                    <div class="form-group">
                                        <label><b>Lead Technician</b> <span class="text-danger">*</span></label>
                                        <select class="selectpicker col-md-12" data-style="btn btn-purple btn-round" name="assigned_to" title="Lead Technician" required>
                                            @foreach($hospital->users as $user)
                                            <option value="{{$user->id}}">{{$user->firstname.' '.$user->lastname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-3 pr-1">
                                    <div class="form-group">
                                        <label><b>Due Date</b></label>
                                        <input type="text" class="form-control datepicker" name="due_date"/>
                                    </div>
                                </div>
                                <div class="col-md-3 pr-1">
                                    <div class="form-group">
                                        <label><b>Department</b></label>
                                        <select class="selectpicker col-md-12" data-style="btn form-control" name="department_id" title="Department" id="department" data-show-tick="true">
                                        @if($hospital->departments->count() > 0)
                                            @foreach($hospital->departments as $department)
                                            <option value="{{$department->id}}" data-units = "{{$department->units}}">{{$department->name}}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No known departments</option>
                                        @endif
                                        </select>
                                        <p class="text-right pr-3 refresh-picker"><b>Reset</b></p>
                                    </div>
                                </div>
                                <div class="col-md-3 pr-1">
                                    <div class="form-group">
                                        <label><b>Unit</b></label>
                                        <select class="selectpicker col-md-12" data-style="btn form-control" name="unit_id" id="unit" title="Unit" data-show-tick="true">
                                            <option disabled>Select a department</option>
                                        </select>
                                        <p class="text-right pr-3 refresh-picker"><b>Reset</b></p>
                                    </div>
                                </div>
                                <div class="col-md-3 pr-1">
                                    <div class="form-group">
                                        <label><b>Service Vendor</b></label>
                                        <select class="selectpicker col-md-12" data-style="btn btn-round btn-purple" name="service_vendor_id" title="Service Vendor">
                                        @if($hospital->services->count() > 0)
                                            @foreach($hospital->services as $vendor)
                                            <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No known service vendor</option>
                                        @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>Description</b></label>
                                        <textarea class="form-control" name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="d-block">
                                <p class="text-muted text-small">All fields marked (<span class="text-danger">*</span>) are mandatory</p>
                            </div>
                            <div class="pull-right">
                                <input type='reset' class='btn btn-wd' value='Reset' id="btn_reset"/>
                                <button type='submit' class='btn btn-purple btn-wd' id="btn_save">Save</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script>
        demo.initDateTimePicker();
        $("#department").on("change", function(){
            $("#unit").val(null);
            $("#unit").html(null);

            let units = $(this).find(":selected").data("units");

            if(units.length > 0){
                $("#unit").selectpicker("refresh");

                $.each(units, function(index, unit){
                    $("#unit").append(`<option value="${unit.id}">${unit.name}</option>`);
                });

            }else{
                $("#unit").append(`<option disabled>No units for this department</option>`);
            }

            $("#unit").selectpicker("refresh");
        });

        $("#add_wo_form").on("submit", function(e){
            e.preventDefault();
            let data = new FormData(this);
            data.append("hospital_id", '{{$user->hospital_id}}');
            data.append("authenticated_user", "{{$user->id}}");
            
            @if($user->role != "Admin")
            data.append("assigned_to", '{{$user->id}}')
            @endif
            
            data.append("user_admin", '{{$user->id}}');
            let btn = $(this).find('[type="submit"]');

            const success = (data) => {
                setTimeout(() => {
                    location.replace(`/work-order/${data.work_order.id}`)
                }, 500);
            }
            submit_file_form("/api/work-order/add", "post", data, success, btn, false);
        });
    </script>
@endsection