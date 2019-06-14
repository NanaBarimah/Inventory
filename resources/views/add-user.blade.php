@extends('layouts.user-dashboard', ['page_title' => 'Add user'])
@section('content')
    <div class="content">
        <div class="col-md-10 mr-auto ml-auto">
            <div>
                <div class="card" data-color="primary">
                    <form method="post" action="#" id="add_user_form" class="p=4">
                        <div class="card-header">
                            <h4 class="inline-block">
                                New User
                            </h4>
                        </div>

                        
                    <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6 pr-1">
                                    <div class="form-group">
                                        <label><b>Email address</b> <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control form-line resetable" placeholder="Email Address" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-5 pl-1">
                                    <div class="form-group">
                                        <label class="pl-3"><b>Role</b>  <span class="text-danger">*</span></label>
                                        <select class="selectpicker col-md-12" data-style="btn btn-purple btn-round" name="role" title="System Role" required>
                                            <option>Admin</option>
                                            <option>Regular Technician</option>
                                            <option>Limited Technician</option>
                                            <option>Hospital Head</option>
                                            <option>View Only</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <p class="text-muted"><b>Personal Information</b></p>
                            </div>
                            <div class="row">
                                
                                
                                <div class="col-md-6 pr-1">
                                    <div class="form-group">
                                        <label><b>First Name</b></label>
                                        <input type="text" class="form-control resetable" name="firstname">
                                    </div>
                                </div>
                                <div class="col-md-6 pr-1">
                                    <div class="form-group">
                                        <label><b>Last Name</b></label>
                                        <input type="text" class="form-control resetable" name="lastname">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 pr-1">
                                    <div class="form-group">
                                        <label><b>Phone</b></label>
                                        <input type="tel" class="form-control resetable" name="phone_number">
                                    </div>
                                </div>
                                <div class="col-md-6 pr-1">
                                    <div class="form-group">
                                        <label><b>Job Title</b></label>
                                        <input type="tel" class="form-control resetable" name="phone_number">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="d-block">
                                <p class="text-muted text-small">All fields marked (<span class="text-danger">*</span>) are mandatory</p>
                            </div>
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
@endsection
@section('scripts')
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script>
        $('#add_user_form').on('submit', function(e){
            e.preventDefault();
            var form_data = $(this).serialize();
            form_data+='&hospital_id={{Auth::user()->hospital_id}}';
            $(this).find('input, select').prop('disabled',true);

            $('#btn_save').html('<i class="now-ui-icons loader_refresh spin"></i>');

            $.ajax({
                url: '/api/users/add_user',
                method: 'post',
                data: form_data,
                success: function(data, status){
                    $('#btn_save').html('Save');
                    $('#add_user_form').find('input, select').prop('disabled', false);
                    $('#add_user_form').find('.resetable').val('');
                    $('#btn_reset').val('Reset');
                    presentNotification('User saved', 'info', 'top', 'right');
                    console.log('done');
                },
                error: function(xhr, desc, err){
                    $('#btn_save').html('Save');
                    $('#add_user_form').find('.resetable').prop('disabled', false);
                    presentNotification('Could not save this user. Try again.', 'danger', 'top', 'right');
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
    </script>
@endsection