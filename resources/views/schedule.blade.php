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
            @include('layouts.navbar', ['page_title' => 'Schedule'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-10 center">
                        <div class="card card-calendar">
                            <div class="card-body">
                                <div id="maintenance_schedule">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5 class="modal-title margin-bottom-10" id="addCategoryLabel">Schedule Maintenance</h5>
                            <form method="post" action="#" id="add_new_maintenance">
                                <div class="form-group">
                                    <select class="selectpicker form-control" data-style="btn btn-primary btn-round" name="equipment_code" required>
                                        <option selected disabled hidden>Equipment</option>
                                        @foreach($equipment as $single)
                                        <option value="{{$single->code}}">{{$single->code}} - {{$single->manufacturer_name}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control" id="maintenance_date" name="maintenance_date" readonly/>
                                </div>
                                <div class="form-group">
                                    <select class="selectpicker" data-style="btn btn-primary btn-round" name="maintenance_type" required>
                                        <option selected disabled hidden>Maintenance Type</option>
                                        <option value="Emergency Maintenance">Emergency Maintenance</option>
                                        <option value="Corrective Maintenance">Corrective Maintenance</option>
                                    </select>
                                </div>
                                <button type="submit" class="pull-right btn btn-purple btn-fill btn-wd" id="btn_submit">Save</button>
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
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js'></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/fullcalendar.min.js')}}"></script>
    <script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('js/now-ui-dashboard.min.js?v=1.2.0')}}"></script>
    <script src="{{asset('js/sweetalert2.js')}}"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script>
    
  $(document).ready(function() {
   var calendar = $('#maintenance_schedule').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events: '/schedule/fetch_all',
    selectable:true,
    selectHelper:true,
    select: function(start, end, allDay)
    {
        var start = $.fullCalendar.formatDate(start, "YYYY-MM-DD");
        $('#addEventModal').modal('show');
        $("#maintenance_date").val(start);
    },

    eventClick:function(event)
    {
        item_id = event.title.split(" ");
        swal({
            title: item_id[0],
            text: item_id[2]+' Maintenance to be carried out on '+item_id[0]+' on '+$.fullCalendar.formatDate(event.start, 'Do MMMM, YYYY')
        })
    },

   });
  });
   
  $('#add_new_maintenance').on('submit', function(e){
      e.preventDefault();
      $('#btn_submit').html('<i class="now-ui-icons loader_refresh spin"></i>');
        var formData = $(this).serialize();
        $(this).find('input').prop('disabled', true);

        request = $.ajax({
            url : '/api/schedule/add',
            method : 'post',
            data : formData,
            success : function(data, status){
                $('#btn_submit').html('Save');
                $('#add_new_maintenance').find('input').prop('disabled', false);
                $('#add_new_maintenance').find('#equipment_code').val('');

                var eventData = {
                    title : formData.equipment_code+' - '+formData.maintenance_type,
                    start : formData.maintenance_date,
                    end : formData.maintenance_date
                }


                $("#maintenance_schedule").fullCalendar('renderEvent', eventData, true);
                presentNotification('Schedule saved', 'info', 'top', 'right');
            },

            error : function(xhr, desc, error){
                $('#btn_submit').html('Save');
                $('#add_new_maintenance').find('input').prop('disabled', false);
                presentNotification('No item with the specified code', 'danger', 'top', 'right');
            }
        });
  });
  </script>
</body>

</html>