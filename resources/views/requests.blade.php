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
            @include('layouts.navbar', ['page_title' => 'Requests List'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-11 center">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="inline-block">Requests List</h4>
                                @if(strtolower(Auth::user()->role) == 'admin')
                                <a href="/request-maintenance" class="btn btn-purple pull-right">Add New</a>
                                @endif
                            </div>
                            <div class="card-body">
                                <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Equipment Count</th>
                                            <th>Serial Numbers</th>
                                            <th>Maintenance Type</th>
                                            <th>Description</th>
                                            <th>Assigned To</th>
                                            <th>Status</th>
                                            <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Code</th>
                                            <th>Equipment Count</th>
                                            <th>Serial Numbers</th>
                                            <th>Maintenance Type</th>
                                            <th>Description</th>
                                            <th>Assigned To</th>
                                            <th>Status</th>
                                            <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($requests as $request)
                                        <tr class="uppercase">
                                            <td>
                                                <a href="javascript::void(0)">{{$request->id}}</a>
                                            </td>
                                            <td>{{$request->equipments->count()}}</td>
                                            <td>
                                            @foreach($request->equipments as $equipment)
                                                {{$equipment->serial_number}}, 
                                            @endforeach
                                            </td>
                                            <td>{{$request->maintenance_type}}</td>
                                            <td>{{$request->description}}</td>
                                            <td>{{$request->assigned_to == null ? "Not yet assigned" : $request->engineer->firstname.' '.$request->engineer->lastname}}</td>
                                            <td>{{$request->assigned_to == null ? "Pending" : "Assigned"}}</td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-round btn-purple btn-icon btn-sm report" data-toggle="tooltip" data-placement="left" title="Submit Report" disabled>
                                                    <i class="now-ui-icons ui-1_send"></i>
                                                </a>
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