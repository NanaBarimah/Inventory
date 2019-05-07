<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login | Inventory Management</title>

    <!--   Core JS Files   -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery.min.js') }}" defer></script>
    <script src="{{asset('js/popper.min.js')}}" defer></script>
    <script src="{{asset('js/bootstrap.min.js')}}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <!--link href="{{ asset('css/app.css') }}" rel="stylesheet"-->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/now-ui-dashboard.min.css?v=1.2.0')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/main.css')}}" />
</head>
<body>
<div class="wrapper">
        <div class="panel-header">
            <div class="header text-center">
                <h2 class="title">Inventory Management System</h2>
                <p class="category">&copy; 2018 Designed and Maintained By
                  <a target="_blank" href="http://codbitgh.com">Codbit Ghana Limited</a>
                </p>
            </div>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>
</body>
</html>
