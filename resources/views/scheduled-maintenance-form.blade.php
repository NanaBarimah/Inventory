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
            @include('layouts.navbar', ['page_title' => 'New Maintenance Report'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="col-md-8 mr-auto ml-auto">
                    <div>
                        <div class="card" data-color="primary">
                            <form action="#" method="post" id="maintenance_form">
                                <div class="card-header text-center" data-background-color="gray">
                                    <h3 class="card-title">
                                        Maintenance Report
                                    </h3>
                                    <h3 class="description">Provide details about the maintenance you carried out</h5>
                                </div>

                                <div class="card-body margin-bottom-10">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-10">
                                            <div class="form-group form-control-lg input-group">
                                                <div class="col-md-12 col-sm-12">
                                                    <input type="text" class="form-control" placeholder="Item Code" readonly="readonly" value="{{$code}}" name="equipment_code">
                                                </div>
                                                <input type="hidden" value="Planned Maintenance" name="type"/>
                                            </div>
                                            <div class="form-group form-control-lg input-group">
                                                <div class="col-md-6 col-sm-12">
                                                    <input type="number" class="form-control" placeholder="Maintenance Cost (in GHS)" name="cost" type="number" step="0.01" required/>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                <input class="form-control" placeholder="Maintenance Duration" name="duration" style="height:auto" required/>
                                                </div>
                                            </div>
                                            <div class="form-group form-control-lg input-group">
                                                <div class="col-md-6 col-sm-12">
                                                    <textarea type="number" class="form-control" placeholder="Actions Taken" name="action_taken" required></textarea>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <textarea type="text" placeholder="Recommendations" class="form-control" name="recommendation" required></textarea>
                                                </div>
                                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                                                <input type="hidden" name="type" value="Planned Maintenance"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer ">
                                    <div class="pull-right">
                                        <button type='reset' class='btn btn-wd'>Reset</button>
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
        $('#maintenance_form').on('submit', function(e){
            e.preventDefault();
            $('#btn_save').html('<i class="now-ui-icons loader_refresh spin"></i>');
            var form_data = $(this).serialize();
            $(this).find('input, textarea, select').prop('disabled',true);


            request = $.ajax({
                url: '/api/maintenances/add',
                method: 'post',
                data: form_data,
                success: function(data, status){
                    $('#btn_save').html('Save');
                    $('#maintenance_form').find('input, textarea, select').prop('disabled', false);
                    $('#maintenance_form').find('input, textarea, select').val('');

                    presentNotification('Maintenance recorded', 'info', 'top', 'right');
                    
                    setTimeout(function(){
                        window.location.href = '/maintenance/scheduled';
                    }, 500);
                },
                error: function(xhr, desc, err){
                    $('#btn_save').html('Save');
                    $('#maintenance_form').find('input, textarea, select').prop('disabled', false);
                    presentNotification('Could not record the maintenance. Try again.', 'danger', 'top', 'right');
                }
            });
        });
    </script>
</body>
</html>