@extends('layouts.user-dashboard', ['page_title' => $department->name])
@section('styles')
<style>
#work_order_canvas{
    height: 1500px;
}
</style>
@endsection
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">{{$department->name}}</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-2">
                                    <ul class="nav nav-pills nav-pills-primary nav-pills-icons flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#work_orders" role="tablist">
                                                <i class="now-ui-icons ui-2_settings-90"></i>
                                                Work Orders
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#assets" role="tablist">
                                                <i class="now-ui-icons users_single-02"></i>
                                                Equipment
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#units" role="tablist">
                                                <i class="now-ui-icons business_bank"></i>
                                                Units
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#details" role="tablist">
                                                <i class="now-ui-icons travel_info"></i>
                                                Details
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-10">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="work_orders">
                                            <table class="table table-bordered table-hover" id="work_orders">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>#</th>
                                                        <th>Due Date</th>
                                                        <th>Status</th>
                                                        <th>Priority</th>
                                                        <th>Lead Tech</th>
                                                        <th>Equip.</th>
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
                                                        <th>Equip.</th>
                                                        <th>Last Updated</th>
                                                        <th>Created</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="reports">
                                            
                                        </div>
                                        <div class="tab-pane" id="assets">
                                        <h4 class="heading">Equipment</h4>
                                            <table id="assets_table" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Equip. No.</th>
                                                        <th>Category</th>
                                                        <th>Status</th>
                                                        <th>Availability</th>
                                                        <th>Date Created</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Equip. No.</th>
                                                        <th>Category</th>
                                                        <th>Status</th>
                                                        <th>Availability</th>
                                                        <th>Date Created</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                @foreach($department->assets as $item)
                                                    <tr class="uppercase">
                                                        <td>
                                                            @if($user->role == 'Admin' || $user->role == 'Regular Technician')
                                                                <a href="/inventory/{{$item->id}}"><b>{{$item->name}}</b></a>
                                                            @elseif($user->role == 'View Only')
                                                                <b>{{$item->name}}</b>
                                                            @endif
                                                        </td>
                                                        <td>{{$item->asset_code}}</td>
                                                        <td>{{$item->category != null ? $item->category->name : "N/A"}}</td>
                                                        <td>{{$item->status}}</td>
                                                        <td>{{$item->availability}}</td>
                                                        <td>{{Carbon\Carbon::parse($item->created_at)->format('j F, Y')}}</td>
                                                    </tr>
                                                @endforeach
                                                @foreach($department->units as $unit)
                                                    @foreach($unit->assets as $item)
                                                    <tr class="uppercase">
                                                        <td>
                                                            @if($user->role == 'Admin' || $user->role == 'Regular Technician')
                                                                <a href="/inventory/{{$item->id}}"><b>{{$item->name}}</b></a>
                                                            @elseif($user->role == 'View Only')
                                                                <b>{{$item->name}}</>
                                                            @endif
                                                        </td>
                                                        <td>{{$item->asset_code}}</td>
                                                        <td>{{$item->category != null ? $item->category->name : "N/A"}}</td>
                                                        <td>{{$item->status}}</td>
                                                        <td>{{$item->availability}}</td>
                                                        <td>{{Carbon\Carbon::parse($item->created_at)->format('j F, Y')}}</td>
                                                    </tr>
                                                    @endforeach
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="units">
                                            <h4 class="heading">Units</h4>
                                            <table id="units_table" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Location</th>
                                                        <th>Contact Number</th>
                                                        <th class="text-right disable-sorting">User</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Location</th>
                                                        <th>Contact Number</th>
                                                        <th class="text-right disable-sorting">User</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    @foreach($department->units as $unit)
                                                        <tr>
                                                            <td>
                                                                @if($user->role == 'Admin' || $user->role == 'Regular Techician')
                                                                    <a href="javascript:void(0)">{{$unit->name}}</a>
                                                                @elseif($user->role == 'View Only')
                                                                    {{$unit->name}}
                                                                @endif
                                                            </td>
                                                            <td>{{$unit->location != null ? $unit->location : 'N/A'}}</td>
                                                            <td>{{$unit->phone_number != null ? $unit->phone_number : 'N/A'}}</td>
                                                            <td class="text-right">{{$unit->user != null ? $unit->user->firstname.' '.$unit->user->lastname : 'N/A'}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @if($user->role == 'Admin')
                                            <a href="javascript:void(0)" data-target="#addUnitModal" data-toggle="modal">
                                                <div class="fab">
                                                    <i class="fas fa-plus"></i>
                                                </div>
                                            </a>
                                            @endif
                                        </div>
                                        <div class="tab-pane" id="details">
                                            <div class="card-header text-center">
                                                <h4 class="title">{{$department->name}}</h4>
                                                <h5 class="subtitle text-lighted"><i class="fas fa-compass"></i> {{$department->location}}</h5>
                                                <h5 class="subtitle text-lighted"><i class="fas fa-user"></i> {{$department->user == null ? "N/A" : $department->user->firstname." ".$department->user->lastname}}</h5>
                                                <h5 class="subtitle text-lighted"><i class="fas fa-phone"></i> {{$department->phone_number == null ? "N/A" : $department->phone_number}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <div class="modal fade" id="addUnitModal" tabindex="-1" role="dialog" aria-labelledby="addUnitLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <form method = "post" id="add_unit_form">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                <h6 class="header">Add Unit</h6>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><b>Unit Name</b> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control resetable" name="name" required/>
                    </div>
                    <div class="form-group col-md-6">
                        <label><b>Assigned User</b></label>
                        <select class="selectpicker col-md-12" title="Select a user" data-style="form-control" name="user_id">
                            @foreach($hospital->users as $user)
                            <option value="{{$user->id}}">{{$user->firstname.' '.$user->lastname}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><b>Location</b></label>
                        <input type="text" class="form-control resetable" name="location">
                    </div>
                    <div class="form-group col-md-6">
                        <label><b>Contact Number</b></label>
                        <input type="tel" class="form-control resetable" name="phone_number">
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-4">
                <div class="row text-right">
                    <button type="submit" class="btn btn-purple" id="btn_submit">Save</button>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap4.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    
    <script>
        let units_table = generateExportDtbl('#units_table', 'No units for this department', 'Search for unit');
        let assets_table = generateExportDtbl('#assets_table', 'No equipment for this department', 'Search for equipment');

        $('#add_unit_form').on('submit', function(e){
            e.preventDefault();

            let btn = $('#btn_submit');
            let data = $(this).serialize() + '&department_id={{$department->id}}';

            submit_form('/api/units/add', "post", data, undefined, btn, true);
        });
    </script>

@endsection