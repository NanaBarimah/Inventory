@php $user = Auth::user() @endphp
@extends('layouts.user-dashboard', ['page_title' => 'Add Work Order'])
@section('content')
    <div class="content">
        <div class="col-md-12 mr-auto ml-auto">
            <div>
                <div class="card" data-color="primary">
                    <form method="post" action="#" id="add_user_form" class="p=4">
                        <div class="card-header">
                            <h4 class="inline-block">
                                New Work Order
                            </h4>
                        </div>

                        
                    <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6 pr-1">
                                    <div class="form-group">
                                        <label><b>Title</b> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-line resetable" placeholder="Title" name="title" required>
                                    </div>
                                </div>
                                <div class="col-md-3 pl-1">
                                    <div class="form-group">
                                        <label class="pl-3"><b>Priority</b>  <span class="text-danger">*</span></label>
                                        <select class="selectpicker col-md-12" data-style="btn btn-purple btn-round" name="role" title="Priority" required>
                                            <option>Admin</option>
                                            <option>Regular Technician</option>
                                            <option>Limited Technician</option>
                                            <option>Hospital Head</option>
                                            <option>View Only</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 pl-1">
                                    <div class="form-group">
                                        <label class="pl-3"><b>Fault Category</b></label>
                                        <select class="selectpicker col-md-12" data-style="btn btn-purple btn-round" name="role" title="Fault" required>
                                            <option>Admin</option>
                                            <option>Regular Technician</option>
                                            <option>Limited Technician</option>
                                            <option>Hospital Head</option>
                                            <option>View Only</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 pr-1">
                                    <div class="form-group">
                                        <label><b>Due Date</b></label>
                                        <input type="text datepicker" class="form-control resetable" name="due_date">
                                    </div>
                                </div>
                                <div class="col-md-4 pr-1">
                                    <div class="form-group">
                                        <label><b>Estimated Duration (in hours)</b></label>
                                        <input type="text datepicker" class="form-control resetable" name="estimated_duration">
                                    </div>
                                </div>
                                <div class="col-md-4 pr-1">
                                    <div class="form-group">
                                        <label><b>Lead Technician</b></label>
                                        <select class="selectpicker col-md-12" data-style="btn btn-purple btn-round" name="role" title="Lead Technician" required>
                                            <option>Admin</option>
                                            <option>Regular Technician</option>
                                            <option>Limited Technician</option>
                                            <option>Hospital Head</option>
                                            <option>View Only</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 pr-1">
                                    <div class="form-group">
                                        <label><b>Asset</b></label>
                                        <select class="selectpicker col-md-12" data-style="btn btn-purple btn-round" name="role" title="Lead Technician" required>
                                            <option>Admin</option>
                                            <option>Regular Technician</option>
                                            <option>Limited Technician</option>
                                            <option>Hospital Head</option>
                                            <option>View Only</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 pr-1">
                                    <div class="form-group">
                                        <label><b>Job Title</b></label>
                                        <select class="selectpicker col-md-12" data-style="btn btn-purple btn-round" name="role" title="Lead Technician" required>
                                            <option>Admin</option>
                                            <option>Regular Technician</option>
                                            <option>Limited Technician</option>
                                            <option>Hospital Head</option>
                                            <option>View Only</option>
                                        </select>
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

    </script>
@endsection