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
            @include('layouts.navbar', ['page_title' => 'New Maintenance Report'])
            <div class="panel-header panel-header-sm">
                <h3 class="title text-white text-center">Maintenance Timeline</h3>
            </div>
            <div class="content">
                <div class="header text-center">
                    <h3 class="title">Timeline</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-timeline card-plain">
                            <div class="card-body">
                                @if(sizeof($maintenances) < 1)
                                <h4 class="title text-muted text-center">No maintenances have been carried out on the specified inventory item</h4>
                                @endif
                                <ul class="timeline">
                                <?php $k = 0;?>
                                @foreach($maintenances as $maintenance)
                                <?php
                                    $colors = ['success', 'danger', 'info', 'warning'];
                                    $color = $colors[array_rand($colors)];
                                    $class="";
                                    if($k%2 == 0){
                                        $class="timeline-inverted";
                                    }
                                    $k++;
                                ?>
                                    <li class="{{$class}}">
                                        <div class="timeline-badge {{$color}}">
                                            <i class="now-ui-icons ui-1_settings-gear-63"></i>
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <span class="badge badge-{{$color}}">{{date('F j, Y', strtotime($maintenance->created_at))}}</span>
                                            </div>
                                            <div class="timeline-body">
                                                <h4>{{$maintenance->equipment_code}}</h4>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <h6>Action Taken</h6>
                                                        <p>{{$maintenance->action_taken}}</p>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <h6>Recommendations</h6>
                                                        <p>{{$maintenance->recommendation}}</p>
                                                    </div>
                                                </div>
                                                @if($maintenance->type!='Planned Maintenance')
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <h6>Equipment Down Time</h6>
                                                        <p>{{$maintenance->down_time}} <?php 
                                                            switch($maintenance->duration_units){
                                                                case 'h' : 
                                                                    echo 'Hour';
                                                                    break;
                                                                case 'd' :
                                                                    echo 'Day';
                                                                    break;
                                                                case 'm' :
                                                                    echo 'Month';
                                                                    break;
                                                                case 'y' :
                                                                    echo 'Year';
                                                                    break;
                                                                default:
                                                                    break;
                                                            }
                                                            if($maintenance->down_time > 1){
                                                                echo 's';
                                                            }
                                                        ?></p>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <h6>Reason For Down Time</h6>
                                                        <p>{{$maintenance->reason}}</p>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12">
                                                        <h6>Maintenance Cost</h6>
                                                        <p>GHS {{$maintenance->cost}}</p>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <h6>Maintenance Duration</h6>
                                                        <p>{{$maintenance->duration}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                </ul>
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
    <script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('js/now-ui-dashboard.min.js?v=1.2.0')}}" type="text/javascript"></script>
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
</body>

</html>