<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Inventory Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <!--link href="{{ asset('css/app.css') }}" rel="stylesheet"-->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/now-ui-dashboard.min.css?v=1.2.0')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/main.css')}}" />
</head>

<body>
    <div class="wrapper ">
        @include('layouts.admin_sidebar')
        <div class="main-panel">
            @include('layouts.admin_navbar', ['page_title' => $donation->title])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="col-md-12 mr-auto ml-auto">
                    <div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    {{$donation->title}}
                                </h3>
                            </div>
                            <div class="card-body">
                                <div>
                                    <div class="row justify-content-center">
                                        <div class="col-md-9 col-sm-12">
                                            <div class="row">
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label><b>Donation Title</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <p>{{$donation->title}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label><b>Hospital</b> <span class="text-danger">*</span></label>
                                                    <p>{{$donation->hospital->name}}</p>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label><b>Date Donated</b> <span class="text-danger">*</span></label>
                                                    <p>{{date('jS F, Y', strtotime($donation->date_donated))}}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label><b>Presented To</b></label>
                                                    <p>{{$donation->presented_to == null ? 'N/A' : $donation->presented_to}}</p>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label><b>Presented By</b> <span class="text-danger">*</span></label>
                                                    <p>{{$donation->presented_by == null ? 'N/A' : $donation->presented_by}}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-12">
                                                    <label><b>Description</b></label>
                                                    <p>{{$donation->description}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="row">
                                                <h6 class="title">Equipment</h6>
                                                <div class="col-sm-12">
                                                    <ul>
                                                    @foreach($donation->equipment as $eq)
                                                        <li><a href="/admin/equipment/{{$eq->id}}">{{$eq->name}}</a></li>
                                                    @endforeach
                                                    </ul>
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
    </div>
    @include('layouts.admin_core_scripts')
</body>

</html>