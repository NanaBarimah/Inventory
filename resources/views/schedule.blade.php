@extends("layouts.user-dashboard", ["page_title" => "View Schedule"])
    @section("content")
    <div class="content">
        <div class="row">
            <div class="col-md-12 center">
                <div class="card card-calendar">
                    <div class="card-body">
                        <div id="maintenance_schedule">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('scripts')
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/fullcalendar.min.js')}}"></script>
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
    eventClick:function(event)
    {
        item_id = event.title.split(" ");
        swal({
            title: event.title,
            text: event.description
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
@endsection