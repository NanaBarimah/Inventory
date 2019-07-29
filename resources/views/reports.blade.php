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
                            <a class="nav-link" data-toggle="tab" href="#maintenance" id="pm_tab" role="tablist">
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
                                                            <h3 class="info-title" id="lead_pending"><i class="now-ui-icons arrows-1_refresh-69 spin"></i></h3>
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
                                                            <h3 class="info-title" id="lead_open"><i class="now-ui-icons arrows-1_refresh-69 spin"></i></h3>
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
                                                            <h3 class="info-title" id="lead_progress"><i class="now-ui-icons arrows-1_refresh-69 spin"></i></h3>
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
                                                            <h3 class="info-title" id="lead_hold"><i class="now-ui-icons arrows-1_refresh-69 spin"></i></h3>
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
                                                            <h3 class="info-title" id="lead_closed"><i class="now-ui-icons arrows-1_refresh-69 spin"></i></h3>
                                                            <h6 class="heading-title">Closed</h6>
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
                                                    <label>Type <span class="text-danger">*</span></label>
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
                                                    <label>Group by <span class="text-danger">*</span></label>
                                                    <select class="selectpicker col-md-12" data-style="form-control" title="Report type"
                                                    data-show-tick="true" name="group" id="wo_report_group" required>
                                                        <option value="status">Status</option>
                                                        <option value="department_id">Department</option>
                                                        <option value="unit_id">Unit</option>
                                                        <option value="approval">Approval</option>
                                                    </select>
                                                    <p class="refresh-picker pr-4 text-right">Reset</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12">
                                                <div class="form-group">
                                                    <label>Date Interval</label>
                                                    <select class="selectpicker col-md-12" data-style="form-control" title="Report type"
                                                    data-show-tick="true" name="interval" id="wo_report_date">
                                                        <option value="daily">Daily</option>
                                                        <option value="month">Monthly</option>
                                                        <option value="quarter">Quarterly</option>
                                                        <option value="year">Yearly</option>
                                                    </select>
                                                    <p class="refresh-picker pr-4 text-right">Reset</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12 custom" style="display:none;">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <input class="datepicker form-control" name="from" required disabled/>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12 custom" style="display:none;">
                                                <div class="form-group">
                                                    <label>End Date</label>
                                                    <input class="datepicker form-control" name="to" required disabled/>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12" class="date-control" id="year-picker" style="display:none;">
                                                <div class="form-group">
                                                    <label>Select year</label>
                                                    <select class="selectpicker col-sm-12 resetable-select" data-style="form-control" title="Select year"
                                                    data-live-search="true" data-show-tick="true" name="date" required disabled>
                                                        <option disabled><i>Please wait...</i></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12" class="date-control" id="month-picker" style="display:none;">
                                                <div class="form-group">
                                                    <label>Select month</label>
                                                    <select class="selectpicker col-sm-12 resetable-select" data-style="form-control" title="Select month"
                                                    data-live-search="true" data-show-tick="true" name="date" required disabled>
                                                        <option disabled><i>Please wait...</i></option>
                                                    </select>
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
                                    <div class="col-sm-12" id="wo_report_notes">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="maintenance">
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
                                                            <h3 class="info-title" id="maintenance_pending">N/A</h3>
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
                                                            <h3 class="info-title" id="maintenance_accepted">N/A</h3>
                                                            <h6 class="heading-title">Accepted</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <h6>Filter</h6>
                                    <form id="work_order_report">
                                        <div class="row">
                                            <div class="col-md-2 col-sm-12">
                                                <div class="form-group">
                                                    <label>Date Interval</label>
                                                    <select class="selectpicker col-md-12" data-style="form-control" title="Report type"
                                                    data-show-tick="true" name="interval" id="wo_report_date">
                                                        <option value="daily">Daily</option>
                                                        <option value="month">Monthly</option>
                                                        <option value="quarter">Quarterly</option>
                                                        <option value="year">Yearly</option>
                                                    </select>
                                                    <p class="refresh-picker pr-4 text-right">Reset</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12 custom-pm" style="display:none;">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <input class="datepicker form-control" name="from" required disabled/>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12 custom-pm" style="display:none;">
                                                <div class="form-group">
                                                    <label>End Date</label>
                                                    <input class="datepicker form-control" name="to" required disabled/>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12" class="date-control" id="year-picker-pm" style="display:none;">
                                                <div class="form-group">
                                                    <label>Select year</label>
                                                    <select class="selectpicker col-sm-12 resetable-select" data-style="form-control" title="Select year"
                                                    data-live-search="true" data-show-tick="true" name="date" required disabled>
                                                        <option disabled><i>Please wait...</i></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-12" class="date-control" id="month-picker-pm" style="display:none;">
                                                <div class="form-group">
                                                    <label>Select month</label>
                                                    <select class="selectpicker col-sm-12 resetable-select" data-style="form-control" title="Select month"
                                                    data-live-search="true" data-show-tick="true" name="date" required disabled>
                                                        <option disabled><i>Please wait...</i></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 mt-2 pt-1">
                                                <button type="submit" class="btn btn-round btn-purple"><b>Go</b></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row mb-3">

                            </div>
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
    let hasLoadedPmDates = false;

    $("#work_order_report").on("submit", function(e){
        e.preventDefault();
        let url, label;
        let group = $("#wo_report_group").val();
        
        if(group == "status"){
            url = "/api/reports/work-orders/status";
            label = "status";
        }else if(group == "department_id"){
            url = "/api/reports/work-orders/department";
            label = "department"
        }else if(group == "unit_id"){
            url = "/api/reports/work-orders/unit";
            label = "unit"
        }else if(group == "approval"){
            url = "/api/reports/work-orders/approval";
            label = "unit";
        }
        
        let data = $(this).serialize();
        const type = $(this).find('[name=type]').val();
        let btn = $(this).find("[type=submit]");
        
        const inital = btn.html();
        btn.prop("disabled", true);

        $.ajax({
            'url' : url,
            'method' : "get",
            "data" : data,
            success : (data) => {
                loadColumnGraph('wo-chart', data.labels, data.datasets, "Work orders", "Work order reports");
                let total;

                total = data.total;
                
                if(label == "status" && type == "count"){
                    let pending = data.datasets[4].data.reduce((a, b) => a + b, 0);
                    let open = data.datasets[3].data.reduce((a, b) => a + b, 0);
                    let progress = data.datasets[2].data.reduce((a, b) => a + b, 0);
                    let hold = data.datasets[1].data.reduce((a, b) => a + b, 0);
                    let closed = data.datasets[0].data.reduce((a, b) => a + b, 0);
                    
                    total = pending + open + progress + hold + closed;

                    $("#lead_pending").html(pending);
                    $("#lead_open").html(open);
                    $("#lead_progress").html(progress);
                    $("#lead_hold").html(hold);
                    $("#lead_closed").html(closed);
                }

                $("#wo_report_notes").html(`<p><b>${data.type} Work order report</b> for <b>${data.timespan}</b> grouped by <b>${label}</b>.</p>
                `);

                btn.prop("disabled", false);
            },
            error: (xhr) => {  
                btn.prop("disabled", false);
            }
        });
    });

    $(document).ready(function(){
        loadMonths();
        loadYears(); 

        $.ajax({
            'url' : "/api/reports/work-orders/index",
            'method' : "get",
            success : (data) => {
                loadColumnGraph('wo-chart', data.labels, data.datasets, "Work orders", "Work order reports");
                $("#lead_pending").html(data.datasets[0].data[0]);
                $("#lead_open").html(data.datasets[0].data[1]);
                $("#lead_progress").html(data.datasets[0].data[2]);
                $("#lead_hold").html(data.datasets[0].data[3]);
                $("#lead_closed").html(data.datasets[0].data[4]);

                const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                $("#wo_report_notes").html(`<p><b>Work order report</b> for <b>all time</b> grouped by <b>status</b>.</p>
                <p>Total number of work orders during this time period is <b>${total}</b></p>
                `);
            },
            error: (xhr) => {
                       
            }
        });
    });

    $("#wo_report_date").on("change", function(){
        $(".custom, #month-picker, #year-picker").css("display", "none");
        $("#month-picker, #year-picker").find("select").prop("disabled", true);
        $("#month-picker, #year-picker").find("select").val(null).selectpicker("refresh");
        $(".custom").find(".datepicker").val(null).prop("disabled", true);

        if($(this).val() == "daily"){
            $("#month-picker").find("select").prop("disabled", false);
            $("#month-picker").css("display", "block");
            $("#month-picker").find("select").val(null).selectpicker("refresh");
        }else if($(this).val() == "month" || $(this).val() == "quarter"){
            $("#year-picker").find("select").prop("disabled", false);
            $("#year-picker").find("select").val(null).selectpicker("refresh");
            $("#year-picker").css("display", "block");
        }else{
            $(".custom").css("display", "block");
            $(".custom").find(".datepicker").val(null).prop("disabled", false);
        }
    });

    const loadMonths = () => {
        const monthSelect = $("#month-picker").find("select");
        monthSelect.html(null);
        $.ajax({
            'url' : "/api/reports/get-months",
            'method' : "get",
            success : (data) => {

                data.forEach(function(element, index){
                    monthSelect.append(`<option>${element.month}</option>`);
                });

                monthSelect.selectpicker("refresh");
            },
            error: (xhr) => {
                       
            }
        });
    }

    const loadYears = () => {
        const yearSelect = $("#year-picker").find("select");
        yearSelect.html(null);
        $.ajax({
            'url' : "/api/reports/get-years",
            'method' : "get",
            success : (data) => {
                data.forEach(function(element, index){
                    yearSelect.append(`<option>${element.year}</option>`);
                });

                yearSelect.selectpicker("refresh");
            },
            error: (xhr) => {
                       
            }
        });
    }

    const loadPmMonths = () => {
        const monthSelect = $("#month-picker-pm").find("select");
        monthSelect.html(null);
        $.ajax({
            'url' : "/api/reports/get-pm-months",
            'method' : "get",
            success : (data) => {

                data.forEach(function(element, index){
                    monthSelect.append(`<option>${element.month}</option>`);
                });

                monthSelect.selectpicker("refresh");
            },
            error: (xhr) => {
                       
            }
        });
    }

    const loadPmYears = () => {
        const yearSelect = $("#year-picker-pm").find("select");
        yearSelect.html(null);
        $.ajax({
            'url' : "/api/reports/get-pm-years",
            'method' : "get",
            success : (data) => {
                data.forEach(function(element, index){
                    yearSelect.append(`<option>${element.year}</option>`);
                });

                yearSelect.selectpicker("refresh");
            },
            error: (xhr) => {
                       
            }
        });
    }

    $("#pm_tab").on("shown.bs.tab", function(){
        if(hasLoadedPmDates == true){
            loadPmMonths();
            loadPmYears();
        }
    })
</script>
@endsection