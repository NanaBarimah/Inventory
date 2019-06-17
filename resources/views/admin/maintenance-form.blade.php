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
        @include('layouts.admin_sidebar')
        <div class="main-panel">
            @include('layouts.admin_navbar', ['page_title' => 'New Maintenance Report'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="col-md-10 mr-auto ml-auto">
                    <div class="wizard-container">
                        <div class="card card-wizard" data-color="primary" id="wizardProfile">
                            <form action="#" method="POST" id="maintenance_form">
                                <div class="card-header text-center" data-background-color="gray">
                                    <h3 class="card-title">
                                       New Maintenance
                                    </h3>

                                    <h3 class="description">Provide details about maintenance performed</h5>
                                        <div class="wizard-navigation">
                                            <ul class="nav nav-pills" style="background-color: rgba(0,0,0,0)">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#about" data-toggle="tab" role="tab"
                                                        aria-controls="about" aria-selected="true">
                                                        Maintenance Type
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#account" data-toggle="tab" data-toggle="tab"
                                                        role="tab" aria-controls="account" aria-selected="false">
                                                        Maintenance Details
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#address" data-toggle="tab" data-toggle="tab"
                                                        role="tab" aria-controls="address" aria-selected="false">
                                                        Observations
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="about">
                                            <h5 class="info-text"> Let's start off with some basic information</h5>
                                            <div class="row justify-content-center">
                                                <div class="col-lg-10">
                                                    <h6 class="subtitle">Which equipment did you work on?</h6>
                                                    <div class="row">
                                                        <select class="col-sm-12 selectpicker" data-style="btn btn-purple btn-round" name="equipment_code" readonly required>
                                                            <option value="{{$equipment}}" selected>{{$equipment}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 mt-6">
                                                    <h6 class="subtitle">What type of maintenance was carried out</h6>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="choice <?php if($requests->maintenance_type == 'Planned Maintenance'){echo 'active'; } ?>" data-toggle="wizard-radio">
                                                                <input type="radio" name="type" value="Planned Maintenance" <?php if($requests->maintenance_type == 'Planned Maintenance'){echo "checked='checked'"; } ?> required>
                                                                <div class="icon" color="">
                                                                    <i class="fa fa-calendar-alt"></i>
                                                                </div>
                                                                <h6>Planned Maintenance</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="choice <?php if($requests->maintenance_type == 'Corrective Maintenance'){echo 'active'; } ?>" data-toggle="wizard-radio">
                                                                <input type="radio" name="type" value="Corrective Maintenance" <?php if($requests->maintenance_type == 'Corrective Maintenance'){echo "checked='checked'"; } ?> required>
                                                                <div class="icon">
                                                                    <i class="fa fa-wrench"></i>
                                                                </div>
                                                                <h6>Corrective Maintenance</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="choice <?php if($requests->maintenance_type == 'Emergency Maintenance'){echo 'active'; } ?>" data-toggle="wizard-radio">
                                                                <input type="radio" name="type" value="Emergency Maintenance"  <?php if($requests->maintenance_type == 'Emergency Maintenance'){echo "checked='checked'"; } ?> required>
                                                                <div class="icon">
                                                                    <i class="fa fa-fire"></i>
                                                                </div>
                                                                <h6>Emergency Maintenance</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="account">
                                            <h5 class="info-text"> Details about maintenance carried out </h5>
                                            <div class="row justify-content-center">
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4 hideable">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control datepicker" name="date_reported" 
                                                                    required="true" placeholder="Date Reported" readonly value="{{date('m/d/Y', strtotime($requests->created_at))}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group">
                                                                <input type="text" placeholder="Date Inspected"
                                                                    class="form-control datepicker" name="date_inspected" required="true" />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group form-control-lg">
                                                                <input type="hidden" name="job_number" value="{{$requests->id}}" />
                                                                <input type="hidden" name="date_reported" value="{{$requests->created_at}}"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 mt-3">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group form-control-lg">
                                                                <input type="text" class="form-control" placeholder="Cost of Maintenance (in GH&cent;)"
                                                                    name="cost" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group">
                                                                <input type="number" placeholder="Down time"
                                                                    class="form-control normal-radius" name="down_time"
                                                                    required="true"/>
                                                                <select class="selectpicker col-md-6 col-sm-6" data-style="btn btn-purple"
                                                                 title="Unit" name="duration_units" required="true">
                                                                    <option value="mi">Minutes</option>
                                                                    <option value="h">Hours</option>
                                                                    <option value="d">Days</option>
                                                                    <option value="mo">Months</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group form-control-lg">
                                                                <input type="text" placeholder="Maintenance duration"
                                                                    class="form-control" name="duration" required="true" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 mt-3">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6">
                                                            <select class="selectpicker col-md-12" data-style="btn btn-round btn-purple"
                                                             name="faulty_category" title="Fault Category">
                                                                <option value="None">None</option>
                                                                <option value="User Fault">User Fault</option>
                                                                <option value="Equipment Fault">Equipment Fault</option>
                                                                <option value="Damaged">Damaged</option>
                                                                <option value="Main Unstable">Main Unstable</option>
                                                                <option value="Water/Gas Pressure">Water/Gas Pressure</option>
                                                                <option value="Climate/Environment">Climate/Environment</option>
                                                                <option value="Unknown">Unknown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="input-group">
                                                                <textarea name="reason" class="form-control"
                                                                    required="true" placeholder="Reason for down time"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 mt-3">
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="input-group form-control-lg">
                                                                <textarea type="text" class="form-control" name="problem_found"
                                                                    placeholder="Problem Found" rows="2" required="true"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="input-group">
                                                                <textarea name="action_taken" class="form-control"
                                                                    required="true" placeholder="Action taken/Checks done"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="address">
                                            <div class="row justify-content-center">
                                                <div class="col-sm-12">
                                                    <h5 class="info-text"> Finally, your recommendations </h5>
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4">
                                                        <input type="checkbox" name="function_check" class="bootstrap-switch"
                                                            data-on-label="<i class='now-ui-icons ui-1_check'></i>" 
                                                            data-off-label="<i class='now-ui-icons ui-1_simple-remove'></i>"/> Function Checked
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                        <input type="checkbox" name="safety_check" class="bootstrap-switch"
                                                            data-on-label="<i class='now-ui-icons ui-1_check'></i>" 
                                                            data-off-label="<i class='now-ui-icons ui-1_simple-remove'></i>"/> Safety Checked
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                        <input type="checkbox" name="calibration_check" class="bootstrap-switch"
                                                            data-on-label="<i class='now-ui-icons ui-1_check'></i>" 
                                                            data-off-label="<i class='now-ui-icons ui-1_simple-remove'></i>"/> Callibration Checked
                                                        </div>
                                                        <input type="hidden" value="{{Auth::guard('admin')->user()->id}}" name="mtce_officer"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 mt-3">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h6 class="subtitle">Equipment Status</h6>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <select class="selectpicker col-sm-12" name="status" title="Equipment Status" required>
                                                                <option value="Good">Good</option>
                                                                <option value="Fair">Fair</option>
                                                                <option value="Bad">Bad</option>
                                                            </select>
                                                            <input type="hidden" name="hospital_id" value="{{$hospital}}"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 mt-3">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                        <textarea name="recommendation" class="form-control"
                                                            required="true" placeholder="Recommendations"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="pull-right">
                                        <input type='button' class='btn btn-next btn-fill btn-rose btn-wd' name='next'
                                            value='Next' />
                                        <button type='submit' class='btn btn-finish btn-fill btn-rose btn-wd' name='finish'
                                            id="btn_save">Finish</button>
                                    </div>

                                    <div class="pull-left">
                                        <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous'
                                            value='Previous' />
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
    <!--   Core JS Files   -->
    <!--script src="{{ asset('js/app.js') }}" defer></script-->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>
    <script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('js/now-ui-dashboard.min.js?v=1.2.0')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/jquery.bootstrap-wizard.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script>
        $('#maintenance_form').on('submit', function(e){
            e.preventDefault();
            $('#btn_save').html('<i class="now-ui-icons loader_refresh spin"></i>');
            var form_data = $(this).serialize();
            $(this).find('input, textarea, select').prop('disabled',true);


            request = $.ajax({
                url: '/api/biomedical/maintenances/add',
                method: 'post',
                data: form_data,
                success: function(data, status){
                    $('#btn_save').html('Finish');
                    if(data.error){
                        presentNotification(data.message, 'danger', 'top', 'right');    
                    }else{
                        $('#maintenance_form').find('input, textarea, select').prop('disabled', false);
                        $('#maintenance_form').find('input, textarea, select').val('');
                        presentNotification('Maintenance recorded', 'info', 'top', 'right');
                    }

                    setTimeout(function(){
                        window.location.href = '/admin/assigned';
                    }, 1500);
                },
                error: function(xhr, desc, err){
                    $('#btn_save').html('Finish');
                    $('#maintenance_form').find('input, textarea, select').prop('disabled', false);

                    presentNotification('Could not record the maintenance. Try again.', 'danger', 'top', 'right');
                }
            });
        });

        $(document).ready(function () {
        // Initialise the wizard
        demo.initNowUiWizard();
        $('.card.card-wizard').addClass('active');

        demo.initDateTimePicker();

        if($(this).find('input[type=radio]').val()=="Planned Maintenance"){
                $('.hideable').css('display', 'none');
                $('.showable').css('display', 'block');
                $('.hideable').find('input, textarea, select').prop('disabled', true);
                $('.showable').find('input, textarea, select').prop('disabled', false);
            }else{
                $('.hideable').css('display', 'block');
                $('.showable').css('display', 'none');
                $('.hideable').find('input, textarea, select').prop('disabled', false);
                $('.showable').find('input, textarea, select').prop('disabled', true);
            }
        });
        
        $('.choice').click(function(){
            if($(this).find('input[type=radio]').val()=="Planned Maintenance"){
                $('.hideable').css('display', 'none');
                $('.showable').css('display', 'block');
                $('.hideable').find('input, textarea, select').prop('disabled', true);
                $('.showable').find('input, textarea, select').prop('disabled', false);
            }else{
                $('.hideable').css('display', 'block');
                $('.showable').css('display', 'none');
                $('.hideable').find('input, textarea, select').prop('disabled', false);
                $('.showable').find('input, textarea, select').prop('disabled', true);
            }
        });
    </script>
</body>
</html>