@extends('layouts.user-dashboard', ['page_title' => $asset->name])
@section('styles')
<style>
.chart-container {
  width: 100%;
  height: 250px;
}
</style>
@endsection
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="">
                    <img src="{{asset('img/assets/equipment/'.$asset->image)}}" onerror = "this.src = '{{asset('img/image_placeholder.jpg')}}'"/>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title pb-2">{{$asset->name}}</h5>
                        <p style="position:absolute; top: 0; right: 0; margin: 16px;">
                            @if($asset->availability == "Operational")
                            <span><i class="fas fa-circle text-success pulse"></i></span>
                            @else
                            <span><i class="fas fa-circle text-danger pulse"></i></span>
                            @endif
                            <span class="text-muted">
                                <b>{{$asset->availability}}</b>
                            </span>
                        </p>
                        <ul class="nav nav-tabs nav-tabs-primary text-center mt-2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#details" role="tablist">
                                    Details
                                </a>
                            </li>
                            @if($user->role == 'Admin' || $user->role == 'Regular Technician')
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#parts" role="tablist">
                                        Associated Parts
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#work-orders" role="tablist">
                                        Work Orders
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#files" role="tablist">
                                        Files
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#child" role="tablist">
                                        Child Equipment
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#down-time" role="tablist">
                                    Down Time & Depreciation
                                </a>
                            </li>
                            @if($user->role == 'Admin' || $user->role == 'Regular Technician')
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#edit" role="tablist">
                                        Edit
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#actions" role="tablist">
                                        Actions
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content tab-space">
                            <div class="tab-pane active" id="details">
                                <div class="row pl-4">
                                    <div class="col-md-3">
                                        <div id="qrcode"></div>
                                        <button class="btn btn-purple btn-block" onclick="printContent('qrcode')">Print QR Code</button>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="description-label">Warranty Expiration</label>
                                                    <p class="text-highlighted">
                                                        {{$asset->warranty_expiration != null && !Carbon\Carbon::parse($asset->warranty_expiration)->isPast() ? Carbon\Carbon::parse($asset->warranty_expiration)->diffForHumans() : 'No warranty available'}}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="description-label">Equipment Code</label>
                                                    <p class="no-border"><b>{{$asset->asset_code}}</b></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="description-label">Status</label>
                                                    <p class="no-border">{{$asset->status}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="description-label">Serial Number</label>
                                                    <p class="no-border">{{$asset->serial_number == null ? "N/A" : $asset->serial_number}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="description-label">Model Number</label>
                                                    <p class="no-border">{{$asset->model_number == null ? "N/A" : $asset->model_number}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="description-label">Category</label>
                                                    <p class="no-border">{{$asset->asset_category == null ? "N/A" : $asset->asset_category->name}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="description-label">Department/Unit</label>
                                                    @if($asset->unit != null)
                                                    <p class="no-border">{{$asset->unit->name}}</p>
                                                    @elseif($asset->department != null)
                                                    <p class="no-border">{{$asset->department->name}}</p>
                                                    @else
                                                    <p class="no-border">N/A</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="description-label">Primary Technician</label>
                                                    <p class="no-border">{{$asset->user == null ? "N/A" : $asset->user->firstname.' '.$asset->user->lastname}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="description-label">Manufacturer</label>
                                                    <p class="no-border">{{$asset->manufacturer_name == null ? "N/A" : $asset->manufacturer_name}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="description-label">Service Vendor</label>
                                                    <p class="no-border">{{$asset->service_vendor == null ? "N/A" : $asset->asset_category->name}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="description-label">Description</label>
                                                    <textarea class="form-control" rows="4" readonly>{{$asset->description != null ? $asset->description : 'N/A'}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="description-label">Location</label>
                                                    <textarea class="form-control" rows="4" readonly>{{$asset->area != null ? $asset->area : 'N/A'}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="parts">
                                <div class="row" id="parts_div">
                                    <div class="col-md-12 text-right mb-2">
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#new-part-modal" style="text-decoration: underline"><b>Assign New Part</b></a>   
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="work-orders">
                                <div class="row">
                                    <table class="table table-bordered table-hover" id="work_orders">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>#</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Priority</th>
                                                <th>Lead Tech</th>
                                                <th>Last Updated</th>
                                                <th>Created</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Title</th>
                                                <th>#</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Priority</th>
                                                <th>Lead Tech.</th>
                                                <th>Last Updated</th>
                                                <th>Created</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        @foreach($asset->work_orders as $work_order)
                                            <tr>
                                                <td><a href="/work-order/{{$work_order->id}}"><b>{{$work_order->title}}</b></a></td>
                                                <td>{{$work_order->wo_number}}</td>
                                                <td>{{$work_order->due_date != null ? date('jS F, Y', strtotime($work_order->due_date)) : 'N/A'}}</td>
                                                <td>
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
                                                </td>
                                                <td>{{$work_order->priority != null ? $work_order->priority->name : 'N/A'}}</td>
                                                <td>
                                                @if($work_order->user != null)
                                                <img data-toggle="tooltip" title="{{$work_order->user->firstname.' '.$work_order->user->lastname}}" class="round" width="30" height="30" avatar="{{$work_order->user->firstname.' '.$work_order->user->lastname}}" />
                                                @else
                                                N/A
                                                @endif
                                                </td>
                                                <td>{{Carbon\Carbon::parse($work_order->updated_at)->format('jS F, Y')}}</td>
                                                <td>{{Carbon\Carbon::parse($work_order->created_at)->format('jS F, Y')}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="files">
                                <div class="row" id="files_div">
                                    <div class="col-md-12 text-right mb-2">
                                        <a href="javascript:void(0)" data-toggle="modal" data-target = "#new-file-modal" style="text-decoration: underline"><b>Add A File</b></a>   
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="child">
                                <div class="row">
                                    <div class="col-md-12 text-right mb-2">
                                        <a href="javascript:void(0)" style="text-decoration: underline" data-target="#new-asset-modal" data-toggle="modal"><b>Assign New Asset</b></a>   
                                    </div>
                                    <div class="col-md-12" id="children">

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="down-time">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card card-stats">
                                            <div class="card-body ">
                                                <div class="statistics statistics-horizontal">
                                                    <div class="info info-horizontal">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <div class="icon icon-danger icon-circle">
                                                                    <i class="fas fa-arrow-down"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-7 text-right">
                                                                <h3 class="info-title" id="downtime"><i class="now-ui-icons arrows-1_refresh-69 spin"></i></h3>
                                                                <h6 class="stats-title">Hours</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="card-footer ">
                                                <div class="stats">
                                                    <i class="fas fa-calendar"></i> Since {{Carbon\Carbon::parse($asset->created_at)->format('jS F, Y')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-stats">
                                            <div class="card-body ">
                                                <div class="statistics statistics-horizontal">
                                                    <div class="info info-horizontal">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <div class="icon icon-success icon-circle">
                                                                    <i class="fas fa-arrow-up"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-7 text-right">
                                                                <h3 class="info-title" id="uptime"><i class="now-ui-icons arrows-1_refresh-69 spin"></i></h3>
                                                                <h6 class="stats-title">Hours</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="fas fa-calendar"></i> Since {{Carbon\Carbon::parse($asset->created_at)->format('jS F, Y')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-7 col-sm-12">
                                        <label><b>Depreciation</b></label>
                                        <div class="chart-container">
                                          <canvas id="line-chartcanvas"></canvas>
                                          <div id="error_container"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-12">
                                        <label><b>Information</b></label>
                                        <p><b>Purchase Date:</b> {{$asset->purchase_date != null ? $asset->purchase_date : 'N/A'}}</p>
                                        <p><b>Purchase Price:</b> {{$asset->purchase_price != null ? $asset->purchase_price : 'N/A'}}</p>
                                        <p><b>Installation Date:</b> {{$asset->installation_date != null ? $asset->installation_date : 'N/A'}}</p>
                                        <p><b>Possible Replacement Date:</b> {{$asset->pos_rep_date != null ? $asset->pos_rep_date : 'N/A'}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="actions">
                                <div class="row pl-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><b>Status</b></label>
                                            <select class="selectpicker col-md-12" title="Status" data-style="form-control" id="status" data-show-tick="true">
                                                <option <?php if($asset->status == "Good"){echo "selected";} ?>>Good</option>
                                                <option <?php if($asset->status == "Bad"){echo "selected";} ?>>Bad</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><b>Availabilty</b></label>
                                            <select class="selectpicker col-md-12" title="Availability" data-style="form-control" id="availability" data-show-tick="true">
                                                <option <?php if($asset->availability == "Operational"){echo "selected";} ?>>Operational</option>
                                                <option <?php if($asset->availability != "Operational"){echo "selected";} ?>>Non operational</option>
                                            </select>
                                        </div>
                                    </div>
                                    @if($user->role == 'Admin')
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger"><b>Delete Equipment</b></label>
                                                <button class="btn btn-round btn-danger btn-block" data-toggle="modal" data-target="#delete">Delete</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane" id="edit">
                                <form id="edit_asset">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label><b>Equipment Name</b> <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control resetable" name="name" value="{{$asset->name}}" required/>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label><b>Serial Number</b></label>
                                            <input type="text" class="form-control resetable" name="serial_number" value="{{$asset->serial_number}}"/>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label><b>Model Number</b></label>
                                            <input type="text" class="form-control resetable" name="model_number" value="{{$asset->model_number}}"/>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label><b>Equipment Category</b> <span class="text-danger">*</span></label>
                                            <select class="selectpicker col-sm-12" title="Category" data-style="form-control" name="asset_category_id">
                                                @foreach($hospital->asset_categories as $category)
                                                    <option value="{{$category->id}}" <?php if($asset->asset_category_id == $category->id){echo 'selected';}?>>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                            <p class="refresh-picker pr-4 text-right">Reset</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label><b>Purchase Price</b></label>
                                            <input type="number" step="0.01" class="form-control resetable" value="{{$asset->purchase_price}}" name="purchase_price">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label><b>Purchase Date</b></label>
                                            <input type="text" class="form-control datepicker resetable" name="purchase_date" value="{{Carbon\Carbon::parse($asset->purchase_date)->format('m/d/Y')}}">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label><b>Warranty Expiration</b></label>
                                            <input type="text" class="form-control datepicker" name="warranty_expiration" value="{{Carbon\Carbon::parse($asset->warranty_expiration)->format('m/d/Y')}}"/>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label><b>Installation Date</b></label>
                                            <input type="text" class="form-control datepicker resetable" name="installation_date" value="{{Carbon\Carbon::parse($asset->installation_date)->format('m/d/Y')}}">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label><b>Possible Replacement Date</b></label>
                                            <input type="text" class="form-control datepicker resetable" name="pos_rep_date" value="{{Carbon\Carbon::parse($asset->pos_rep_date)->format('m/d/Y')}}">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label><b>Manufacturer Name</b></label>
                                            <input type="text" class="form-control" name="manufacturer_name" value="{{$asset->manufacturer_name}}"/>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label><b>Primary User</b></label>
                                            <select class="selectpicker col-sm-12" title="Primary User" data-style="form-control" name="user_id">
                                                @foreach($hospital->users as $user)
                                                    <option value="{{$user->id}}" <?php if($asset->user_id == $user->id){echo 'selected';}?>>{{$user->firstname.' '.$user->lastname}}</option>
                                                @endforeach
                                            </select>
                                            <p class="refresh-picker pr-4 text-right">Reset</p>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label><b>Service Vendor</b></label>
                                            <select class="selectpicker col-sm-12" title="Service Vendor" data-style="form-control" name="user_id">
                                                @foreach($hospital->services as $vendor)
                                                    <option value="{{$vendor->id}}" <?php if($asset->service_vendor_id == $vendor->id){echo 'selected';}?>>{{$vendor->name}}</option>
                                                @endforeach
                                            </select>
                                            <p class="refresh-picker pr-4 text-right">Reset</p>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        
                                        <div class="form-group col-md-4 mt-4 col-sm-12">
                                            
                                            <label><b>Description</b></label>
                                            <textarea class="form-control resetable" name="description" rows="3">{{$asset->description}}</textarea>
                                            
                                            <button type="submit" class="btn btn-purple mt-5" id="btn_submit">Save</button>
                                        </div>
                                        <div class="form-group col-md-4 mt-4 col-sm-12">
                                            <label><b>Location</b></label>
                                            <textarea class="form-control resetable" name="area" rows="3">{{$asset->area}}</textarea>
                                        </div>
                                        <div class="fileinput fileinput-new col-md-4 col-sm-12" data-provides="fileinput">
                                            <div class="col-md-12 form-group">
                                                    <label style="display:block;"><b>Image</b></label>
                                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail">
                                                            <img src="{{asset('img/assets/equipment/'.$asset->image)}}" onerror = "this.src = '{{asset('img/image_placeholder.jpg')}}'"/>
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                        <div>
                                                            <span class="btn btn-rose btn-round btn-file">
                                                                <span class="fileinput-new">Select image</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="image" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists"
                                                                data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="new-file-modal" class="modal fade right">
        <div class="modal-dialog">
            <form method = "post" id="new_file">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                        <h6 class="header">New File</h6>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group form-file-upload form-file-simple">
                                <label><b>Add New File</b></label>
                                <input class="form-control inputFileVisible" placeholder="Select file...">
                                <input type="file" class="inputFileHidden" name="name">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <button type="submit" class="btn btn-purple text-right pull-right">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="new-asset-modal" class="modal fade right">
        <div class="modal-dialog">
            <form method = "post" id="new_asset">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                        <h6 class="header">Assign Equipment</h6>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Select Equipment</b></label>
                                <select class="selectpicker col-md-12" id="assign_children" data-style="btn btn-purple"
                                name="children[]" title="Children Equipment" data-show-tick="true" data-live-search = "true" multiple>
                                    @foreach($hospital->assets as $single_asset)
                                        <option value="{{$single_asset->id}}">{{$single_asset->name}} ({{$single_asset->asset_code}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <button type="submit" class="btn btn-purple text-right pull-right">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="new-part-modal" class="modal fade right">
        <div class="modal-dialog">
            <form method = "post" id="new_part">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                        <h6 class="header">Assign Part</h6>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Select Part</b></label>
                                <select class="selectpicker col-md-12" id="assign_children" data-style="btn btn-purple"
                                name="parts[]" title="Select Parts" data-show-tick="true" data-live-search = "true" multiple>
                                    @foreach($hospital->parts as $part)
                                        <option value="{{$part->id}}">{{$part->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <button type="submit" class="btn btn-purple text-right pull-right">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="confirm-availability" class="modal fade">
        <div class="modal-dialog">
                <form method = "post" id="update_availability">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                            <h6 class="header">Confirm Avavilability Change</h6>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <p>Are you want sure you want to change the availability of this equipment? If so, change the status of the equipment if need be.</p>
                                <div class="form-group">
                                    <label><b>Status</b></label>
                                    <select class="selectpicker col-md-12" data-style="form-control"
                                    name="status" title="Status" data-show-tick="true" data-live-search = "true">
                                        <option <?php if($asset->status == "Good"){echo "selected";} ?>>Good</option>
                                        <option <?php if($asset->status == "Bad"){echo "selected";} ?>>Bad</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer mt-4">
                            <button type="submit" class="btn btn-purple text-right pull-right">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="confirm-status" class="modal fade">
        <div class="modal-dialog">
                <form method = "post" id="update_status">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                            <h6 class="header">Confirm Status Change</h6>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <p>Are you want sure you want to change the status of this equipment? If so, change the availability of the equipment if need be.</p>
                                <div class="form-group">
                                    <label><b>Availability</b></label>
                                    <select class="selectpicker col-md-12" title="Availability" name="availability" 
                                    data-style="form-control" id="availability" data-show-tick="true">
                                        <option <?php if($asset->availability == "Operational"){echo "selected";} ?>>Operational</option>
                                        <option <?php if($asset->availability != "Operational"){echo "selected";} ?>>Non operational</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer mt-4">
                            <button type="submit" class="btn btn-purple text-right pull-right">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="delete" class="modal fade">
        <div class="modal-dialog">
                <form method = "post" id="delete_asset">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                            <h6 class="header">Confirm Asset Deletion</h6>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <p>Are you want sure you want to delete this equipment?</p>
                            </div>
                        </div>
                        <div class="modal-footer mt-4">
                            <button type="submit" class="btn btn-danger text-right pull-right">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/qrcode.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/chartjs.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/annotation.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>
    <script src="{{asset('js/jasny-bootstrap.min.js')}}"></script>
    
    <script type="text/javascript">
        let temp_availability, temp_status;
        $(document).ready(function(){
            if($('#qrcode').html() == ''){
                qr = new QRCode(document.getElementById("qrcode"), "{{$asset->id}}");
            }

            let work_orders = generateDtbl("#work_orders", "No work orders raised for this equipment");
            demo.initDateTimePicker();
            loadParts();
            loadFiles();
            loadChildren();
            calculate_depreciation();
            loadDepreciation();
        });
        
        function viewQr(){
            $('#qrModal').modal('show');
        }

        function printContent(el){
            var restorepage = $('body').html();
            var printcontent = $('#' + el).clone();
            $('body').empty().html(printcontent);
            window.print();
            window.location.reload();
        }

        let loadParts = () => {
            const container = $("#parts_div");
            const temp_body = container.html();
            container.html(null);
            
            container.append(`<div class='col-md-12 text-center'>
            <i class='now-ui-icons arrows-1_refresh-69 spin' style='font-size: 18px;'></i>
            </div>`);

            $.ajax({
                url : "/api/asset/{{$asset->id}}/get-parts",
                method : "get",
                success : (data) => {
                    container.html(temp_body);
                    if(data.length > 0){
                        $.each(data, function(index, item){
                            let holder = `<div class="col-md-4 col-sm-12">
                                <div class="col-lg-12">
                                    <div class="card card-pricing ">
                                        <div class="card-body">
                                        <a href="/spare-part/${item.id}"><h6>${item.name}</h6></a>
                                        <div class="card-footer mt-3">
                                            <a href="javascript:void(0)" onclick="removePart('${item.id}', this)" class="btn btn-round btn-danger">Remove Part</a>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                            container.append(holder);
                        });
                    }else{
                        container.append(`<div class="col-md-12">
                        <p class="text-center text-muted">No parts associated with this equipment.
                        </div>
                        </p>`)
                    }
                },
                error : (xhr, err) => {
                    container.append(`<p class="text-danger text-center">There was a problem retrieving the associated parts of this equipment</p>`)
                }
            })
        }

        let loadChildren = () => {
            const container = $("#children");
            const temp_body = container.html();
            container.html(null);
            
            container.append(`<div class='col-md-12 text-center'>
            <i class='now-ui-icons arrows-1_refresh-69 spin' style='font-size: 18px;'></i>
            </div>`);

            $.ajax({
                url : "/api/asset/{{$asset->id}}/get-children",
                method : "get",
                success : (data) => {
                    container.html(temp_body);

                    $.each(data, function(index, item){
                        let holder = `<div class="col-md-4 col-sm-12">
                            <div class="col-lg-12">
                                <div class="card card-pricing ">
                                    <div class="card-body">
                                    <a href="/inventory/${item.id}"><h6>${item.name}</h6></a>
                                    <div class="card-footer mt-3">
                                        <a href="javascript:void(0)" onclick="removeChildEquipment('${item.id}', this)" class="btn btn-round btn-danger">Remove Equipment</a>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        container.append(holder);
                    })
                },
                error : (xhr, err) => {
                    container.html(temp_body);
                    container.append(`<p class="text-danger text-center">There was a problem retrieving the associated parts of this equipment</p>`)
                }
            })
        }

        let loadFiles = () => {
            const container = $("#files_div");
            const temp_body = container.html();
            container.html(null);
            
            container.append(`<div class='col-md-12 text-center'>
            <i class='now-ui-icons arrows-1_refresh-69 spin' style='font-size: 18px;'></i>
            </div>`);

            $.ajax({
                url : "/api/asset/{{$asset->id}}/get-files",
                method : "get",
                success : (data) => {
                    container.html(temp_body);

                    $.each(data, function(index, item){
                        let extension = item.name.split('.').pop();
                        let holder = `<div class="col-md-4 col-sm-12">
                            <div class="col-lg-12">
                                <div class="card card-pricing ">
                                    <div class="card-body">
                                    <h6>${item.name}</h6>
                                    <img src='{{url("/")}}/img/file_types/${extension}.svg' style="width:56px; height:auto; margin: 0 auto;"/>
                                    <div class="card-footer mt-3">
                                        <a href="/files/download/${item.id}" target="_blank" class="btn btn-round btn-danger">Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        container.append(holder);
                    })
                },
                error : (xhr, err) => {
                    container.html(temp_body);
                    container.append(`<p class="text-danger text-center">There was a problem retrieving the associated parts of this equipment</p>`)
                }
            })
        }

        $("#new_file").on("submit", function(e){
            e.preventDefault();
            let data = new FormData(this);
            data.append("asset_id", '{{$asset->id}}');
            let btn = $(this).find('[type="submit"]');

            let success = ({data}) => {
                let container = $("#files_div");
                let extension = data.name.split('.').pop();
                let holder = `<div class="col-md-4 col-sm-12">
                    <div class="col-lg-12">
                        <div class="card card-pricing ">
                            <div class="card-body">
                            <h6>${data.name}</h6>
                            <img src='{{url("/")}}/img/file_types/${extension}.svg' style="width:56px; height:auto; margin: 0 auto;"/>
                            <div class="card-footer mt-3">
                                <a href="/files/download/${data.id}" class="btn btn-round btn-danger">Download</a>
                            </div>
                        </div>
                    </div>
                </div>`;
                container.append(holder);
            }
            submit_file_form("/api/file/add", "post", data, success, btn, false);
        });

        let calculate_depreciation = () => {
            let start_year = {{$asset->installation_date == null ? date('Y', strtotime($asset->created_at)) : date('Y', strtotime($asset->installation_date))}};
            
            let end_year = {{$asset->pos_rep_date != null ? date('Y', strtotime($asset->pos_rep_date)) : 'null'}};
            let purchase_price = {{$asset->purchase_price != null ? $asset->purchase_price : 'null'}};
            
            if(end_year != null && end_year > start_year && purchase_price != null){
                let current_year = {{date('Y')}};
                let current_value = purchase_price - (((current_year - start_year) * purchase_price)/(end_year - start_year));
                current_value = current_value.toFixed(2);
                
                if (current_value < 0){
                    current_value = 0;
                }
                
                let values = [purchase_price, 0];
                let years = [start_year, end_year];
                
                let chartColor = "#FFFFFF";
                let ctx = document.getElementById("line-chartcanvas").getContext("2d");

                let options = {
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    tooltips: {
                        bodySpacing: 4,
                        mode:"nearest",
                        intersect: 0,
                        position:"nearest",
                        xPadding:10,
                        yPadding:10,
                        caretPadding:10
                    },
                    responsive: true,
                    scales: {
                        yAxes: [{
                            gridLines:0,
                            gridLines: {
                                zeroLineColor: "transparent",
                                drawBorder: false
                            }
                        }],
                        xAxes: [{
                            display:0,
                            gridLines:0,
                            ticks: {
                                display: false
                            },
                            gridLines: {
                            zeroLineColor: "transparent",
                            drawTicks: false,
                            display: false,
                            drawBorder: false
                            }
                        }]
                    },
                    layout:{
                        padding:{left:0,right:0,top:15,bottom:15}
                    },
                    annotation: {
                        annotations: [{
                            type: 'line',
                            mode: 'horizontal',
                            scaleID: 'y-axis-0',
                            value: current_value,
                            borderColor: 'rgb(75, 192, 192)',
                            borderWidth: 2,
                            label: {
                                enabled: true,
                                content: 'Current value $'+ current_value
                                }
                            },
                        ]
                    }
                };

                
                let gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
                gradientStroke.addColorStop(0, '#18ce0f');
                gradientStroke.addColorStop(1, chartColor);

                let gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
                gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
                gradientFill.addColorStop(1, hexToRGB('#18ce0f',0.4));

                myChart = new Chart(ctx, {
                    type: 'line',
                    responsive: true,
                    data: {
                        labels: years,
                        datasets: [{
                            label: "Equipment Value",
                            borderColor: "#18ce0f",
                            pointBorderColor: "#FFF",
                            pointBackgroundColor: "#18ce0f",
                            pointBorderWidth: 2,
                            pointHoverRadius: 4,
                            pointHoverBorderWidth: 1,
                            pointRadius: 4,
                            fill: true,
                            backgroundColor: gradientFill,
                            borderWidth: 2,
                            data: values
                        }]
                    },
                    options: options
                });
            }else{
                $("#error_container").append("<p class='text-muted text-center'><i>Required parameters to calculate depreciation unavailable. <b>Possible Replacement Date</b> and <b>Purchase Price</b> must be known. Otherwise the possible replacement date and replacement date must be at least 2 years apart</i></p>")
            }
        }

        const loadDepreciation = () => {
            $.ajax({
                url : "/api/asset/{{$asset->id}}/depreciation",
                method : "get",
                success : (data) => {
                    let downtime;
                    let runtime;
                    
                    data.downtime.downtime == null ? downtime = 0 : downtime = data.downtime.downtime;
                    runtime = data.running_time;

                    $("#downtime").html(downtime);
                    $("#uptime").html(runtime - downtime);

                },
                error : (xhr, err) => {
                    $("#up-time").html("N/A");
                    $("#down-time").html("N/A");
                }
            })
        }

        $("#availability").on("change", function(){
            $("#confirm-availability").modal("show");
            temp_availability = $('#availability').val();
        });

        $("#status").on("change", function(){
            $("#confirm-status").modal("show");
            temp_status = $(this).val();
        });

        $("#update_availability").on("submit", function(e){
            e.preventDefault();
            let data = $(this).serialize();
            data += "&asset_id={{$asset->id}}";
            data += "&availability="+temp_availability;
            let btn = $(this).find("[type='submit']");

            submit_form("/api/asset/{{$asset->id}}/toggle", "post", data, undefined, btn, false);
        });

        $("#update_status").on("submit", function(e){
            e.preventDefault();
            let data = $(this).serialize();
            data += "&asset_id={{$asset->id}}";
            data += "&status="+temp_status;
            let btn = $(this).find("[type='submit']");

            submit_form("/api/asset/{{$asset->id}}/toggle", "post", data, undefined, btn, false);
        });

        $("#delete_asset").on("submit", function(e){
            e.preventDefault();
            let btn = $(this).find("[type='submit']");

            success = (data) => {
                if(!data.error){
                    location.replace("/inventory");
                }else{
                    presentNotification(data.message, "danger", "top", "right");
                }
            }

            submit_form("/api/asset/{{$asset->id}}/delete", "delete", undefined, success, btn, false);
        });

        $("#edit_asset").on("submit",function(e){
            e.preventDefault();

            let data = new FormData(this);
            data.append("_method", "put");

            let btn = $(this).find('[type="submit"]');
            submit_file_form("/api/asset/{{$asset->id}}/update", "post", data, undefined, btn, true);
        });

        const removePart = (id, element) => {
            let data = new FormData();
            data.append("part_id", id);
            let btn = $(element);

            submit_file_form("/api/asset/{{$asset->id}}/remove-part", "post", data, undefined, btn, true);
        }

        const removeChildEquipment = (id, element) => {
            let data = new FormData();
            data.append("child_id", id);
            let btn = $(element);

            submit_file_form("/api/asset/{{$asset->id}}/remove-child", "post", data, undefined, btn, true);
        }

        $("#new_part").on("submit", function(e){
            e.preventDefault();
            let data = new FormData(this);
            let btn = $(this).find('[type="submit"]');
            submit_file_form("/api/asset/{{$asset->id}}/assign-parts", "post", data, undefined, btn, true);
        })

        $("#new_asset").on("submit", function(e){
            e.preventDefault();
            let data = new FormData(this);
            let btn = $(this).find('[type="submit"]');
            submit_file_form("/api/asset/{{$asset->id}}/assign-children", "post", data, undefined, btn, true);
        })
        
    </script>
@endsection