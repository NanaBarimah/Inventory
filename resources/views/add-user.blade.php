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
            @include('layouts.navbar', ['page_title' => 'Add User'])
            <div class="panel-header panel-header-sm">
            </div>
            
            <div class="content">
                <div class="col-md-8 mr-auto ml-auto">
                    <div>
                        <div class="card" data-color="primary">
                            <form method="post" action="#" id="add_user_form">
                                <div class="card-header text-center" data-background-color="gray">
                                    <h3 class="card-title">
                                        New User
                                    </h3>
                                    <h3 class="description">Add a new user.</h5>
                                </div>

                                
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" class="form-control resetable" placeholder="First Name" name="firstname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-1">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control resetable" placeholder="Last Name" name="lastname" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 pr-1">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control resetable" placeholder="Username" name="username" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 pr-1">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="tel" class="form-control resetable" placeholder="Phone Number" name="phone_number" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3 pl-1">
                                            <div class="form-group">
                                                    <label>User Role</label>
                                                    <select class="selectpicker" data-style="btn btn-purple btn-round" name="role" required>
                                                        <option selected disabled hidden>Select role</option>
                                                        <option value="Admin">System Administrator</option>
                                                        <option value="Hospital Admin">Hospital Administrator</option>
                                                        <option value="Engineer">Engineer</option>
                                                        <option value="Storekeeper">Storekeeper</option>
                                                    </select>
                                                    <input type="hidden" name="hospital_id" value="{{Auth::user()->hospital_id}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control resetable" name="password" id="new_password" required>
                                                <p class="text-danger text-center" style="font-size:11px; display:none">The passwords you have provided do not match</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control resetable" id="confirm_password" name="password_confirmation" required>
                                                <p class="text-danger text-center" style="font-size:11px; display:none;">The passwords you have provided do not match</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="pull-right">
                                        <input type='reset' class='btn btn-wd' value='Reset' id="btn_reset"/>
                                        <button type='submit' class='btn btn-purple btn-wd' id="btn_save">Save</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                            </form>
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
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script>
        $('#add_user_form').on('submit', function(e){
            e.preventDefault();
            $('#btn_save').html('<i class="now-ui-icons loader_refresh spin"></i>');
            var form_data = $(this).serialize();
            
            if($('#new_password').val() != $('#confirm_password').val()){
                $('.text-danger').html('The passwords you have provided do not match');
                $('#btn_save').html('Save');
                $('.text-danger').css('display', 'block');
                return false;
            }

            if($('#new_password').val().length < 6){
                $('.text-danger').html('Password should be longer than 6 characters');
                $('.text-danger').css('display', 'block');
                return false
            }
            
            $(this).find('input, select').prop('disabled',true);


            request = $.ajax({
                url: '/api/users/add_user',
                method: 'post',
                data: form_data,
                success: function(data, status){
                    $('#btn_save').html('Save');
                    $('#add_user_form').find('input, select').prop('disabled', false);
                    $('#add_user_form').find('.resetable').val('');
                    $('#btn_reset').val('Reset');
                    presentNotification('User saved', 'info', 'top', 'right');
                    console.log('done');
                },
                error: function(xhr, desc, err){
                    $('#btn_save').html('Save');
                    $('#add_user_form').find('.resetable').prop('disabled', false);
                    presentNotification('Could not save this user. Try again.', 'danger', 'top', 'right');
                }
            });
        });

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