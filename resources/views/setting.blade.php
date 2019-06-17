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
            @include('layouts.navbar', ['page_title' => 'Settings'])
            <div class="panel-header panel-header-sm">
            </div>
            
            <div class="content">
                <div class="col-md-8 mr-auto ml-auto">
                    <div>
                        <div class="card" data-color="primary">
                            <form action="#" method="post">
                                <div class="card-header text-center" data-background-color="gray">
                                    <h3 class="card-title">
                                        Notification Settings
                                    </h3>
                                </div>

                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-9">
                                            <div class="form-group input-group">
                                                <div class="col-sm-6">
                                                    <select class="selectpicker" data-style="btn btn-purple btn-round" style="width:100%;" id="duration">
                                                        <option selected disabled hidden>Notification Frequency</option>
                                                        <option value="1">Daily</option>
                                                        <option value="7">Weekly</option>
                                                        <option value="14">Bi-Weekly</option>
                                                        <option value="28">Monthly</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <select class="selectpicker" multiple data-style="btn btn-primary btn-round"  data-live-search="true" data-selected-text-format="count > 2" title="Recipients" id="recipients">
                                                        @foreach($admins as $admin)
                                                        <option value="{{$admin->id}}">{{$admin->firstname}} {{$admin->lastname}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" value="{{Auth::user()->hospital_id}}" id="hospital_id"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="pull-right">
                                        <input type='reset' class='btn btn-wd' value='Reset' />
                                        <input type='submit' class='btn btn-purple btn-wd' value='Save' id="save"/>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                            </form>
                        </div>
                    </div> <!-- wizard container -->
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
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script>
      $('#save').on('click', function(e){
        e.preventDefault();

        var recipients = $('#recipients').val();
        var hospital_id = $('#hospital_id').val();
        var duration = $('#duration').val();

        $.ajax({
          url : '/api/settings/save',
          data : 'hospital_id='+hospital_id+'&user_ids='+recipients+'&duration='+duration,
          method : 'POST',

          success : function(res, status){
            console.log(res);
          },

          error : function(xhr, desc, err){
            console.log(err);
          }
        });

      });
    </script>
</body>

</html>