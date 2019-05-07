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
            @include('layouts.navbar', ['page_title' => 'Users List'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-10 center">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="inline-block">Users List</h4>
                                <a href="/users/add" class="btn btn-purple pull-right">Add User</a>
                            </div>
                            <div class="card-body">
                                <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th class="disabled-sorting text-right">Enable User</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th class="disabled-sorting text-right">Enable User</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr class="uppercase">
                                            <td>
                                                {{$user->firstname}}
                                            </td>
                                            <td>{{$user->lastname}}</td>
                                            <td style="text-transform:lowercase;">{{strtolower($user->username)}}</td>
                                            <td>{{ucfirst($user->role)}}</td>
                                            <td class="text-right">
                                            <input type="checkbox" name="active" class="bootstrap-switch" id="active" <?php if($user->active == 1){echo 'checked';}?>
                                            data-on-label="<i class='now-ui-icons ui-1_check'></i>" 
                                            data-off-label="<i class='now-ui-icons ui-1_simple-remove'></i>" onchange="setActive({{$user}})"/>
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
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js" type="text/javascript"></script>
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

        /*$('#active').on('switchChange.bootstrapSwitch', function(e, s){
            var form_data = $('toggle_active').serialize();
            alert(form_data);

            request = $.ajax({
                url : '/api/users/activate',

            })
        });*/

        function setActive(user){
            var active = user.active;
            var id = user.id;

            if(active == 0){
                active = 1;
            }else{
                active = 0;
            }

            var form_data = "user_id="+id+"&active="+active;
            
            $.ajax({
                url : '/api/users/activate',
                method: 'put',
                data : form_data,
                success: function(data, status){
                    if(data.error){
                        presentNotification(data.message, 'danger', 'top', 'right');
                    }else{
                        presentNotification(data.message, 'info', 'top', 'right');
                    }
                },

                error : function(xhr, desc, err){
                    presentNotification('Network error', 'danger', 'top', 'right');
                }
            });
        }

        function presentNotification(message, color, from, align){
            $.notify(
                {
                    message: message
                }, {
                    type: color,
                    timer: 1500,
                    placement: {
                        from: from,
                        align: align
                    }
                }
            );
        }
    </script>
</body>

</html>