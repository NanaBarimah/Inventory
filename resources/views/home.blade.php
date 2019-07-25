@php
$auth_user = Auth::user();
$notifications = Auth::user()->unreadNotifications;
@endphp
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
    
    <!--   Core JS Files   -->
    <!--script src="{{ asset('js/app.js') }}" defer></script-->
    <script src="{{ asset('js/jquery.min.js') }}" defer></script>
    <script src="{{asset('js/popper.min.js')}}" defer></script>
    <script src="{{asset('js/bootstrap.min.js')}}" defer></script>
    <script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}" defer></script>
    <script src="{{asset('js/main.js')}}" defer></script>
    <script src="{{asset('js/now-ui-dashboard.min.js?v=1.2.0')}}" type="text/javascript" defer></script>

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
        <nav class="navbar navbar-expand-lg fixed-top navbar-transparent  bg-primary  navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-toggle">
                        <button type="button" class="navbar-toggler">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </button>
                    </div>
                    <span class="navbar-brand">Dashboard</span>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navigation">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown" id="notification-bell">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>@if($notifications->count() > 0)<span class="badge badge-danger notification-badge" id="notification-count">{{$notifications->count()}}</span>@endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="profileDropdown">
                            @if($notifications->count() > 0)
                                @foreach($notifications as $notification)
                                <a class="dropdown-item" href="{{$notification->data['action']}}">
                                    <div class="notification-item">
                                        <span class="notification-title">{{$notification->data['title']}}</span>
                                        <p class="notification-body">{{$notification->data['message']}}</p>
                                        <p class="notification-time">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</p>
                                    </div>
                                    </a>
                                @endforeach
                                <a class="dropdown-item notificati  on-view-all">View All Notifications</a>
                                @else
                                <i class="dropdown-item">No new notifications</i>
                            @endif
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="round" width="30" height="30" avatar="{{$auth_user->firstname}} {{$auth_user->lastname}}" />
                                <p>
                                    <span class="d-lg-none d-md-block">Profile</span>
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                                <a class="dropdown-item" href="/profile">My Profile</a>
                                <a class="dropdown-item" href="{{ route('logout') }}" 
                                    onclick="
                                                event.preventDefault();
                                                document.getElementById('logout-form').submit();
                                            ">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="panel-header dashboard-header">
            <div class="header text-center">
                <h3 class="title">Hi, {{$auth_user->firstname}} {{$auth_user->lastname}}</h3>
                <p class="subtitle">{{$auth_user->username}}</p>
            </div>
        </div>
        <div class="content">
            <div class="col-md-12 col-lg-12 row center overlap-30">
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <div class="row">
                        @if($auth_user->role == 'Admin' || $auth_user->role == 'Regular Technician' || $auth_user->role == 'Hospital Head')
                            <div class="col-md-4 col-sm-6">
                                <a href="/inventory" class="menu-item text-center">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="title">
                                                Equipment
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <img src="{{asset('img/laboratory.svg')}}" class="menu-img" />
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @if($auth_user->role == 'Admin' || $auth_user->role == 'Regular Technician' || $auth_user->role == 'Limited Technician')
                            <div class="col-md-4 col-sm-6">
                                <a href="/work-orders" class="menu-item text-center">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="title">
                                                Work Orders
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <img src="{{asset('img/construction.svg')}}" class="menu-img" />
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @if($auth_user->role == 'Admin' || $auth_user->role == 'Regular Technician' || $auth_user->role == 'Limited Technician' || $auth_user->role == 'View Only' || $auth_user->role == 'Hospital Head')
                            <div class="col-md-4 col-sm-6">
                                <a href="/requests" class="menu-item text-center">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="title">
                                                Requests
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <img src="{{asset('img/list.svg')}}" class="menu-img" />
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @if($auth_user->role == 'Admin' || $auth_user->role == 'Regular Technician' || $auth_user->role == 'Hospital Head')
                            <div class="col-md-4 col-sm-6">
                                <a href="/reports" class="menu-item text-center">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="title">
                                                Reports
                                            </h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <img src="{{asset('img/analysis.svg')}}" class="menu-img" />
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @if($auth_user->role == 'Admin')
                            <div class="col-md-4 col-sm-6">
                                <a href="/users" class="menu-item text-center">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="title">
                                                Users
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <img src="{{asset('img/users.svg')}}" class="menu-img" />
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @if($auth_user->role == 'Admin' || $auth_user->role == 'Regular Technician')
                            <div class="col-md-4 col-sm-6">
                                <a href="/schedule" class="menu-item text-center">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="title">
                                                View Schedule
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <img src="{{asset('img/calendar.svg')}}" class="menu-img" />
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @if($auth_user->role == 'Admin' || $auth_user->role == 'Regular Technician')
                    <div class="col-md-3 col-sm-12">
                        <div class="card gradient-background">
                            <div class="card-header">
                                <p class="title">
                                    Upcoming Maintenance
                                </p>
                            </div>
                            <div class="card-body">
                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <h6 class="text-muted">No scheduled maintenace available</h6>
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        </div>
    </div>
    </div>
</body>

</html>
