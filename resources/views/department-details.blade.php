@extends('layouts.user-dashboard', ['page_title' => $department->name])
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
                                                Assets
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#units" role="tablist">
                                                <i class="now-ui-icons business_bank"></i>
                                                Units
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#reports" role="tablist">
                                                <i class="now-ui-icons business_chart-bar-32"></i>
                                                Reports
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
                                            
                                        </div>
                                        <div class="tab-pane" id="reports">
                                            
                                        </div>
                                        <div class="tab-pane" id="assets">
                                            
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
                                                            <td><a href="javascript:void(0)">{{$unit->name}}</a></td>
                                                            <td>{{$unit->location != null ? $unit->location : 'N/A'}}</td>
                                                            <td>{{$unit->phone_number != null ? $unit->phone_number : 'N/A'}}</td>
                                                            <td>{{$unit->user != null ? $unit->user->name : 'N/A'}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="details">
                                            <div class="card-header text-center">
                                                
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
@endsection
@section('scripts')
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script>
        let units_table = generateDtbl('#units_table', 'No units for this department', 'Search for unit');
    </script>

@endsection