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
            @include('layouts.admin_navbar', ['page_title' => 'Maintenance Requests'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-10 center">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="inline-block">Maintenance Requests</h4>
                            </div>
                            <div class="card-body">
                            <table id="datatable" class="table table-striped table-bordered col-md-11"
                                                    cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Equipment Code</th>
                                                            <th>Hospital</th>
                                                            <th>Job Number</th>
                                                            <th>Status</th>
                                                            <th>Scheduled Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Equipment Code</th>
                                                            <th>Hospital</th>
                                                            <th>Job Number</th>
                                                            <th>Type</th>
                                                            <th>Scheduled Date</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        @foreach($requests as $request)
                                                            @foreach($request->equipments as $equipment)
                                                                <tr>
                                                                    <td><a href="{{route('request.maintenance', ['equipment' => $equipment->code, 'job' => $request->id])}}">
                                                                    {{$equipment->code}}</a>
                                                                    </td>
                                                                    <td>{{$equipment->hospital->name}}</td>
                                                                    <td>{{$request->id}}</td>
                                                                    <td>{{$request->maintenance_type}}</td>
                                                                    <td>{{date('D d M, Y', strtotime($request->scheduled_for))}}</td>
                                                                </tr>
                                                            @endforeach
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
    @include('layouts.admin_core_scripts')
    <script src="{{asset('js/datatables.js')}}"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[ 4, "desc" ]],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Find a hospital",
                }

            });

            var table = $('#datatable').DataTable();


             demo.initDateTimePicker();

        });
    </script>
</body>

</html>