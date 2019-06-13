@extends('layouts.user-dashboard', ['page_title' => 'Complete Profile'])
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
                                                <input type="text" class="form-control" placeholder="First Name" value="{{$user->firstname}}" name="firstname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-1">
                                            <div class="form-group">
                                                <label>Job Title</label>
                                                <input type="text" class="form-control" placeholder="Last Name" value="{{$user->lastname}}" name="lastname" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control" placeholder="Username" value="{{$user->email}}" name="username" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-8 pr-1">
                                            <div class="form-group">
                                                <label>Role</label>
                                                <p class="form-control" disabled>{$user->role}}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="title">Set Password</h5>
                                    <div class="row">
                                        <div class="col-md-6 px-1">
                                            <label>New Password</label>
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="new_password" id="new_password">
                                                <p class="text-danger text-center" style="font-size:11px; display:none">The passwords you have provided do not match</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-1">
                                            <label>Confirm Password</label>
                                            <div class="form-group">
                                                <input type="password" class="form-control" id="confirm_password">
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
                                <img class="round" width="96" height="96" avatar="{{Auth::user()->firstname}} {{Auth::user()->lastname}}" />
                                    <h5 class="title" id="card-fullname">{{ucfirst($user->firstname)}} {{ucfirst($user->lastname)}}</h5>
                                    <p class="description" id="card-username">
                                        {{$user->email}}
                                    </p>
                                </div>
                                <p class="description text-center">
                                    {{ucfirst($user->role)}}
                                    <br> {{$hospital->name}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
@endsection