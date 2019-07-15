@extends('layouts.user-dashboard', ['page_title' => 'Reports'])
@section('styles')
<style>
.heading-title{
    font-weight: 600;
    font-size: 12px;
    text-transform: capitalize;
    color: #aaa;
}

#wo-chart{
    width: 100%;
    height: 500px;
}
</style>
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12 center">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">Reports</h4>
                    <ul class="nav nav-tabs nav-tabs-primary custom-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#wos" role="tablist">
                               Work order reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pms" role="tablist">
                                Preventive maintenances
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#equipment" role="tablist">
                                Equipment
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pos" role="tablist">
                                Purchase orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#technicians" role="tablist">
                                Technicians
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="wos">
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <div class="card card-stats">
                                        <div class="card-body ">
                                            <div class="statistics statistics-horizontal">
                                                <div class="info info-horizontal">
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <div class="icon icon-warning icon-circle">
                                                                <i class="fas fa-arrow-down"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-7 text-right">
                                                            <h3 class="info-title" id="downtime"><i class="now-ui-icons arrows-1_refresh-69 spin"></i></h3>
                                                            <h6 class="heading-title">Pending</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="card card-stats">
                                        <div class="card-body ">
                                            <div class="statistics statistics-horizontal">
                                                <div class="info info-horizontal">
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <div class="icon icon-info icon-circle">
                                                                <i class="fas fa-arrow-up"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-7 text-right">
                                                            <h3 class="info-title" id="uptime"><i class="now-ui-icons arrows-1_refresh-69 spin"></i></h3>
                                                            <h6 class="heading-title">Open</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
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
                                                            <h6 class="heading-title">Progress</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="card card-stats">
                                        <div class="card-body ">
                                            <div class="statistics statistics-horizontal">
                                                <div class="info info-horizontal">
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <div class="icon icon-primary icon-circle">
                                                                <i class="fas fa-arrow-up"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-7 text-right">
                                                            <h3 class="info-title" id="uptime"><i class="now-ui-icons arrows-1_refresh-69 spin"></i></h3>
                                                            <h6 class="heading-title">On hold</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="card card-stats">
                                        <div class="card-body ">
                                            <div class="statistics statistics-horizontal">
                                                <div class="info info-horizontal">
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <div class="icon icon-dark icon-circle">
                                                                <i class="fas fa-arrow-up"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-7 text-right">
                                                            <h3 class="info-title" id="uptime"><i class="now-ui-icons arrows-1_refresh-69 spin"></i></h3>
                                                            <h6 class="heading-title">Closed</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
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
                                                            <h6 class="heading-title">Approved</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <h6>Filter</h6>
                                    <form id="work_order_report">
                                        <div class="row">
                                            <div class="col-md-2 col-sm-12">
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select class="selectpicker col-md-12" data-style="form-control" title="Report type"
                                                    data-show-tick="true" name="type" required>
                                                        <option value="cost">Cost</option>
                                                        <option value="count">Count</option>
                                                    </select>
                                                <p class="refresh-picker pr-4 text-right">Reset</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12">
                                                <div class="form-group">
                                                    <label>Group by</label>
                                                    <select class="selectpicker col-md-12" data-style="form-control" title="Report type"
                                                    data-show-tick="true" name="group" id="wo_report_group" required>
                                                        <option value="status">Status</option>
                                                        <option value="department_id">Department</option>
                                                        <option value="unit_id">Unit</option>
                                                    </select>
                                                    <p class="refresh-picker pr-4 text-right">Reset</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12">
                                                <div class="form-group">
                                                    <label>Interval</label>
                                                    <select class="selectpicker col-md-12" data-style="form-control" title="Report type"
                                                    data-show-tick="true" name="interval" id="wo_report_group">
                                                        <option value="month">Month</option>
                                                        <option value="quarter">Quarter</option>
                                                        <option value="year">Year</option>
                                                    </select>
                                                    <p class="refresh-picker pr-4 text-right">Reset</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <input class="datepicker form-control" name="from" required/>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12">
                                                <div class="form-group">
                                                    <label>End Date</label>
                                                    <input class="datepicker form-control" name="to" required/>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 mt-2 pt-1">
                                                <button type="submit" class="btn btn-round btn-purple"><b>Go</b></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 col-sm-12">
                                    <h6 class="title">Report</h6>
                                    <div class="col-sm-12">
                                        <div id="wo-chart">
                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <h6 class="title">Report Notes</h6>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="pms">
                        
                        </div>
                        <div class="tab-pane" id="equipment">
                        
                        </div>
                        <div class="tab-pane" id="pos">
                        
                        </div>
                        <div class="tab-pane" id="technicians">
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('js/moment.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
<script src="{{asset('js/highcharts.js')}}"></script>
<script src="{{asset('js/highcharts-3d.js')}}"></script>
<script src="{{asset('js/highcharts-export.js')}}"></script>
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script src="{{asset('js/chart-options.js')}}"></script>
<script>
    demo.initDateTimePicker();

    $("#work_order_report").on("submit", function(e){
        e.preventDefault();
        let data = $(this).serialize();
        $.ajax({
            'url' : "/api/reports/work-orders/status",
            'method' : "get",
            "data" : data,
            success : (data) => {
                loadColumnGraph('wo-chart', data.labels, data.datasets, "Work orders", "Work order reports");
            },
            error: (xhr) => {
                       
            }
        })
    });

    $(document).ready(function(){
        
        $.ajax({
            'url' : "/api/reports/work-orders/index",
            'method' : "get",
            success : (data) => {
                loadColumnGraph('wo-chart', data.labels, data.datasets, "Work orders", "Work order reports");
            },
            error: (xhr) => {
                       
            }
        })
    });
</script>
@endsection