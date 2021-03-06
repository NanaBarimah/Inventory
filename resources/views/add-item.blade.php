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
            @include('layouts.navbar', ['page_title' => 'Add Item'])
            <div class="panel-header panel-header-sm">
            </div>
            
            <div class="content">
                <div class="col-md-10 mr-auto ml-auto">
                    <div class="wizard-container">
                        <div class="card card-wizard" data-color="primary" id="wizardProfile">
                            <form action="#" method="POST" id="add_new_item">
                                <div class="card-header text-center" data-background-color="gray">
                                    <h3 class="card-title">
                                        Add New Equipment
                                    </h3>

                                    <h3 class="description">Complete this form to add a new inventory item</h5>
                                        <div class="wizard-navigation">
                                            <ul class="nav nav-pills" style="background-color: rgba(0,0,0,0)">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#about" data-toggle="tab" role="tab"
                                                        aria-controls="about" aria-selected="true">
                                                        Details
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#account" data-toggle="tab" data-toggle="tab"
                                                        role="tab" aria-controls="account" aria-selected="false">
                                                        <i class="now-ui-icons ui-1_settings-gear-63"></i>
                                                        Status and categorization
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#address" data-toggle="tab" data-toggle="tab"
                                                        role="tab" aria-controls="address" aria-selected="false">
                                                        <i class="now-ui-icons ui-1_email-85"></i>
                                                        Maintenance
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="about">
                                            <h5 class="info-text"> Let's start with some basic information about the
                                                device</h5>
                                            <div class="row justify-content-center">
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group form-control-lg">
                                                                <input type="text" class="form-control" placeholder="Model No. (required)"
                                                                    name="model_number" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group form-control-lg">
                                                                <input type="text" placeholder="Serial No. (required)"
                                                                    class="form-control" name="serial_number" required="true" />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group form-control-lg">
                                                                <input type="text" placeholder="Equipment Code (required)"
                                                                    class="form-control" name="code" required="true" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 mt-3">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group form-control-lg">
                                                                <input type="text" class="form-control" placeholder="Manufacturer"
                                                                    name="manufacturer_name" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group form-control-lg">
                                                                <input type="number" placeholder="Year of purchase"
                                                                    class="form-control" name="year_of_purchase"
                                                                    required="true" minLength="4" maxLength="4" />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group form-control-lg">
                                                                <input type="number" placeholder="Cost of equipment (in GH&cent;)"
                                                                    class="form-control" name="equipment_cost" required="true" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 mt-3">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="input-group form-control-lg">
                                                                <input type="text" class="form-control datepicker" name="installation_time"
                                                                    required="true" placeholder="Installation date">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <select class="col-md-12 selectpicker" data-style="btn btn-purple btn-round"
                                                                title="Service Provider" name="service_vendor_id">
                                                                @foreach($vendors as $vendor)
                                                                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 mt-3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="input-group form-control-lg">
                                                                <textarea type="text" class="form-control" name="description"
                                                                    placeholder="Equipment Description" rows="2" required="true"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="account">
                                            <h5 class="info-text"> Additional information </h5>
                                            <div class="row justify-content-center">
                                                <div class="col-lg-10" style="margin-bottom: 20px;">
                                                    <div class="row">
                                                        <div class="col-sm-12" style="margin-bottom: 20px;">
                                                            <h6 class="subtitle">categorization</h6>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <select class="col-md-12 selectpicker" data-style="btn btn-purple btn-round"
                                                                title="Equipment type" name="category_id">
                                                                @foreach($categories as $category)
                                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <select class="col-md-12 selectpicker" data-style="btn btn-purple btn-round"
                                                                title="Unit" name="unit_id">
                                                                @foreach($departments as $department)
                                                                    @foreach($department->units as $unit)
                                                                        <option value="{{$unit->id}}">{{$unit->name}} - {{$department->name}}</option>
                                                                    @endforeach
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <input type="text" name="location" required="true"
                                                                placeholder="Location" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h6 class="subtitle">Equipment Status</h6>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="choice" data-toggle="wizard-radio">
                                                                <input type="radio" name="status" value="Good">
                                                                <div class="icon" color="">
                                                                    <i class="fa fa-check-double"></i>
                                                                </div>
                                                                <h6>Good</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="choice" data-toggle="wizard-radio">
                                                                <input type="radio" name="status" value="Fair">
                                                                <div class="icon">
                                                                    <i class="fa fa-check"></i>
                                                                </div>
                                                                <h6>Fair</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="choice" data-toggle="wizard-radio">
                                                                <input type="radio" name="status" value="Bad">
                                                                <div class="icon">
                                                                    <i class="fa fa-times"></i>
                                                                </div>
                                                                <h6>Bad</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="address">
                                            <div class="row justify-content-center">
                                                <div class="col-sm-12">
                                                    <h5 class="info-text"> Finally, a little information to help with
                                                        maintenance </h5>
                                                </div>
                                                <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6">
                                                            <select class="col-md-12 selectpicker" data-style="btn btn-purple btn-round"
                                                            title="Maintenance Frequency" name="maintenance_frequency"> 
                                                            <option value="1">1 month</option>
                                                            <option value="2">2 months</option>
                                                            <option value="3">3 months</option>
                                                            <option value="4">4 months</option>
                                                            <option value="5">5 months</option>
                                                            <option value="6">6 months</option>
                                                            <option value="7">7 months</option>
                                                            <option value="8">8 months</option>
                                                            <option value="9">9 months</option>
                                                            <option value="10">10 months</option>
                                                            <option value="11">11 months</option>
                                                            <option value="12">12 months</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                            <div class="input-group form-control-lg">
                                                                <input type="text" class="form-control datepicker" name="pos_rep_date"
                                                                    required="true" placeholder="Possible replacement date"/>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" value="{{Auth::user()->id}}" name="user_id"/>
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
                                        <input type='submit' class='btn btn-finish btn-fill btn-rose btn-wd' name='finish'
                                            id="btn_save" value='Finish' />
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
    @include('hospital-modal')
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
    <script>
        $('#add_new_item').on('submit', function(e){
            e.preventDefault();
            $('#btn_save').html('<i class="now-ui-icons loader_refresh spin"></i>');
            var form_data = $(this).serialize();
            $(this).find('input, textarea, select').prop('disabled',true);

            console.log(form_data);
            request = $.ajax({
                url: '/api/equipment/add_equipment',
                method: 'post',
                data: form_data+'&hospital_id='+{{Auth::user()->hospital_id}},
                success: function(data, status){
                    $('#btn_save').html('Save');
                    $('#add_new_item').find('input, textarea, select').prop('disabled', false);
                    $('#add_new_item').find('.resetable').val(null);
                    $('#btn_reset').val('Reset');
                    presentNotification('Item successfully added', 'info', 'top', 'right');
                },
                error: function(xhr, desc, err){
                    $('#btn_save').html('Save');
                    $('#add_new_item').find('input, textarea, select').prop('disabled', false);
                    presentNotification('Could not save the item. Try again.', 'danger', 'top', 'right');
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

        $(document).ready(function () {
        // Initialise the wizard
        demo.initNowUiWizard();
        $('.card.card-wizard').addClass('active');

        demo.initDateTimePicker();
        });
    </script>
</body>

</html>