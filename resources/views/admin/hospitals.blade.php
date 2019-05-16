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
            @include('layouts.admin_navbar', ['page_title' => 'Hospitals'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-10 center">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="inline-block">Hospitals</h4>
                                @if(Auth::guard('admin')->user()->role == 'Admin')
                                    <a href="/admin/hospitals/add" class="btn btn-purple pull-right">Add New</a>
                                @endif
                            </div>
                            <div class="card-body">
                                <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Hospital Name</th>
                                            <th>District</th>
                                            <th>Address</th>
                                            <th>Contact</th>
                                            @if(Auth::guard('admin')->user()->role == 'Admin')
                                                <th class="disabled-sorting text-right">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Hospital Name</th>
                                            <th>District</th>
                                            <th>Address</th>
                                            <th>Contact</th>
                                            @if(Auth::guard('admin')->user()->role == 'Admin')
                                                <th class="disabled-sorting text-right">Actions</th>
                                            @endif
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($hospitals as $hospital)
                                        <tr>
                                            <td>
                                                <a href="/admin/hospitals/{{$hospital->id}}">{{$hospital->name}}</a>
                                            </td>
                                            <td>{{$hospital->district->name}}</td>
                                            <td>{{$hospital->address}}</td>
                                            <td>{{$hospital->contact_number}}</td>
                                            @if(Auth::guard('admin')->user()->role == 'Admin')
                                                <td class="text-right">
                                                    <a href="/admin/hospitals/edit/{{$hospital->id}}" class="btn btn-round btn-info btn-icon btn-sm edit">
                                                        <i class="now-ui-icons design-2_ruler-pencil"></i>
                                                    </a>
                                                </td>
                                            @endif
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
    @include('layouts.admin_core_scripts')
    <script src="{{asset('js/datatables.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Find a hospital",
                }

            });

            var table = $('#datatable').DataTable();

        });
    </script>
</body>

</html>