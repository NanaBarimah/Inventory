@extends('layouts.user-dashboard', ['page_title' => $request->title])

@section('content')
    <div class="content">
        <div class="col-md-12 mr-auto ml-auto">
            <div>
                <div class="card">
                    <div class="card-header mb-4">
                        <h4 class="heading">{{$request->title}}</h4>
                        <strong>{{date('jS F Y', strtotime($request->created_at))}}</strong> 
                        <span class="float-right">
                            @if($request->status == 2) <i class="fas fa-circle text-warning"></i> Pending 
                            @elseif($request->status == 1) <i class="fas fa-circle text-success"></i> Accepted  &nbsp;<i style="cursor:pointer" class="far fa-question-circle" title="{{$request->response}}" data-toggle="tooltip"></i>
                            @elseif($request->status == 0) <i class="fas fa-circle text-danger"></i> Denied &nbsp;<i style="cursor:pointer" class="far fa-question-circle" title="{{$request->reason}}" data-toggle="tooltip"></i>
                            @endif</span>
                        <div class="dropdown" style="position:absolute; top: 0; right: 0;">
                            <button type="button"
                                class="btn btn-round btn-default dropdown-toggle btn-simple"
                                data-toggle="dropdown" style="border:none;">
                                Actions
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @if($request->status != 1)
                                @if($user->role == "Admin")
                                    <button class="dropdown-item" data-target="#accept_request" data-toggle="modal">Mark as <b>accepted</b></button>
                                    <button class="dropdown-item" data-target="#decline_request" data-toggle="modal">Mark as <b>declined</b></button>
                                @endif
                                @if($user->id == $request->requested_by)
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#edit_request" class="dropdown-item">Edit</a>
                                @endif
                                @else
                                    <a href="javascript:void(0)"class="dropdown-item" disabled>No actions available</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Title</b></label>
                                    <p>{{$request->title}}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Priority</b></label>
                                    <p>{{$request->priority->name}}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Requested Equipment</b></label>
                                    <p>{{$request->asset != null ? $request->asset->name : 'N/A'}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Description</b></label>
                                    <p>
                                        {{$request->description}}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Unit</b></label>
                                    <p>
                                        {{$request->unit != null ? $request->unit->name : 'N/A'}}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Department</b></label>
                                    <p>
                                        {{$request->department != null ? $request->department->name : 'N/A'}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Requested By</b></label>
                                    <p>{{$request->user != null ? $request->user->firstname.' '.$request->user->lastname : $request->requester_name}}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Email</b></label>
                                    <p>{{$request->user != null ? $request->user->email : $request->requester_email}}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Phone Number</b></label>
                                    <p>{{$request->user != null ? $request->user->phone_number : $request->requester_number}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Attached Image</b></label>
                                    <img src="{{asset('img/assets/request/'.$request->image)}}" class="img-responsive" style="max-height: 250px; display:block;" onerror = "this.src = '{{asset('img/image_placeholder.jpg')}}'"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Attached File</b></label>
                                    @if($request->fileName == null)
                                    <p>N/A</p>
                                    @else
                                    <p><a href="javascript:void(0)">{{$request->fileName}}</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="decline_request">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="decline_form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                        <h3>Confirm Decline</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p>Provide a reason why you are declining this request</p>
                                <div class="form-group">
                                    <label><b>Reason</b> <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="reason" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-danger text-right pull-right">Decline</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="accept_request">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="approve_form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                        <h3>Confirm Approval</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><b>Response</b></label>
                                    <textarea class="form-control" name="reason"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-purple text-right pull-right">Approve</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_request">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="update_form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                        <h3>Edit Request</h3>
                    </div>
                    <div class="modal-body">
                        <div class = "row mb-3">
                            <div class="col-md-6">
                                <label><b>Title</b> <span class="text-danger">*</span></label>
                                <input class="form-control form-line resetable" placeholder="Title" name="title" value="{{$request->title}}" required>
                            </div>
                            <div class="col-md-6 pl-1">
                                <div class="form-group">
                                    <label class="pl-3"><b>Request Priority</b>  <span class="text-danger">*</span></label>
                                    <select class="selectpicker col-md-12" data-style="btn btn-purple btn-round" name="priority_id" title="Priority" required>
                                        @foreach($hospital->priorities as $priority)
                                        <option value="{{$priority->id}}" @if($request->priority_id == $priority->id) selected @endif>{{$priority->name}}</option>
                                        @endforeach
                                    </select>
                                    <p class="refresh-picker pr-4 text-right">Reset</p>
                                </div>
                            </div>
                        </div>
                        <div class = "row mb-3">
                            <div class="col-md-4 pr-1">
                                <div class="form-group">
                                    <label><b>Department</b></label>
                                    <select class="selectpicker col-md-12" data-style="btn form-control" name="department_id" title="Department" id="department" data-show-tick="true">
                                    @if($hospital->departments->count() > 0)
                                        @foreach($hospital->departments as $department)
                                        <option value="{{$department->id}}" data-units = "{{$department->units}}" @if($request->department_id == $department->id) selected @endif>{{$department->name}}</option>
                                        @endforeach
                                    @else
                                        <option disabled>No known departments</option>
                                    @endif
                                    </select>
                                    <p class="refresh-picker pr-4 text-right">Reset</p>
                                </div>
                            </div>
                            <div class="col-md-4 pr-1">
                                <div class="form-group">
                                    <label><b>Unit</b></label>
                                    <select class="selectpicker col-md-12" data-style="btn form-control" name="unit_id" id="unit" title="Unit" data-show-tick="true">
                                    </select>
                                    <p class="refresh-picker pr-4 text-right">Reset</p>
                                </div>
                            </div>
                            <div class="col-md-4 pr-1">
                                <div class="form-group">
                                    <label><b>Equipment</b></label>
                                    <select class="selectpicker col-md-12" data-style="btn form-control" name="asset_id" title="Equipment" 
                                    data-show-tick="true" data-live-search="true">
                                        @if($hospital->assets->count() > 0)
                                            @foreach($hospital->assets as $asset)
                                            <option value="{{$asset->id}}"  @if($request->asset_id == $asset->id) selected @endif>{{$asset->name}}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No equipment recorded</option>
                                        @endif
                                    </select>
                                    <p class="refresh-picker pr-4 text-right">Reset</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><b>Description</b></label>
                                    <textarea class="form-control" name="description">{{$request->description}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <div class="pull-right right text-right">
                            <button type="submit" class="btn btn-purple text-right pull-right">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
<script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
<script>
    $('[data-toggle="tooltip"]').tooltip();

    $("#decline_form").on("submit", function(e){
        e.preventDefault();
        let data = new FormData(this);
        data.append("id", "{{$request->id}}");
        data.append("_method", "put");
        let btn = $(this).find('[type="submit"]');

        submit_file_form("/api/request/{{$request->id}}/decline", "post", data, undefined, btn, true); 
    });

    $("#approve_form").on("submit", function(e){
        e.preventDefault();
        let data = new FormData(this);
        
        data.append("user_admin", "{{Auth::user()->id}}");
        data.append("approved_by", "{{Auth::user()->id}}");
        data.append("_method", "put");
        
        let btn = $(this).find('[type="submit"]');

        let success = (data) => {
            setTimeout(() => {
                window.location.replace(`/work-order/${data.work_order.id}`);
            }, 500);
        }

        submit_file_form("/api/request/{{$request->id}}/approve", "post", data, success, btn, false);
    });

    $("#update_form").on("submit", function(e){
        e.preventDefault();
        let data = new FormData(this);
        data.append("_method", "put");
        let btn = $(this).find('[type="submit"]');

        submit_file_form("/api/request/{{$request->id}}/update", "post", data, undefined, btn, true);        
    });
    
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

    $(document).ready(function(){
        let units = $('#department').find(":selected").data("units");
        if(units != undefined){
            if(units.length > 0){
                $("#unit").selectpicker("refresh");

                $.each(units, function(index, unit){
                    let selected = "";
                    if(unit.id == "{{$request->unit_id}}"){
                        selected = "selected";
                    }

                    $("#unit").append(`<option value="${unit.id}" ${selected}>${unit.name}</option>`);
                });

            }
        }else{
            $("#unit").append(`<option disabled>No unit selected</option>`);
        }

        $("#unit").selectpicker("refresh");
    });
</script>
@endsection