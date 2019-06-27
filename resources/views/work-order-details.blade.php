@extends('layouts.user-dashboard', ['page_title' => $work_order->title])
@section('styles')
<style>
.card-comments .card-body{
    min-height: 350px;
    max-height: 400px;
    overflow-x: auto;
}

.add-asset{
    font-weight: bold;
    padding-left: 4px;
    font-size: 12px;
    cursor: pointer;
    text-decoration: underline;
}

.text-small{
    font-size:12px;
}
</style>
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-9 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{$work_order->title}}</h5>
                    <div class="dropdown" style="position:absolute; top: 0; right: 0;">
                        <button type="button"
                            class="btn btn-round btn-default dropdown-toggle btn-simple"
                            data-toggle="dropdown" style="border:none;">
                            Actions
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item">Mark as <b>open</b></button>
                            <button class="dropdown-item">Mark as <b>in progress</b></button>
                            <button class="dropdown-item">Mark as <b>on hold</b></button>
                            <button class="dropdown-item">Mark as <b>closed</b></button>
                            <button class="dropdown-item"><b>Edit</b> work order</button>
                        </div>
                    </div>
                    <ul class="nav nav-tabs nav-tabs-primary text-center">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" role="tablist" href="#details">Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" role="tablist" href="#activity">Activity</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" role="tablist" href="#parts">Spare Parts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" role="tablist" href="#pos">Purchase Orders</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content tab-space">
                        <div class="tab-pane active" id="details">
                            <div class="row mb-4" style="margin-top: -50px">
                                <div class="col-md-12 text-right">
                                    <label><b>Status</b></label>
                                    @if($work_order->status == 1)
                                    <span class="badge badge-light">Closed</span>
                                    @elseif($work_order->status == 2)
                                    <span class="badge badge-success">In Progress</span>
                                    @elseif($work_order->status == 3)
                                    <span class="badge badge-primary">On Hold</span>
                                    @elseif($work_order->status == 4)
                                    <span class="badge badge-info">Open</span>
                                    @elseif($work_order->status == 5)
                                    <span class="badge badge-warning">Pending</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h6>Description</h6>
                                        <p class="text-muted">{{$work_order->description != null ? $work_order->description : 'No description provided'}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><b>Date Created</b></label>
                                        <p>{{Carbon\Carbon::parse($work_order->created_at)->format('jS F, Y')}}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><b>Due Date</b></label>
                                        <p>{{$work_order->due_date != null ? Carbon\Carbon::parse($work_order->due_date)->format('jS F, Y') : 'N/A'}}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h6>Lead Technician</h6>
                                        <p>{{$work_order->user == null ? 'None Assigned' : $work_order->user->firstname.' '.$work_order->user->lastname}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h6>Additional Technicians</h6>
                                        @if($work_order->users->count() == 0)
                                        <span class="text-muted">None assigned</span>&nbsp;
                                        @else
                                        @foreach($work_order->users as $user)
                                        <img class="round" width="30" height="30" avatar="{{$user->firstname.' '.$user->lastname}}" data-toggle="tooltip" title="{{$user->firstname.' '.$user->lastname}}"/>
                                        @endforeach
                                        @endif
                                        <button class="btn btn-round btn-light btn-icon" data-toggle="modal" data-target="#assign_team"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h6><b>Asset</b></h6>
                                        <span>
                                        @if($work_order->asset != null)
                                        <a href="/inventory/{{$work_order->asset->id}}">{{$work_order->asset->name}}</a>
                                        @else
                                        N/A <span class="add-asset text-primary" data-toggle="modal" data-target="#assign_asset">Assign asset</span>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="activity">
                            <a href="javascript:void(0)" class="btn btn-round pull-right" 
                            data-toggle="modal" data-target="#add_activity" style="margin-top: -50px">Add Activity</a>
                            <div class="row">
                                <div class="col-sm-12" id="activities">
                                    <p class="text-center"><i class="now-ui-icons arrows-1_refresh-69 spin"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="parts">
                        </div>
                        <div class="tab-pane" id="pos">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="card card-comments">
                <div class="card-header">
                    <h6 class="title">Comments</h6>
                </div>
                <div class="card-body">
                    <span class="text-muted">No comments made yet</span>
                </div>
                <div class="card-footer">
                    <textarea class="form-control" placeholder="Write comment"></textarea>
                    <button class="btn btn-round btn-purple mt-2 pull-right mb-3">Comment</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="assign_team">
    <div class="modal-dialog">
        <form method = "post" id="add_engineer">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                    <h6 class="header">Add Technicians To Work Order</h6>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>Select technicians to add</b></label>
                            <select class="selectpicker col-md-12" data-style="form-control" title="Technicians" name="user_ids[]"
                            data-live-search="true" data-show-tick="true" id="technicians" multiple required>
                            <option disabled><i>Fetching Technicians...</i></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-4 right">
                    <button type="submit" class="btn btn-purple">Add To Work Order</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="assign_asset">
    <div class="modal-dialog">
        <form method = "post" id="add_asset">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                    <h6 class="header">Assign Asset To Work Order</h6>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>Select asset</b></label>
                            <select class="selectpicker col-md-12" data-style="form-control" title="Asset" name="asset_id"
                            data-live-search="true" data-show-tick="true" id="assets" required>
                            <option disabled><i>Fetching Assets...</i></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-4 right">
                    <button type="submit" class="btn btn-purple">Assign To Work Order</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="add_activity">
    <div class="modal-dialog">
        <form method="post" id="add_activity_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                    <h6 class="header">Record Activity</h6>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>What work was done?</b></label>
                            <textarea class="form-control" name="activity"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-4 right">
                    <button type="submit" class="btn btn-purple">Record</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script>
    $("[data-toggle='tooltip']").tooltip();
    $(document).ready(function(){
        fetchTechnicians();
        fetchAssets();
        fetchActivities();
    })

    const fetchTechnicians = () => {
        $.ajax({
            url : '/api/work-order/available-technicians/{{$work_order->id}}',
            data : 'GET',
            success : (data) => {
                if(data.engineers.length == 0){
                    $('#technicians').html(`<option disabled>No technicians available</option>`);
                }else{
                    $('#technicians').html(null);

                    $.each(data.engineers, function(index, engineer){
                        $('#technicians').append(`<option value="${engineer.id}">${engineer.firstname} ${engineer.lastname}</option>`)
                    });
                }

                $('#technicians').selectpicker("refresh");
            },
            error : (xhr) => {
            }
        });
    }

    const fetchAssets = () => {
        $.ajax({
            url : '/api/assets/{{Auth::user()->hospital_id}}',
            data : 'GET',
            success : (data) => {
                if(data.length == 0){
                    $('#assets').html(`<option disabled>No assets available</option>`);
                }else{
                    $('#assets').html(null);

                    $.each(data, function(index, asset){
                        $('#assets').append(`<option value="${asset.id}">${asset.name}</option>`)
                    });
                }

                $('#assets').selectpicker("refresh");
            },
            error : (xhr) => {
            }
        });
    }
    
    const fetchActivities = () => {
        $.ajax({
            url : '/api/work-order/{{$work_order->id}}/activities',
            data : 'GET',
            success : (data) => {
                if(data.length == 0){
                    $("#activities").html(null);
                    $("#activities").append(`<p class="text-muted text-bold text-center">No activities recorded for this work order</p>`)
                }else{
                    const colors = ["primary", "danger", "info", "warning"];
                    $("#activities").html(`
                    <div class="card card-timeline card-plain">
                            <div class="card-body">
                                <ul class="timeline">

                                </ul>
                            </div>
                        </div>
                    `);

                    $.each(data, function(index, activity){
                        const swatch = colors[Math.floor(Math.random() * colors.length)];
                        let css_class = "";
                        if(index%2 == 0){
                            css_class = "timeline-inverted";
                        }
                        $(".timeline").append(`
                            <li class="${css_class}">
                                <div class="timeline-badge ${swatch}">
                                    <i class="now-ui-icons ui-1_settings-gear-63"></i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <span class="badge badge-${swatch}">${activity.pivot.created_at}</span>
                                    </div>
                                    <div class="timeline-body">
                                        <p>${activity.pivot.action_taken}</p>
                                        <p class="text-small text-right"><i>recorded by <a href="javascript:void(0)">${activity.firstname} ${activity.lastname}</a></i></p>
                                    </div>
                                </div>
                            </li>
                        `);
                    })
                }
            },
            error : (xhr) => {
                console.log(xhr);
            }
        });
    }
    $("#add_engineer").on("submit", function(e){
        e.preventDefault();
        let data = new FormData(this);
        let btn = $(this).find('[type="submit"]');

        submit_file_form("/api/work-order/{{$work_order->id}}/assign-team", "post", data, undefined, btn, true);
    });

    $("#add_asset").on("submit", function(e){
        e.preventDefault();
        let data = new FormData(this);
        data.append("_method", "put");
        let btn = $(this).find('[type="submit"]');

        submit_file_form("/api/work-order/{{$work_order->id}}/assign-asset", "post", data, undefined, btn, true);
    });

    $("#add_activity_form").on("submit", function(e){
        e.preventDefault();
        let data = new FormData(this);
        data.append("user_id", "{{Auth::user()->id}}")
        let btn = $(this).find('[type="submit"]');

        submit_file_form("/api/work-order/{{$work_order->id}}/record-activity", "post", data, undefined, btn, true);
    });
    </script>
@endsection