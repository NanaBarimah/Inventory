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
            @include('layouts.navbar', ['page_title' => 'Inventory List'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-11 center">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="inline-block">Inventory List</h4>
                                @if(strtolower(Auth::user()->role) == 'admin' || strtolower(Auth::user()->role) == 'engineer' || strtolower(Auth::user()->role) == 'storekeeper')
                                <a href="/inventory/add" class="btn btn-purple pull-right">Add New</a>
                                @endif
                            </div>
                            <div class="card-body">
                                <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Serial No.</th>
                                            <th>Model No.</th>
                                            <th>Manufacturer</th>
                                            <th>Status</th>
                                            <th>Type</th>
                                            <th>Unit</th>
                                            <th>Department</th>
                                            <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Code</th>
                                            <th>Serial No.</th>
                                            <th>Model No.</th>
                                            <th>Manufacturer</th>
                                            <th>Status</th>
                                            <th>Type</th>
                                            <th>Unit</th> 
                                            <th>Department</th>
                                            <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($equipment as $item)
                                        <tr class="uppercase">
                                            <td>
                                                <a href="/inventory/{{$item->code}}">{{$item->code}}</a>
                                            </td>
                                            <td>{{$item->serial_number}}</td>
                                            <td>{{$item->model_number}}</td>
                                            <td>{{$item->manufacturer_name}}</td>
                                            <td>{{$item->status}}</td>
                                            <td>{{$item->category->name}}</td>
                                            <td>{{$item->unit->name}}</td>
                                            <td>{{$item->unit->department->name}}</td>
                                            <td class="text-right">
                                                @if(strtolower(Auth::user()->role) != 'hospital admin')
                                                <a href="/inventory/edit/{{$item->code}}" class="btn btn-round btn-info btn-icon btn-sm edit" data-toggle="tooltip" data-placement="left" title="Edit">
                                                    <i class="now-ui-icons design-2_ruler-pencil"></i>
                                                </a>
                                                @endif
                                                @if(strtolower(Auth::user()->role) != 'storekeeper')
                                                <a href="/maintenance/history/{{$item->code}}" class="btn btn-round btn-warning btn-icon btn-sm report" data-toggle="tooltip" data-placement="left" title="Maintenance History">
                                                    <i class="now-ui-icons business_chart-bar-32"></i>
                                                </a>
                                                @endif
                                                <!--a href="#" class="btn btn-round btn-purple btn-icon btn-sm report" data-toggle="tooltip" data-placement="left" title="Submit Report" disabled>
                                                    <i class="now-ui-icons ui-1_send"></i>
                                                </a-->
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
    <script>
        $(document).ready(function () {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });

            $('#datatable').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Find an item",
                }
            });

            var table = $('#datatable').DataTable();
        });
    </script>
</body>

</html>