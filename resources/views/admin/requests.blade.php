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
                                                            <th>ID</th>
                                                            <th>Hospital</th>
                                                            <th>Type</th>
                                                            <th>Equipment Count</th>
                                                            <th>Status</th>
                                                            <th>Date Reported</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Request Number</th>
                                                            <th>Hospital</th>
                                                            <th>Maintenance Type</th>
                                                            <th>Number of Equipment</th>
                                                            <th>Status</th>
                                                            <th>Date Reported</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        @foreach($requests as $request)
                                                        <?php 
                                                                $color = '';
                                                                switch($request->maintenance_type){
                                                                    case  'Planned Maintenance':
                                                                        $color = 'info';
                                                                        break;
                                                                    case 'Corrective Maintenance' :
                                                                        $colr = 'primary';
                                                                    case 'Emergency Maintenance' :
                                                                        $color = 'danger';
                                                                }
                                                            ?>
                                                        <tr>
                                                            <td><a href="#" data-toggle="modal" data-target="#setRequestModal"
                                                            data-id="{{$request->id}}" data-assigned = "{{$request->assigned_to}}" data-hospital = "{{$request->equipments[0]->hospital->id}}" data-scheduled="{{$request->scheduled_for != null ? date('m/d/Y', strtotime($request->scheduled_for)) : ''}}">
                                                            {{$request->id}}</a>
                                                            </td>
                                                            <td>{{$request->equipments[0]->hospital->name}}</td>
                                                            <td><span class="badge badge-{{$color}}">
                                                            {{$request->maintenance_type}}
                                                            </span></td>
                                                            <td class="text-center">{{count($request->equipments)}}</td>
                                                            <td><span class="badge badge-{{$request->is_checked == 0 ? 'warning' : 'success'}}">{{$request->is_checked == 0 ? 'Unassigned' : 'Assigned'}}</span></td>
                                                            <td>{{date('D d M, Y', strtotime($request->created_at))}}</td>
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
        <div class="modal fade" id="setRequestModal" tabindex="-1" role="dialog" aria-labelledby="setRequestLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5 class="modal-title margin-bottom-10" id="setRequestLabel">Maintenance Request Assignment</h5>
                            <form method="post" action="#" id="set_request_form">
                                <div class="form-group">
                                    <select class="selectpicker col-md-12" data-style="btn" id="assigned_to" name="assigned_to" required title="Select Engineer">
                                    @foreach($engineers as $engineer)
                                        <option value="{{$engineer->id}}">{{$engineer->firstname}} {{$engineer->lastname}}</option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" id="request_id" name="id"/>
                                    <input type="hidden" id="hospital_id" name="hospital_id"/>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="datepicker form-control" id="scheduled_for" id="scheduled_for" name="scheduled_for" placeholder="Schedule For" required/>
                                </div>
                                <button type="submit" class="pull-right btn btn-purple btn-fill btn-wd" id="btn_submit">Save</button>
                            </form>
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

        $('#set_request_form').on('submit', function(e){
            e.preventDefault();
            form_data = $(this).serialize();
            var id = $('#request_id').val();
            $('#btn_submit').html('<i class="now-ui-icons loader_refresh spin"></i>');

            request = $.ajax({
                url : '/api/requests/assign/'+id,
                method: 'PUT',
                data: form_data,
                success: function(data, status){
                    $('#btn_submit').html('Save');
                    if(data.error){
                        presentNotification(data.message, 'danger', 'top', 'right');
                    }else{
                    presentNotification(data.message, 'info', 'top', 'right');     
                    setTimeout(function(){
                        location.reload()
                    }, 1700);
                    }         
                },
                error: function(xhr, desc, err){
                    $('#btn_submit').html('Save');
                    presentNotification(data.message, 'danger', 'top', 'right');
                }
            });
        });


        $('#setRequestModal').on('show.bs.modal', function(e){
            var request_id = $(e.relatedTarget).data('id');
            var assigned_to = $(e.relatedTarget).data('assigned');
            var scheduled_for = $(e.relatedTarget).data('scheduled');
            var hospital_id = $(e.relatedTarget).data('hospital');

            $('#assigned_to').val(assigned_to);
            $('#scheduled_for').val(scheduled_for);
            $('#request_id').val(request_id);
            $('#hospital_id').val(hospital_id);
            $('.selectpicker').selectpicker('refresh');
        });

    </script>
</body>

</html>