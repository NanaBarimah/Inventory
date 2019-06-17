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
            @include('layouts.navbar', ['page_title' => 'Request Maintenance'])
            <div class="panel-header panel-header-sm">
            </div>
            
            <div class="content">
                <div class="col-md-8 mr-auto ml-auto">
                    <div>
                        <div class="card" data-color="primary">
                            <form method="post" action="#" id="request_form">
                                <div class="card-header text-center" data-background-color="gray">
                                    <h3 class="card-title">
                                        Request A Maintenance
                                    </h3>
                                    <h3 class="description">Provide details about the maintenance you want carried out.</h5>
                                </div>

                                
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label>Maintenance Type</label>
                                                <select class="selectpicker col-md-12" data-style="btn btn-purple btn-round" name="maintenance_type" title="Select type" required>
                                                    <option value="Planned Maintenance">Planned Maintenance</option>
                                                    <option value="Corrective Maintenance">Corrective Maintenance</option>
                                                    <option value="Emergency Maintenance">Emergency Maintenance</option>
                                                </select>
                                                <input type="hidden" name="hospital_id" value="{{Auth::user()->hospital_id}}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-1">
                                            <div class="form-group">
                                                <label>Equipment</label>
                                                <select class="selectpicker col-md-12" multiple data-style="btn btn-round" name="equipment_codes[]"  data-live-search="true"
                                                 data-selected-text-format="count > 2"  data-show-subtext="true" title="Select equipment" id="equipment_codes" required>
                                                @foreach($equipment as $single)
                                                    <option value="{{$single->code}}" data-subtext="{{$single->unit->name}}">{{$single->code}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12 pr-1">
                                            <div class="form-group">
                                                <label>Provide a detailed description of the maintenance you want carried out.</label>
                                                <div class="input-group">
                                                    <textarea name="description" class="form-control resetable"
                                                        placeholder="Description" required="true"></textarea>
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
        $('#request_form').on('submit', function(e){
            e.preventDefault();
            $('#btn_save').html('<i class="now-ui-icons loader_refresh spin"></i>');
            var form_data = $(this).serialize();
            form_data += '&region_id='+{{$region}};
            $(this).find('input, select').prop('disabled',true);
            request = $.ajax({
                url: '/api/requests/add',
                method: 'post',
                data: form_data,
                success: function(data, status){
                    if(data.error){
                        $('#btn_save').html('Save');
                        $('#request_form').find('input, select').prop('disabled', false);
                        $('#btn_reset').val('Reset');
                        presentNotification(data.message, 'danger', 'top', 'right');
                    }else{
                        $('#btn_save').html('Save');
                        $('#request_form').find('input, select').prop('disabled', false);
                        $('#request_form').find('.resetable').val('');
                        $('#btn_reset').val('Reset');
                        presentNotification('Request sent', 'info', 'top', 'right');
                        console.log('done');
                    }
                },
                error: function(xhr, desc, err){
                    $('#btn_save').html('Save');
                    $('#request_form').find('select, .resetable').prop('disabled', false);
                    presentNotification('Could send your request. Try again.', 'danger', 'top', 'right');
                }
            });
        });
    </script>
</body>

</html>