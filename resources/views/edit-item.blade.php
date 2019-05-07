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
            
            <!--div class="content">
                <div class="col-md-8 mr-auto ml-auto">
                    <div>
                        <div class="card" data-color="primary">
                            <form action="#" method="post" id="edit_item">
                                <div class="card-header text-center" data-background-color="gray">
                                    <h3 class="card-title">
                                        Edit Equipment
                                    </h3>
                                </div>

                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-9">
                                            <div class="form-group form-control-lg input-group">
                                                <div class="col-sm-6">
                                                    <input type="text" placeholder="Model No." class="form-control" name="model_number" id="model_number" value="{{$equipment->model_number}}" required/>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" placeholder="Manufacturer" name="manufacturer_name" id="manufacturer_name" value="{{$equipment->manufacturer_name}}" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-control-lg input-group">
                                                <div class="col-sm-6">
                                                    <input type="text" placeholder="Serial No." class="form-control" name="serial_number" id="serial_number" value="{{$equipment->serial_number}}" required/>
                                                </div>
                                                <select class="selectpicker col-sm-6 custom-picker" data-style="btn btn-purple btn-round" name="maintenance_frequency" required>
                                                    <option selected disabled hidden>Maintenance Frequency</option>
                                                    <option value="1" <?php if($equipment->maintenance_frequency == 1){echo 'selected';}?>>1 month</option>
                                                    <option value="2" <?php if($equipment->maintenance_frequency == 2){echo 'selected';}?>>2 months</option>
                                                    <option value="3" <?php if($equipment->maintenance_frequency == 3){echo 'selected';}?>>3 months</option>
                                                    <option value="4" <?php if($equipment->maintenance_frequency == 4){echo 'selected';}?>>4 months</option>
                                                    <option value="5" <?php if($equipment->maintenance_frequency == 5){echo 'selected';}?>>5 months</option>
                                                    <option value="6" <?php if($equipment->maintenance_frequency == 6){echo 'selected';}?>>6 months</option>
                                                    <option value="7" <?php if($equipment->maintenance_frequency == 7){echo 'selected';}?>>7 months</option>
                                                    <option value="8" <?php if($equipment->maintenance_frequency == 8){echo 'selected';}?>>8 months</option>
                                                    <option value="9" <?php if($equipment->maintenance_frequency == 9){echo 'selected';}?>>9 months</option>
                                                    <option value="10" <?php if($equipment->maintenance_frequency == 10){echo 'selected';}?>>10 months</option>
                                                    <option value="11" <?php if($equipment->maintenance_frequency == 11){echo 'selected';}?>>11 months</option>
                                                    <option value="12" <?php if($equipment->maintenance_frequency == 12){echo 'selected';}?>>12 months</option>
                                                </select>
                                            </div>
                                            <div class="form-group input-group">
                                                    <select class="custom-picker col-sm-6 selectpicker" data-style="btn btn-purple btn-round" name="status" required>
                                                        <option selected disabled hidden>Status</option>
                                                        <option value="active" <?php if($equipment->status == 'active'){echo 'selected';}?>>Active</option>
                                                        <option value="inactive" <?php if($equipment->status == 'inactive'){echo 'selected';}?>>Inactive</option>
                                                    </select>
                                                    <select class="custom-picker col-sm-6 selectpicker" data-style="btn btn-purple btn-round" name="category_id" required>
                                                        <option selected disabled hidden>Category</option>
                                                        @foreach($categories as $category)
                                                        <option value="{{$category->id}}" <?php if($equipment->category_id == $category->id){echo 'selected';}?>>{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                <input type="hidden" value="{{$equipment->user_id}}" name="user_id"/>
                                            </div>
                                            <div class="form-group input-group">
                                                <select class="selectpicker col-sm-12 custom-picker" data-style="btn btn-purple btn-round" name="unit_id" required>
                                                    <option selected disabled hidden>Unit</option>
                                                    @foreach($departments as $department)
                                                        @foreach($department->units as $unit)
                                                            <option value="{{$unit->id}}" <?php if($unit->id == $equipment->unit_id){echo 'selected';}?>>{{$unit->name}} - {{$department->name}}</option>
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <textarea class="form-control" placeholder="Item Description" name="description" required>{{$equipment->description}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="pull-right">
                                        <button type='submit' class='btn btn-purple btn-wd' id="btn_save" disabled  >Save</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div-->

            <div class="content">
                <div class="col-md-10 mr-auto ml-auto">
                    <div class="wizard-container">
                        <div class="card card-wizard" data-color="primary" id="wizardProfile">
                            <form action="#" method="POST" id="edit_item">
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
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="input-group form-control-lg">
                                                                <input type="text" class="form-control" placeholder="Model No. (required)"
                                                                    name="model_number" required="true" value="{{$equipment->model_number}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="input-group form-control-lg">
                                                                <input type="text" placeholder="Serial No. (required)"
                                                                    class="form-control" name="serial_number" required="true" value="{{$equipment->serial_number}}"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 mt-3">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group form-control-lg">
                                                                <input type="text" class="form-control" placeholder="Manufacturer"
                                                                    name="manufacturer_name" required="true" value="{{$equipment->manufacturer_name}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group form-control-lg">
                                                                <input type="number" placeholder="Year of purchase"
                                                                    class="form-control" name="year_of_purchase"
                                                                    required="true" minLength="4" maxLength="4" value="{{$equipment->year_of_purchase}}"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="input-group form-control-lg">
                                                                <input type="number" placeholder="Cost of equipment (in GH&cent;)"
                                                                    class="form-control" name="equipment_cost" required="true" value="{{$equipment->equipment_cost}}"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 mt-3">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="input-group form-control-lg">
                                                                <input type="text" class="form-control datepicker" name="installation_time"
                                                                    required="true" placeholder="Installation date" value="{{date('m/d/Y', strtotime($equipment->installation_time))}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <select class="col-md-12 selectpicker" data-style="btn btn-purple btn-round"
                                                                title="Service Provider" name="service_vendor_id">
                                                                @foreach($vendors as $vendor)
                                                                <option value="{{$vendor->id}}" <?php if($vendor->id == $equipment->service_vendor_id){echo 'selected'; } ?> >{{$vendor->name}}</option>
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
                                                                    placeholder="Equipment Description" rows="2" required="true">{{$equipment->description}}</textarea>
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
                                                                <option value="{{$category->id}}"  <?php if($category->id == $equipment->category_id){echo 'selected'; } ?> >{{$category->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <select class="col-md-12 selectpicker" data-style="btn btn-purple btn-round"
                                                                title="Unit" name="unit_id">
                                                                @foreach($departments as $department)
                                                                    @foreach($department->units as $unit)
                                                                        <option value="{{$unit->id}}"   <?php if($unit->id == $equipment->unit_id){echo 'selected'; } ?> >{{$unit->name}} - {{$department->name}}</option>
                                                                    @endforeach
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <input type="text" name="location" required="true"
                                                                placeholder="Location" class="form-control" value="{{$equipment->location}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h6 class="subtitle">Equipment Status</h6>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="choice <?php if($equipment->status == 'Good'){echo 'active'; } ?>" data-toggle="wizard-radio">
                                                                <input type="radio" name="status" value="Good" <?php if($equipment->status == 'Good'){echo 'selected'; } ?>>
                                                                <div class="icon" color="">
                                                                    <i class="fa fa-check-double"></i>
                                                                </div>
                                                                <h6>Good</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="choice  <?php if($equipment->status == 'Fair'){echo 'active'; } ?>" data-toggle="wizard-radio" >
                                                                <input type="radio" name="status" value="Fair" <?php if($equipment->status == 'Fair'){echo 'selected'; } ?>>
                                                                <div class="icon">
                                                                    <i class="fa fa-check"></i>
                                                                </div>
                                                                <h6>Fair</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="choice <?php if($equipment->status == 'Bad'){echo 'active'; } ?>" data-toggle="wizard-radio">
                                                                <input type="radio" name="status" value="Bad" <?php if($equipment->status == 'Bad'){echo 'selected'; } ?>>
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
                                                            <option value="1" <?php if($equipment->maintenance_frequency == 1){echo 'selected';}?>>1 month</option>
                                                            <option value="2" <?php if($equipment->maintenance_frequency == 2){echo 'selected';}?>>2 months</option>
                                                            <option value="3" <?php if($equipment->maintenance_frequency == 3){echo 'selected';}?>>3 months</option>
                                                            <option value="4" <?php if($equipment->maintenance_frequency == 4){echo 'selected';}?>>4 months</option>
                                                            <option value="5" <?php if($equipment->maintenance_frequency == 5){echo 'selected';}?>>5 months</option>
                                                            <option value="6" <?php if($equipment->maintenance_frequency == 6){echo 'selected';}?>>6 months</option>
                                                            <option value="7" <?php if($equipment->maintenance_frequency == 7){echo 'selected';}?>>7 months</option>
                                                            <option value="8" <?php if($equipment->maintenance_frequency == 8){echo 'selected';}?>>8 months</option>
                                                            <option value="9" <?php if($equipment->maintenance_frequency == 9){echo 'selected';}?>>9 months</option>
                                                            <option value="10" <?php if($equipment->maintenance_frequency == 10){echo 'selected';}?>>10 months</option>
                                                            <option value="11" <?php if($equipment->maintenance_frequency == 11){echo 'selected';}?>>11 months</option>
                                                            <option value="12" <?php if($equipment->maintenance_frequency == 12){echo 'selected';}?>>12 months</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                            <div class="input-group form-control-lg">
                                                                <input type="text" class="form-control datepicker" name="pos_rep_date"
                                                                    required="true" placeholder="Possible replacement date" value="{{date('m/d/Y', strtotime($equipment->pos_rep_date))}}"/>
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
                                        <input type='submit' class='btn btn-fill btn-purple btn-wd' name='finish'
                                            id="btn_save" value='Update' />
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
        $('#edit_item input, textarea').on('input', function(){
            $('#btn_save').prop('disabled', false);
        });
        
        $('.selectpicker').on('change', function(){
            $('#btn_save').prop('disabled', false);
        });

        $('#edit_item').on('submit', function(e){
            e.preventDefault();
            
            $('#btn_save').html('<i class="now-ui-icons loader_refresh spin"></i>');
            var form_data = $(this).serialize();
            $(this).find('input, textarea, select').prop('disabled',true);


            request = $.ajax({
                url: '/api/equipment/update/{{$equipment->code}}',
                method: 'put',
                data: form_data,
                success: function(data, status){
                    $('#btn_save').html('Save');
                    $('#edit_item').find('input, textarea, select').prop('disabled', false);
                    presentNotification('Item successfully added', 'info', 'top', 'right');
                    console.log('done');
                },
                error: function(xhr, desc, err){
                    $('#btn_save').html('Save');
                    $('#edit_item').find('input, textarea, select').prop('disabled', false);
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