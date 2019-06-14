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
                                            <a class="nav-link" data-toggle="tab" href="#reports" role="tablist">
                                                <i class="now-ui-icons business_chart-bar-32"></i>
                                                Reports
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#units" role="tablist">
                                                <i class="now-ui-icons business_bank"></i>
                                                Units
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#users" role="tablist">
                                                <i class="now-ui-icons users_single-02"></i>
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
                                        <div class="tab-pane" id="users">
                                            
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