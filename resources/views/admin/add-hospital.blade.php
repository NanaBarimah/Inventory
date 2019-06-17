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
            @include('layouts.admin_navbar', ['page_title' => 'Add Hospital'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
            <div class="col-md-8 mr-auto ml-auto">
                    <div>
                        <div class="card" data-color="primary">
                            <form action="#" method="post" id="add_hospital">
                                <div class="card-header text-center" data-background-color="gray">
                                    <h3 class="card-title">
                                        Add Hospital
                                    </h3>
                                    <h3 class="description">Complete this form to add a new hospital.</h5>
                                </div>

                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-9">
                                            <h6 class="subtitle">Hospital Information</h6> 
                                            <div class="form-group form-control-lg input-group">
                                                <div class="col-sm-6">
                                                    <input type="text" placeholder="Hospital Name" class="form-control resetable" name="name" id="name" required/>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control resetable" placeholder="Address" name="address" id="address" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-control-lg input-group">
                                                <div class="col-sm-6">
                                                    <input type="text" placeholder="Contact No." class="form-control resetable" name="contact_number" id="contact_number" required/>
                                                </div>
                                                <select class="selectpicker col-sm-6 custom-picker" data-style="btn btn-purple btn-round" name="district_id" required>
                                                    <option selected disabled hidden>District</option>
                                                    @foreach($districts as $district)
                                                    <option value="{{$district->id}}">{{$district->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <hr/>
                                            <h6 class="subtitle">User Information</h6> 
                                            <div class="form-group input-group">
                                                <div class="col-sm-6">
                                                    <input type="text" placeholder="First Name" class="form-control resetable" name="firstname" id="firstname" required/>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" placeholder="Last Name" class="form-control resetable" name="lastname" id="lastname" required/>   
                                                </div>
                                            </div>
                                            <div class="form-group input-group">
                                                <div class="col-sm-6">
                                                    <input type="text" placeholder="Username" class="form-control resetable" name="username" id="username" required/>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="tel" placeholder="Phone Number" class="form-control resetable" name="phone_number" id="phone_number" required/>
                                                </div>
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
    </div>
    @include('layouts.admin_core_scripts')
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script>
        $('#add_hospital').on('submit', function(e){
            e.preventDefault();
            
            $('#btn_save').html('<i class = "now-ui-icons loader_refresh spin"></i>');
            var form_data = $(this).serialize();
            $(this).find('input').prop('disabled', true);

            request = $.ajax({
                url : '/api/hospitals/add_hospital',
                method : 'post',
                data : form_data,
                success : function(data, status){
                    $('#add_hospital').find('input').prop('disabled', false);
                    $('#btn_save').html('Save');
                    $('#add_hospital').find('.resetable').val('');

                    presentNotification('Hospital saved', 'info', 'top', 'right');
                },
                error : function(error, xhr, desc){
                    $('#add_hospital').find('input').prop('disabled', false);
                    $('#btn_save').html('Save');

                    presentNotification('Could not save the hospital', 'danger', 'top', 'right');
                }
            })
        });
    </script>
</body>

</html>