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
            @include('layouts.admin_navbar', ['page_title' => 'Equipment'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="col-md-12 center">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="inline-block">Equipment</h4>
                        </div>
                        <div class="card-body">
                            <table id="equipment_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Equipment Name</th>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Serial No.</th>
                                        <th>Model No.</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Equipment Name</th>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Serial No.</th>
                                        <th>Model No.</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($equipment as $eq)
                                    <tr>
                                        <td><a href="/admin/equipment/{{$eq->id}}">{{$eq->name}}</a></td>
                                        <td>{{$eq->equipment_code}}</td>
                                        <td>{{$eq->type}}</td>
                                        <td>{{$eq->admin_category == null ? 'N/A' : $eq->admin_category->name}}</td>
                                        <td>{{$eq->status}}</td>
                                        <td>{{$eq->serial_number}}</td>
                                        <td>{{$eq->model_number}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <a href="/admin/equipment/add">
                <div class="fab">
                    <i class="fas fa-plus"></i>
                </div>
            </a>
        </div>
    </div>
    @include('layouts.admin_core_scripts')
    <script src="{{asset('js/datatables.js')}}"></script>
    <script>
        const equipment_table = generateDtbl("#equipment_table", "No eqiupment registered");
    </script>
</body>

</html>