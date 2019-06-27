@extends('layouts.empty-dashboard', ['page_title' => 'Complete Profile'])
@section('content')
<div class="content">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="title">Complete Profile</h5>
                            </div>
                            <div class="card-body">
                                <form method="post" action="#" id="profile_update_form">
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label><b>First Name</b></label>
                                                <input type="text" class="form-control" placeholder="First Name" value="{{$user->firstname}}" name="firstname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-1">
                                            <div class="form-group">
                                                <label><b>Last Name</b></label>
                                                <input type="text" class="form-control" placeholder="Last Name" value="{{$user->lastname}}" name="lastname" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label><b>Phone Number</b></label>
                                                <input type="text" class="form-control" placeholder="0245668999" value="{{$user->phone_number}}" name="phone_number" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-1">
                                            <div class="form-group">
                                                <label>Job Title</label>
                                                <input type="text" class="form-control" placeholder="Technician" value="{{$user->job_title}}" name="job_title" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control" placeholder="Username" value="{{$user->email}}" name="email" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-8 pr-1">
                                            <div class="form-group">
                                                <label>Role</label>
                                                <p class="form-control" name="role" disabled>{{$user->role}}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="title">Set Password</h5>
                                    <div class="row">
                                        <div class="col-md-6 px-1">
                                            <label>New Password</label>
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="password" id="new_password">
                                                <p class="text-danger text-center" style="font-size:11px; display:none">The passwords you have provided do not match</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-1">
                                            <label>Confirm Password</label>
                                            <div class="form-group">
                                                <input type="password" class="form-control" id="confirm_password"  name="password_confirmation"/>
                                                <p class="text-danger text-center" style="font-size:11px; display:none;">The passwords you have provided do not match</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer text-center">
                                        <button type="submit" id="btn_submit" class="btn btn-wd btn-purple">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-user">
                            <div class="image">
                            </div>
                            <div class="card-body">
                                <div class="author">
                                <img class="round" width="96" height="96" avatar="{{$user->firstname}} {{$user->lastname}}" />
                                    <h5 class="title" id="card-fullname">{{ucfirst($user->firstname)}} {{ucfirst($user->lastname)}}</h5>
                                    <p class="description" id="card-username">
                                        {{$user->email}}
                                    </p>
                                </div>
                                <p class="description text-center">
                                    {{ucfirst($user->role)}}
                                    <br> {{$user->hospital->name}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
@endsection
@section('scripts')
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script>
        $('#profile_update_form').on('submit', (e) => {
            e.preventDefault();
            var form_data = {
                'id' : '{{$user->id}}'
            };

            //TODO : do validations;
            
            $.each($('.form-control'), function(i, el){
                form_data[$(el).attr('name')] = $(el).val();
            });

            $('#btn_submit').html('<i class="now-ui-icons loader_refresh spin"></i>');

            $.ajax({
                url: '/api/user/complete-profile',
                method: 'post',
                data: form_data,
                success: (data, status) => {
                    $('#btn_submit').html('Save');
                    $('#profile_update_form').find('input, select').prop('disabled', false);
                    $('#profile_update_form').find('.resetable').val('');
                    $('#btn_reset').val('Reset');
                    presentNotification('User profile saved', 'info', 'top', 'right');
                    console.log('done');
                },
                error: function(xhr, desc, err){
                    $('#btn_submit').html('Save');
                    $('#profile_update_form').find('.resetable').prop('disabled', false);
                    presentNotification('Could not save this user profile. Try again.', 'danger', 'top', 'right');
                }
            });
        });
    </script>
@endsection