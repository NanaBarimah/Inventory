
@extends('layouts.user-dashboard', ['page_title' => 'Departments'])
@section('styles')
<style>
    .text-small{
        font-size: 12px;
        vertical-align: center;
        margin-left: -12px;
    }

    .absolute{
        position: absolute;
        right: 0;
        top: 0;
        margin-right: 24px;
    }
</style>
@endsection
@section('content')
    <div class="content">
        <div class="row">
            @foreach($departments as $department)
            <div class="col-md-4 col-sm-12">
                <div class="card card-contributions text-center">
                    <div class="card-body ">
                        <h3 class="card-title">{{$department->name}}</h3>
                        <h5 class="card-category"><i class="fas fa-location"></i> {{$department->location == null ? 'N/A' : $department->location}} </h5>
                        <p class="card-description">
                            <i class="fas fa-phone"></i> {{$department->phone_number == null ? 'N/A' : $department->phone_number}}
                        </p>
                    </div>
                    <hr>
                    <div class="card-footer ">
                        <div class="row">
                            <div class="col-6">
                                <div class="card-stats justify-content-center">
                                    <h3>{{$department->units->count()}} <span class="text-small">units</span></h3>
                                    <div class="dropdown absolute">
                                        <button type="button"
                                            class="btn btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret"
                                            data-toggle="dropdown" style="border:none;">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @foreach($department->units as $unit)
                                            <a class="dropdown-item" href="{{$unit->id}}">{{$unit->name}}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card-stats justify-content-center">
                                    <a href="/department/{{$department->id}}" class="btn btn-primary">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">

        </div>
        @if($user->role == 'Admin')
        <a href="javascript:void(0)" data-target="#addDepartmentModal" data-toggle="modal">
            <div class="fab">
                <i class="fas fa-plus"></i>
            </div>
        </a>
    </div>
    <div class="modal fade" id="addDepartmentModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                        <h6 class="header">New Department</h6>
                    </div>
                    <form method="post" action="#" id="add_new_dept_form">
                        <div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-muted"><b>Department Name</b></label>
                                <input type="text" class="form-control resetable" name="name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-muted"><b>Location</b></label>
                                    <input type="text" class="form-control resetable" name="location">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-muted"><b>Phone</b></label>
                                    <input type="tel" class="form-control resetable" name="phone">
                                </div>
                            </div>
                        </div>
                            <button type="submit" class="pull-right btn btn-purple btn-fill btn-wd" id="btn_submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
@section('scripts')
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script>
        $('#add_new_dept_form').on('submit', function(e){
            e.preventDefault();
            
            $('#btn_submit').html('<i class="now-ui-icons loader_refresh spin"></i>');
            var data = $(this).serialize();
            $(this).find('input').prop('disabled', true);

            $request = $.ajax({
                url: '/api/departments/add',
                method: 'post',
                data: data+'&hospital_id={{Auth::user()->hospital_id}}',
                success: function(data, status){
                    $('#btn_submit').html('Save');
                    $('#add_new_dept_form').find('input').prop('disabled', false);

                    if(data.error){
                        presentNotification(data.message+". Try again.", 'danger', 'top', 'right');
                    }else{
                        var table = $('#datatable').DataTable();
                        table.row.add([
                            $('#dept_name').val(),
                            '<a href="#" class="btn btn-round btn-info btn-icon btn-sm edit" data-toggle="tooltip" data-placement="left" title="Edit"><i class="now-ui-icons design-2_ruler-pencil"></i></a>'
                        ]).draw(true);
                        $('#add_new_dept_form').find('input').html('');
                        presentNotification(data.message, 'success', 'top', 'right');
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    }
                },
                error: function(xhr, desc, err){
                    $('#btn_submit').html('Save');
                    $('#add_new_dept_form').find('input').prop('disabled', false);
                    presentNotification('Could not save the Department. Try again.', 'danger', 'top', 'right');

                    console.log(err);
                }
            });
        });


        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href");
            if (target == '#new_operator') {
                $('#new_operator').find('input').prop('disabled', false);
                $('#old_operator').find('select').prop('disabled', true);
            } else if(target == '#old_operator'){
                $('#new_operator').find('input').prop('disabled', true);
                $('#old_operator').find('select').prop('disabled', false);
            }
        });
        
    </script>
@endsection