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
    <style>
        .form-group p{
            font-weight: bold;
            font-size: 16px;
        }

        #qrcode img{
            display: block;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="main-panel">
            @include('layouts.navbar', ['page_title' => 'Inventory List'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-11 center">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="inline-block">{{$equipment->code}}</h4>
                                @if(strtolower(Auth::user()->role) != 'hospital admin')
                                <a href="/inventory/edit/{{$equipment->code}}" class="btn btn-purple pull-right btn-round">Edit</a>
                                @endif
                                <a href="/maintenance/history/{{$equipment->code}}" class="btn btn-purple pull-right btn-round">Maintenance History</a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 pr-1">
                                        <div class="form-group">
                                            <label>Equipment Code</label>
                                            <p>{{$equipment->code}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-1">
                                        <div class="form-group">
                                            <label>Serial Number</label>
                                            <p>{{$equipment->serial_number}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-1">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <p>{{$equipment->status}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pr-1">
                                        <div class="form-group">
                                            <label>Manufacturer</label>
                                            <p>{{$equipment->manufacturer_name}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-1">
                                        <div class="form-group">
                                            <label>Model Number</label>
                                            <p>{{$equipment->model_number}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-1">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <p>{{$equipment->category->name}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pr-1">
                                        <div class="form-group">
                                            <label>Unit</label>
                                            <p>{{$equipment->unit->name}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-1">
                                        <div class="form-group">
                                            <label>Location</label>
                                            <p>{{$equipment->location}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-1">
                                        <div class="form-group">
                                            <label>Year Of Purchase</label>
                                            <p>{{$equipment->year_of_purchase}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pr-1">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <p>{{$equipment->description}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-1">
                                        <div class="form-group">
                                            <label>Service Vendor</label>
                                            <p>{{$equipment->service_vendor->name}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-1">
                                        <div class="form-group">
                                            <label>Cost</label>
                                            <p>GH&cent; {{$equipment->equipment_cost}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pr-1">
                                        <div class="form-group">
                                            <label>Installation Date</label>
                                            <p>{{date('D, d M Y', strtotime($equipment->installation_time))}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-1">
                                        <div class="form-group">
                                            <label>Possible Replacement Date</label>
                                            <p>{{date('D, d M Y', strtotime($equipment->pos_rep_date))}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary pull-right" style="margin-bottom: 12px" onclick="viewQr()">View QR Code</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="col-md-11">
                                        <div id="qrcode"></div>
                                        <button class="btn btn-block" onclick="printContent('qrcode')">Print</button>
                                    </div>
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
    <script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('js/now-ui-dashboard.min.js?v=1.2.0')}}" type="text/javascript"></script>
    <script src="{{asset('js/qrcode.min.js')}}" type="text/javascript"></script>
    
    <script type="text/javascript">
        $(document).ready(function(){
            if($('#qrcode').html() == ''){
                qr = new QRCode(document.getElementById("qrcode"), "{{$equipment->code}}");
            }
        });
        function viewQr(){
            $('#qrModal').modal('show');
        }

        function printContent(el){
            var restorepage = $('body').html();
            var printcontent = $('#' + el).clone();
            $('body').empty().html(printcontent);
            window.print();
            window.location.reload();
        }
    </script>

</body>

</html>