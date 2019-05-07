<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Inventory Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport'
    />
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <!-- Styles -->
    <!--link href="{{ asset('css/app.css') }}" rel="stylesheet"-->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/now-ui-dashboard.min.css?v=1.2.0')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/main.css')}}" />
</head>

<body>
    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="main-panel">
            @include('layouts.navbar', ['page_title' => 'View Reports'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-10 center">
                        <div class="card card-chart">
                            <div class="card-header text-center">
                                <h4 class="title">Reports</h4>
                                <h5 class="subtitle">Select a report type to view</h5>
                            </div>
                            <div class="card-body">
                                <form id="generate_graph">
                                <div class="row pull-right col-md-12 margin-bottom-10 form-area">
                                    <div class="col-md-3">
                                        <select class="selectpicker" data-style="btn btn-purple btn-round" id="report-type" required>
                                            <option selected disabled hidden>Type</option>
                                            <option value="inventory">Inventory Report</option>
                                            <option value="maintenance">Maintenance Report</option>
                                            <option value="cost">Cost Report</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="selectpicker" data-style="btn btn-purple btn-round" id="report-category" required>
                                            <option selected disabled hidden>Categorize By</option>
                                            <option value="month" id="categorize_by_month">Month</option>
                                            <option value="status" id="status">Status</option>
                                            <option value="equipment_type">Equipment Type</option>
                                            <option value="unit">Unit</option>
                                            <option value="department">Department</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3" id="div-year">
                                        <select class="selectpicker" data-style="btn btn-purple btn-round" name="year" id="report-year" required>
                                            <option selected disabled hidden>Year</option>
                                            @foreach($years as $year)
                                            <option value="{{$year->year}}">{{$year->year}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" value="{{Auth::user()->hospital_id}}" name="hospital_id"/>
                                    </div>
                                    <div class="col-md-3" style="margin-top:10px">
                                        <button type="submit" class="btn btn-primary btn-round btn-wd" style="width:100%"
                                            id="generate">Generate Graph</button>
                                        <p class="text-danger text-center hidden" style="font-size:11px">Select all
                                            possible
                                            options</p>
                                    </div>
                                </div>
                                </form>
                                <div class="chart-area">
                                    <div id="container" style="width:100%; height:auto;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
            @include('hospital-modal')
    
    <!--   Core JS Files   -->
    <!--script src="{{ asset('js/app.js') }}" defer></script-->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
    <script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('js/now-ui-dashboard.min.js?v=1.2.0')}}" type="text/javascript"></script>
    <script src="{{asset('js/highcharts.js')}}"></script>
    <script src="{{asset('js/highcharts-3d.js')}}"></script>
    <script src="{{asset('js/highcharts-export.js')}}"></script>
    <script>
        $('#generate_graph').on('submit', function (e) {
            e.preventDefault();

            if ($('#report-type').val() == null || $('#report-year').val() == null || $('#report-category').val() == null) {
                $('.text-danger').css('display', 'block');
                return false;
            }else{
                $('.text-danger').css('display', 'none');
                $('#generate').html('Loading...');
                var form_data = $(this).serialize();
                if($('#report-type').val()=='inventory'){
                    if($('#report-category').val() == 'status'){
                        $.ajax({
                            url : '/api/equipment/report/cummulative',
                            method: 'post',
                            data : form_data,
                            success: function(data, status){
                                $('#generate').html('Generate Graph');
                                console.log(data);
                                options = {
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        type: 'pie',
                                    },
                                    title: {
                                        text: 'Active/Inactive Equipment'
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            showInLegend : true,
                                            dataLabels: {
                                                enabled: true,
                                                format: '<b style="text-transform: uppercase">{point.name}</b>: {point.percentage:.1f} %',
                                                style: {
                                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                }
                                            }
                                        }
                                    },
                                    series: [{
                                        name: 'Inventory',
                                        colorByPoint: true,
                                        data: data.response
                                    }],
                                    exporting: {
                                        filename: 'active_inactive_'+new Date()
                                    }
                                };
                                loadGraph(options);
                            },
                            error: function(xhr, desc, err){
                                $('#generate').html('Generate Graph');
                                console.log(desc);
                            }
                        })
                    }else if($('#report-category').val()=='equipment_type'){
                        $.ajax({
                            url : '/api/equipment/report/categorized',
                            method: 'post',
                            data: form_data,
                            success: function(data, status){
                                $('#generate').html('Generate Graph');
                                console.log(data);
                                
                                //declaring various arrays to sort data for graph
                                categories = [];
                                actives = [];
                                inactives = [];
                                
                                //pushing the category names into one array
                                data.response.forEach(function(item, index){
                                    categories.push(item['category']);
                                });
            
                                //filtering category array to remove duplicates
                                categories = unique(categories);

                                //sorting active and inactive equipment into different arrays
                                actives = sortActive(data.response, categories);
                                inactives = sortInactive(data.response, categories);

                                //defining chart options
                                options = {
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        type: 'column'
                                    },
                                    title: {
                                        text: 'Equipment By Type'
                                    },
                                    xAxis: {
                                        categories: categories,
                                        crosshair: true
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Units'
                                        }
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.y}</b>'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                format: '<b style="text-transform: uppercase">{point.name}</b>: {point.y}',
                                                style: {
                                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                }
                                            }
                                        }
                                    },
                                    plotOptions: {
                                        column: {
                                            pointPadding: 0.2,
                                            borderWidth: 0
                                        }
                                    },
                                    series : [{
                                        name: 'Active',
                                        data: actives
                                    }, {
                                        name: 'Inactive',
                                        data: inactives
                                    }],
                                    exporting: {
                                        filename: 'equipment_type_'+new Date()
                                    }
                                };
                                loadGraph(options);
                            },
                            error: function(xhr, desc, err){
                                $('#generate').html('Generate Graph');
                            }
                        });
                    }else if($('#report-category').val()=='unit'){
                        $.ajax({
                            url : '/api/equipment/report/unit',
                            method : 'post',
                            data : form_data,
                            success: function(data, status){
                                $('#generate').html('Generate Graph');
                                units = [];
                                categories = [];
                                
                                var response = data.response;

                                response.forEach(function(item, index){
                                    units.push(item['unit']);
                                    categories.push(item['category']);
                                });


                                units = unique(units);
                                categories = unique(categories);

                                objects = [];

                                categories.forEach(function(item, index){
                                    var category_name = item;
                                    data = [];

                                    units.forEach(function(item, index){
                                        isAvailable = false;
                                        unit_name = item;

                                        response.forEach(function(item, index){
                                            if(item['unit'] == unit_name && item['category'] == category_name){
                                                isAvailable = true;
                                                data.push(item['total']);
                                            }
                                        });

                                        if(!isAvailable){
                                            data.push(0);
                                        }
                                    });
                                    var obj  = {
                                        name : category_name,
                                        data : data
                                    };

                                    objects.push(obj);
                                });

                                options = {
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        type: 'column'
                                    },
                                    title: {
                                        text: 'Equipment Per Unit'
                                    },
                                    xAxis: {
                                        categories: units,
                                        crosshair: true
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Units'
                                        }
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.y}</b>'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                format: '<b style="text-transform: uppercase">{point.name}</b>: {point.y}',
                                                style: {
                                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                }
                                            }
                                        }
                                    },
                                    plotOptions: {
                                        column: {
                                            pointPadding: 0.2,
                                            borderWidth: 0
                                        }
                                    },
                                    series : objects,
                                    
                                    exporting: {
                                        filename: 'equipment_unit_'+new Date()
                                    }
                                };
                                loadGraph(options);
                            },
                            error: function(xhr, err, desc){
                                $('#generate').html('Generate Graph');
                            }
                        })
                    }else if($('#report-category').val()=='department'){
                        $.ajax({
                            url : '/api/equipment/report/department',
                            method : 'post',
                            data : form_data,
                            success: function(data, status){
                                $('#generate').html('Generate Graph');
                                departments = [];
                                categories = [];
                                
                                var response = data.response;

                                response.forEach(function(item, index){
                                    departments.push(item['department']);
                                    categories.push(item['category']);
                                });


                                departments = unique(departments);
                                categories = unique(categories);

                                objects = [];

                                categories.forEach(function(item, index){
                                    var category_name = item;
                                    data = [];

                                    departments.forEach(function(item, index){
                                        isAvailable = false;
                                        department_name = item;

                                        response.forEach(function(item, index){
                                            if(item['department'] == department_name && item['category'] == category_name){
                                                isAvailable = true;
                                                data.push(item['total']);
                                            }
                                        });

                                        if(!isAvailable){
                                            data.push(0);
                                        }
                                    });
                                    var obj  = {
                                        name : category_name,
                                        data : data
                                    };

                                    objects.push(obj);
                                });
                                options = {
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        type: 'column'
                                    },
                                    title: {
                                        text: 'Equipment Per Department'
                                    },
                                    xAxis: {
                                        categories: departments,
                                        crosshair: true
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Units'
                                        }
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.y}</b>'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                format: '<b style="text-transform: uppercase">{point.name}</b>: {point.y}',
                                                style: {
                                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                }
                                            }
                                        }
                                    },
                                    plotOptions: {
                                        column: {
                                            pointPadding: 0.2,
                                            borderWidth: 0
                                        }
                                    },
                                    series : objects,
                                    exporting: {
                                        filename: 'equipment_department_'+new Date()
                                    }
                                };
                                loadGraph(options);
                            },
                            error: function(xhr, err, desc){
                                $('#generate').html('Generate Graph');
                            }
                        })
                    }
                }else if($('#report-type').val()=='maintenance'){
                    if($('#report-category').val()=='month'){
                        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                        request = $.ajax({
                            url : '/api/maintenances/report/cummulative',
                            method : 'post',
                            data : form_data,
                            success: function(data, status){
                                console.log(data);
                                var formatted_counts = [];
                                $('#generate').html('Generate Graph');
                                months.forEach(function(item, index){
                                    var month = item;
                                    var month_index = index;

                                    var isFound = false;
                                    data.response.forEach(function(item, index){
                                        if(item.month == month_index + 1){
                                            isFound = true;
                                            formatted_counts.push(item.maintenances);
                                        }
                                    });

                                    if(!isFound){
                                        formatted_counts.push(0);
                                    }
                                });
                                
                                var options = {
                                        title: {
                                            text: 'Annual Maintenance Report'
                                        },

                                        subtitle: {
                                            text: 'Year '+$('#report-year').val()
                                        },

                                        yAxis: {
                                            title: {
                                                text: 'Maintenance Frequency'
                                            }
                                        },
                                        legend: {
                                            layout: 'vertical',
                                            align: 'right',
                                            verticalAlign: 'middle'
                                        },

                                        xAxis: {
                                        categories: months,
                                        crosshair: true
                                        },

                                        series: [{
                                                name: $('#report-year').val(),
                                                data: formatted_counts
                                            }
                                        ],

                                        responsive: {
                                            rules: [{
                                                condition: {
                                                    maxWidth: 500
                                                },
                                                chartOptions: {
                                                    legend: {
                                                        layout: 'horizontal',
                                                        align: 'center',
                                                        verticalAlign: 'bottom'
                                                    }
                                                }
                                            }]
                                        },
                                        exporting: {
                                            filename: 'annual_maintenance_'+new Date()
                                        }
                                }
                                loadGraph(options);
                            },
                            error : function(xhr, desc, err){
                                $('#generate').html('Generate Graph');
                            }
                        });
                    }else if($('#report-category').val()=='equipment_type'){
                        request = $.ajax({
                            url : '/api/maintenances/report/categorized',
                            method : 'post',
                            data : form_data,
                            success: function(data, status){
                                $('#generate').html('Generate Graph');
                                options = {
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        type: 'pie'
                                    },
                                    title: {
                                        text: 'Maintenance Report By Equipment Type for '+$('#report-year').val()
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.y}</b>'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.percentage:.1f} %',
                                                style: {
                                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                }
                                            },
                                            showInLegend: true
                                        }
                                    },
                                    series: [{
                                        name: 'Maintenances',
                                        colorByPoint: true,
                                        data: data.response
                                    }],
                                    events: {
                                        load: function(event) {
                                            var total = 0; // get total of data
                                            for (var i = 0, len = this.series[0].y.length; i < len; i++) {
                                                total += this.series[0].y[i];
                                            }
                                            var text = this.renderer.text(
                                                'Total: ' + total,
                                                this.plotLeft,
                                                this.plotTop - 20
                                            ).attr({
                                                zIndex: 5
                                            }).add() // write it to the upper left hand corner
                                        }
                                    },
                                    exporting: {
                                        filename: 'maintenance_equipment_type_'+new Date()
                                    }
                                };
                                loadGraph(options);
                            },
                            error : function(xhr, desc, err){
                                $('#generate').html('Generate Graph');
                            }
                        });
                    }else if($('#report-category').val()=='unit'){
                        request = $.ajax({
                            url : '/api/maintenances/report/unit',
                            method : 'post',
                            data : form_data,
                            success: function(data, status){
                                $('#generate').html('Generate Graph');
                                options = {
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        type: 'pie'
                                    },
                                    title: {
                                        text: 'Maintenance Report By Unit for '+$('#report-year').val()
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.y}</b>'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.percentage:.1f} %',
                                                style: {
                                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                }
                                            },
                                            showInLegend: true
                                        }
                                    },
                                    series: [{
                                        name: 'Maintenances',
                                        colorByPoint: true,
                                        data: data.response
                                    }],
                                    events: {
                                        load: function(event) {
                                            var total = 0; // get total of data
                                            for (var i = 0, len = this.series[0].y.length; i < len; i++) {
                                                total += this.series[0].y[i];
                                            }
                                            var text = this.renderer.text(
                                                'Total: ' + total,
                                                this.plotLeft,
                                                this.plotTop - 20
                                            ).attr({
                                                zIndex: 5
                                            }).add() // write it to the upper left hand corner
                                        }
                                    },
                                    exporting: {
                                        filename: 'maintenance_unit_'+new Date()
                                    }
                                };
                                loadGraph(options);
                            },
                            error : function(xhr, desc, err){
                                $('#generate').html('Generate Graph');
                            }
                        });
                    }else if($('#report-category').val()=='department'){
                        request = $.ajax({
                            url : '/api/maintenances/report/department',
                            method : 'post',
                            data : form_data,
                            success: function(data, status){
                                $('#generate').html('Generate Graph');
                                options = {
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        type: 'pie'
                                    },
                                    title: {
                                        text: 'Maintenance Report By Department for '+$('#report-year').val()
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.y}</b>'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.percentage:.1f} %',
                                                style: {
                                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                }
                                            },
                                            showInLegend: true
                                        }
                                    },
                                    series: [{
                                        name: 'Maintenances',
                                        colorByPoint: true,
                                        data: data.response
                                    }],
                                    events: {
                                        load: function(event) {
                                            var total = 0; // get total of data
                                            for (var i = 0, len = this.series[0].y.length; i < len; i++) {
                                                total += this.series[0].y[i];
                                            }
                                            var text = this.renderer.text(
                                                'Total: ' + total,
                                                this.plotLeft,
                                                this.plotTop - 20
                                            ).attr({
                                                zIndex: 5
                                            }).add() // write it to the upper left hand corner
                                        }
                                    },
                                    exporting: {
                                        filename: 'maintenance_department_'+new Date()
                                    }
                                };
                                loadGraph(options);
                            },
                            error : function(xhr, desc, err){
                                $('#generate').html('Generate Graph');
                            }
                        });
                    }
                }else if($('#report-type').val()=='cost'){
                    if($('#report-category').val()=='month'){
                        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                        request = $.ajax({
                            url : '/api/maintenances/report/cost/month',
                            method : 'post',
                            data : form_data,
                            success: function(data, status){
                                var formatted_counts = [];
                                $('#generate').html('Generate Graph');
                                months.forEach(function(item, index){
                                    var month = item;
                                    var month_index = index;

                                    var isFound = false;
                                    data.response.forEach(function(item, index){
                                        if(item.month == month_index + 1){
                                            isFound = true;
                                            formatted_counts.push(item.total);
                                        }
                                    });

                                    if(!isFound){
                                        formatted_counts.push(0);
                                    }
                                });
                                
                                var options = {
                                        title: {
                                            text: 'Maintenance Cost Report'
                                        },

                                        subtitle: {
                                            text: 'Year '+$('#report-year').val()
                                        },

                                        yAxis: {
                                            title: {
                                                text: 'Cost (GHS)'
                                            }
                                        },
                                        legend: {
                                            layout: 'vertical',
                                            align: 'right',
                                            verticalAlign: 'middle'
                                        },

                                        xAxis: {
                                            title: {
                                                text: 'Month'
                                            },
                                        categories: months,
                                        crosshair: true
                                        },

                                        series: [{
                                                name: $('#report-year').val(),
                                                data: formatted_counts
                                            }
                                        ],

                                        responsive: {
                                            rules: [{
                                                condition: {
                                                    maxWidth: 500
                                                },
                                                chartOptions: {
                                                    legend: {
                                                        layout: 'horizontal',
                                                        align: 'center',
                                                        verticalAlign: 'bottom'
                                                    }
                                                }
                                            }]
                                        },
                                    exporting: {
                                        filename: 'cost_'+new Date()
                                    }
                                }
                                loadGraph(options);
                            },
                            error : function(xhr, desc, err){
                                $('#generate').html('Generate Graph');
                            }
                        });
                    }else if($('#report-category').val()=='equipment_type'){
                        $.ajax({
                            url : '/api/maintenances/report/cost/type',
                            method: 'post',
                            data: form_data,
                            success: function(data, status){
                                $('#generate').html('Generate Graph');
                                console.log(data);
                                //declaring various arrays to sort data for graph
                                categories = [];
                                values = [];
                                
                                //pushing the category names into one array
                                data.response.forEach(function(item, index){
                                    categories.push(item['category']);
                                    values.push(item['total']);
                                });
            
                                //defining chart options
                                options = {
                                    chart: {
                                        type: 'column',
                                        options3d: {
                                            enabled: true,
                                            alpha: 10,
                                            beta: 25,
                                            depth: 50,
                                            viewDistance: 30
                                        }
                                    },
                                    title: {
                                        text: 'Maintenance Cost By Type'
                                    },
                                    xAxis: {
                                        categories: categories
                                    },
                                    yAxis: {
                                        title: {
                                            text: null
                                        }
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.y}</b>'
                                    },
                                    plotOptions: {
                                        column: {
                                            depth: 25
                                        }
                                    },
                                    series : [{
                                        name: 'Cost (GHS)',
                                        data: values
                                    }],
                                    exporting: {
                                        filename: 'cost_type_'+new Date()
                                    }
                                };
                                
                                loadGraph(options);
                            },
                            error: function(xhr, desc, err){
                                $('#generate').html('Generate Graph');
                            }
                        });
                    }else if($('#report-category').val()=='unit'){
                        $.ajax({
                            url : '/api/maintenances/report/cost/unit',
                            method: 'post',
                            data : form_data,
                            success: function(data, status){
                                $('#generate').html('Generate Graph');
                                console.log(data);
                                options = {
                                    chart: {
                                        type: 'pie',
                                            options3d: {
                                                enabled: true,
                                                alpha: 45,
                                                beta: 0
                                            }
                                    },
                                    title: {
                                        text: 'Maintenance Cost Per Unit'
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: {point.y} GHS (<b>{point.percentage:.1f}%</b>)'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            depth: 35,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.name}'
                                            }
                                        }
                                    },
                                    series: [{
                                        name: 'Expenditure',
                                        colorByPoint: true,
                                        data: data.response
                                    }],
                                    exporting: {
                                        filename: 'cost_unit_'+new Date()
                                    }
                                };
                                loadGraph(options);
                            },
                            error: function(xhr, desc, err){
                                $('#generate').html('Generate Graph');
                                console.log(desc);
                            }
                        });
                    }else if($('#report-category').val()=='department'){
                        $.ajax({
                            url : '/api/maintenances/report/cost/department',
                            method: 'post',
                            data : form_data,
                            success: function(data, status){
                                $('#generate').html('Generate Graph');
                                console.log(data);
                                options = {
                                    chart: {
                                        type: 'pie',
                                            options3d: {
                                                enabled: true,
                                                alpha: 45,
                                                beta: 0
                                            }
                                    },
                                    title: {
                                        text: 'Maintenance Cost Per Department'
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: {point.y} GHS (<b>{point.percentage:.1f}%</b>)'
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            innerSize: 100,
                                            depth: 35,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.name}'
                                            }
                                        }
                                    },
                                    series: [{
                                        name: 'Expenditure',
                                        colorByPoint: true,
                                        data: data.response
                                    }],
                                    exporting: {
                                        filename: 'cost_department_'+new Date()
                                    }
                                };
                                loadGraph(options);
                            },
                            error: function(xhr, desc, err){
                                $('#generate').html('Generate Graph');
                                console.log(desc);
                            }
                        });
                    }
                }
            }
        });

        $('#report-type').on('change', function () {
            if ($('#report-type').val() == "inventory") {
                if($('#report-category').val() == 'month'){
                    $('#report-category').selectpicker('refresh');
                }
                $('#status').prop('disabled', false);
                $('#categorize_by_month').prop('disabled', true);
            }else{
                $('#categorize_by_month').prop('disabled', false);
                $('#status').prop('disabled', true);
            } 
        });


        function loadGraph(options) {
            Highcharts.chart('container', options);
        }

        function unique(a) {
            var prims = {"boolean":{}, "number":{}, "string":{}}, objs = [];

            return a.filter(function(item) {
                var type = typeof item;
                if(type in prims)
                    return prims[type].hasOwnProperty(item) ? false : (prims[type][item] = true);
                else
                    return objs.indexOf(item) >= 0 ? false : objs.push(item);
            });
        }

        function sortActive(main_array, categorized_array){
            var active_values = []
            for(var i = 0; i < categorized_array.length; i++){
                var hasFound = false;

                for(var k = 0; k < main_array.length; k++){
                    if((categorized_array[i] == main_array[k].category) && main_array[k].status == 'active'){
                        hasFound = true;
                        active_values.push(main_array[k].total);
                        break;
                    } 
                }

                if(!hasFound){
                    active_values.push(0);
                }
            }

            return active_values;
        }

        function sortInactive(main_array, categorized_array){
            var inactive_values = []
            for(var i = 0; i < categorized_array.length; i++){
                var hasFound = false;

                for(var k = 0; k < main_array.length; k++){
                    if((categorized_array[i] == main_array[k].category) && main_array[k].status == 'inactive'){
                        hasFound = true;
                        inactive_values.push(main_array[k].total);
                        break;
                    } 
                }

                if(!hasFound){
                    inactive_values.push(0);
                }
            }

            return inactive_values;
        }
    </script>
</body>

</html>