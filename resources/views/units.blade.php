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
            @include('layouts.navbar', ['page_title' => 'Units List'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-10 center">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="inline-block">Units List</h4>
                                <a href="#" class="btn btn-purple pull-right" data-toggle="modal" data-target="#addunitModal">Add New</a>
                            </div>
                            <div class="card-body">
                                <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Unit Name</th>
                                            <th>Department</th>
                                            <th>Unit Head</th>
                                            <th class="disabled-sorting">Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Unit Name</th>
                                            <th>Department</th>
                                            <th>Unit Head</th>
                                            <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($departments as $department)
                                        @foreach($department->units as $unit)
                                            <tr>
                                                <td>{{$unit->name}}</td>
                                                <td>{{$department->name}}</td>
                                                <td>{{$unit->user->firstname.' '.$unit->user->lastname}}</td>
                                                <td>
                                                    <span data-toggle="modal" data-target="#editunitModal" data-id="{{$unit->id}}" data-name="{{$unit->name}}" data-department="{{$department->id}}">
                                                        <a href="#" class="btn btn-round btn-info btn-icon btn-sm edit" data-placement="left" title="Edit" data-toggle="tooltip">
                                                            <i class="now-ui-icons design-2_ruler-pencil"></i>
                                                        </a>
                                                    </span>
                                                </td>
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
    <div class="modal fade" id="addunitModal" tabindex="-1" role="dialog" aria-labelledby="addunitLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title margin-bottom-10" id="addunitLabel">New Unit</h5>
                    <form method="post" action="#" id="add_new_unit_form">
                        <h6 class="subtitle">Unit Details</h6>
                        <div class="form-group input-group margin-bottom-10">
                            <div class="col-md-6 col-sm-12">
                                <input type="text" class="form-control margin-bottom-10" placeholder="Unit Name" name="name" id="unit_name" required/>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <select class="selectpicker" data-style="btn btn-purple btn-round" name="department_id" id="department_name" required>
                                    <option selected hidden disabled>Department</option>
                                    @foreach($departments as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <h6 class="subtitle">Unit Head</h6>
                        <ul class="nav nav-pills nav-pills-primary" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#old_operator" role="tablist">Select Existing User</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#new_operator" role="tablist">Create New User</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-space">
                            <div class="tab-pane active" id="old_operator">
                                <select class="selectpicker col-md-12" data-style="btn btn-purple btn-round" name="user_id" id="add_new" title="Select User" required>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->firstname}} {{$user->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="tab-pane" id="new_operator">
                            <div class="form-group input-group">
                                <div class="col-md-6 col-sm-12">
                                    <input type="text" class="form-control margin-bottom-10" placeholder="First Name" name="firstname" id="firstname" disabled required/>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="text" class="form-control margin-bottom-10" placeholder="Last Name" name="lastname" id="lastname" disabled required/>
                                </div>
                                </div>
                                <div class="form-group input-group">
                                    <div class="col-md-6 col-sm-12">
                                        <input type="text" class="form-control margin-bottom-10" placeholder="Username" disabled name="username" id="username" required/>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="tel" class="form-control margin-bottom-10" placeholder="Phone Number" name="phone_number" disabled id="phone_number" required/>
                                    </div>
                                </div>
                                <div class="form-group input-group">
                                    <div class="col-md-6 col-sm-12">
                                        <input type="password" class="form-control margin-bottom-10" placeholder="Password" name="password" id="password" disabled required/>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <input type="password" class="form-control margin-bottom-10" placeholder="Confirm Password" id="password_confirm" disabled required/>
                                    </div>
                                </div>
                                <p class="text-danger text-center" style="font-size: 11px; display: none;">The passwords you have entered do not match</p> 
                                </div>
                            </div>                       
                        <button type="submit" class="pull-right btn btn-purple btn-fill btn-wd" id="btn_submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editunitModal" tabindex="-1" role="dialog" aria-labelledby="editunitLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title margin-bottom-10" id="editunitLabel">Edit unit</h5>
                    <form method="post" action="#" id="edit_unit_form" >
                        <div class="form-group">
                            <input type="text" class="form-control margin-bottom-10" placeholder="Unit Name" name="name" id="edit_dept_name"/>
                            <select class="selectpicker form-control" data-style="btn btn-purple btn-round" id="edit_unit_dept" name="department_id" required>
                                <option hidden disabled>Department</option>
                                @foreach($departments as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="edit_unit_id" name="id"/>
                            <input type="hidden" name="hospital_id" value="{{Auth::user()->hospital_id}}"/>
                            <button type="submit" class="pull-right btn btn-purple btn-fill btn-wd" id="btn_edit" disabled>Save</button>
                        </div>
                    </form>
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
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script>
        var table; 
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

            table = $('#datatable').DataTable();
        });

        $('#add_new_unit_form').on('submit', function(e){
            e.preventDefault();

            if($('#password').val() != $('#password_confirm').val()){
                $('.text-danger').css('display', 'block');
                return false;
            }
            else{
            $('.text-danger').css('display', 'none');
            $('#btn_submit').html('<i class="now-ui-icons loader_refresh spin"></i>');
            var data = $(this).serialize();
            $(this).find('input').prop('disabled', true);

            $request = $.ajax({
                url: '/api/units/add',
                method: 'post',
                data: data+'&hospital_id='+{{Auth::user()->hospital_id}},
                success: function(data, status){
                    $('#btn_submit').html('Save');
                    $('#add_new_unit_form').find('input').prop('disabled', false);

                    if(data.error){
                        presentNotification(data.message+". Try again.", 'danger', 'top', 'right');
                    }else{
                        table.row.add([
                            $('#unit_name').val(),
                            $('#department_name option:selected').text(),
                            '<a href="#" class="btn btn-round btn-info btn-icon btn-sm edit" data-toggle="tooltip" data-placement="left" title="Edit"><i class="now-ui-icons design-2_ruler-pencil"></i></a>'
                        ]).draw(true);
                        $('#add_new_unit_form').find('input').val('');
                        presentNotification(data.message, 'info', 'top', 'right');
                    }
                },
                error: function(xhr, desc, err){
                    $('#btn_submit').html('Save');
                    $('#add_new_unit_form').find('input').prop('disabled', false);
                    presentNotification('Could not save the unit. Try again.', 'danger', 'top', 'right');

                    console.log(err);
                }
            });
            }
        });

        $('#editunitModal').on('show.bs.modal', function(e){
            var dept_id = $(e.relatedTarget).data('id');
            var dept_name = $(e.relatedTarget).data('name');
            var dept = $(e.relatedTarget).data('department');

            $('#edit_dept_name').val(dept_name);
            $('#edit_unit_id').val(dept_id);
            $('#edit_unit_dept').val(dept);
            $('.selectpicker').selectpicker('refresh');
        });
        
        $('#editunitModal').on('hide.bs.modal', function(e){
            $('#btn_edit').prop('disabled', true);
        });
        
        $('#edit_unit_form').on('submit', function(e){
            e.preventDefault();
            form_data = $(this).serialize();
            var id = $('#edit_unit_id').val();
            $('#btn_edit').html('<i class="now-ui-icons loader_refresh spin"></i>');

            request = $.ajax({
                url : 'api/units/update/'+id,
                method: 'PUT',
                data: form_data,
                success: function(data, status){
                    $('#btn_edit').html('Save');
                    presentNotification('Unit updated', 'info', 'top', 'right');     
                    setTimeout(function(){
                        location.reload()
                    }, 1700);         
                },
                error: function(xhr, desc, err){
                    $('#btn_edit').html('Save');
                    presentNotification('Could not update the unit', 'danger', 'top', 'right');
                }
            });
        });

        $('#edit_unit_form input').on('input', function(){
            $('#btn_edit').prop('disabled', false);
        });

        $('#edit_unit_dept').on('change', function(){
            $('#btn_edit').prop('disabled', false);
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href");
            if (target == '#new_operator') {
                $('#new_operator').find('input').prop('disabled', false);
                $('#old_operator').find('select').prop('disabled', true);
            } else if(target == '#old_operator'){
                $('#new_operator').find('input').prop('disabled', true);
                $('#old_operator').find('select').prop('disabled', false);
            }
        });
        
        /*$("#add_new").on("changed.bs.select", 
            function(e, clickedIndex, newValue, oldValue) {
                if($('#add_new').val() == 'add_new'){
                    $('#new_operator').find('input').prop('disabled', false);
                }else{
                    $('#new_operator').find('input').prop('disabled', true);
                }
        });*/
    </script>
</body>

</html>