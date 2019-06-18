@extends('layouts.user-dashboard', ['page_title' => 'Add Equipment'])
@section('content')
    <div class="content">
        <div class="col-md-12 mr-auto ml-auto">
            <div class="wizard-container">
                <div class="card card-wizard" data-color="primary" id="wizardProfile">
                    <form action="#" method="POST" id="add_new_item">
                        <div class="card-header text-center">
                            <h3 class="card-title">
                                Add New Equipment
                            </h3>

                            <h3 class="description">Complete this form to add a new inventory item</h5>
                                <div class="wizard-navigation">
                                    <ul class="nav nav-pills" style="background-color: rgba(0,0,0,0)">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#about" data-toggle="tab" role="tab"
                                                aria-controls="about" aria-selected="true">
                                                Device Info
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#account" data-toggle="tab" data-toggle="tab"
                                                role="tab" aria-controls="account" aria-selected="false">
                                                Status and Location
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#address" data-toggle="tab" data-toggle="tab"
                                                role="tab" aria-controls="address" aria-selected="false">
                                                Maintenance
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane show active" id="about">
                                    <h5 class="info-text"> Let's start with some basic information about the
                                        device</h5>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="row">
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label><b>Device Name</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control resetable" name="name" required="true"/>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label><b>Asset Code</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control resetable" name="asset_code" required="true"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-11 mt-2">
                                            <div class="row">
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label><b>Serial Number</b></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control resetable" name="serial_number"/>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label><b>Model Number</b></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control resetable" name="model_number"/>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label><b>Manufacturer Name</b></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control resetable" name="manufacturer_name"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-11 mt-3">
                                            <div class="row">
                                                <div class="form-group col-md-6 col-sm-12">
                                                    <label><b>Description</b></label>
                                                    <div class="input-group">
                                                        <textarea type="text" class="form-control" name="description" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group form-file-upload form-file-simple col-md-6">
                                                    <label><b>Image</b></label>
                                                    <input type="text" class="form-control inputFileVisible" placeholder="Select file..." readonly>
                                                    <input type="file" class="inputFileHidden">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="account">
                                    <h5 class="info-text">Now provide further information that will help locate this device</h5>
                                    <div class="row justify-content-center">
                                        <div class="col-lg-11 mb-3">
                                            <div class="row">
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label><b>Category</b></label>
                                                    <div class="input-group">
                                                        <select class="col-md-12 selectpicker" data-style="btn btn-purple"
                                                            title="Equipment type" name="category_id">
                                                            @foreach($asset_categories as $category)
                                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label><b>Unit</b></label>
                                                    <div class="input-group">
                                                        <div id="unit_div" class="col-md-12">    
                                                            <select class="col-md-12 selectpicker" data-style="btn btn-purple"
                                                                title="Unit" name="unit_id">
                                                                @foreach($departments as $department)
                                                                <optgroup label="{{$department->name}}">
                                                                    @foreach($department->units as $unit)
                                                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div id="department_div" class="col-md-12" style="display:none">
                                                            <select class="col-md-12 selectpicker" data-style="btn btn-purple"
                                                                title="Department" name="department_id">
                                                                @foreach($departments as $department)
                                                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="checkbox">
                                                                <span class="form-check-sign"></span>
                                                                Belongs to a department
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label><b>Status</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <select class="col-md-12 selectpicker" data-style="btn btn-purple"
                                                            title="Status" name="status" required="true">
                                                            <option>Good</option>
                                                            <option>Bad</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-11 mb-3">
                                            <div class="row">
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label><b>Installation Date</b></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control datepicker" name="installation_date"/>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label><b>Possible Replacement Date</b></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control datepicker" name="pos_rep_date"/>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label><b>Purchase Date</b></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control datepicker" name="purchasess_date"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-11 mb-3">
                                            <div class="row">
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label><b>Parent Equipment</b></label>
                                                    <div class="input-group">
                                                        <select class="col-md-12 selectpicker" data-style="btn btn-purple"
                                                            title="Parent Equipment" name="parent_id" data-live-search="true">
                                                            @foreach($assets as $asset)
                                                            <option value="{{$asset->id}}" data-subtext="{{$asset->code}}">{{$asset->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label><b>Availability</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <select class="col-md-12 selectpicker" data-style="btn btn-purple"
                                                            title="Availablity" name="availability" required="true">
                                                            <option>Operational</option>
                                                            <option>Not Operational</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 col-sm-12">
                                                    <label><b>Purchase Price (in GHS)</b></label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.01" class="form-control" name="purchase_price"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-11 mb-3">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label><b>Specific Location</b></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="purchase_price"/>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label><b>Procurement Type</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <select class="col-md-12 selectpicker" data-style="btn btn-purple"
                                                            title="Procurement Type" name="procurement_type" required="true">
                                                            <option>Self Purchase</option>
                                                            <option>Donation</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4" id="div_donor" style="display:none;">
                                                    <label><b>Donor</b></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="donor"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="address">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <h5 class="info-text"> Finally, a little information to help with
                                                maintenance </h5>
                                        </div>
                                        <div class="col-lg-11">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">
                                                <select class="col-md-12 selectpicker" data-style="btn btn-purple btn-round"
                                                    title="Associated Parts" name="parts"> 
                                                    <option value="1">1 month</option>
                                                    <option value="2">2 months</option>
                                                    <option value="3">3 months</option>
                                                    <option value="4">4 months</option>
                                                    <option value="5">5 months</option>
                                                    <option value="6">6 months</option>
                                                    <option value="7">7 months</option>
                                                    <option value="8">8 months</option>
                                                    <option value="9">9 months</option>
                                                    <option value="10">10 months</option>
                                                    <option value="11">11 months</option>
                                                    <option value="12">12 months</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                    <div class="input-group form-control-lg">
                                                        <input type="text" class="form-control datepicker" name="pos_rep_date"
                                                            required="true" placeholder="Possible replacement date"/>
                                                    </div>
                                                </div>
                                                <input type="hidden" value="{{Auth::user()->id}}" name="user_id"/>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="pull-right">
                                <input type='button' class='btn btn-next btn-fill btn-rose btn-wd' name='next'
                                    value='Next' />
                                <input type='submit' class='btn btn-finish btn-fill btn-rose btn-wd' name='finish'
                                    id="btn_save" value='Finish' />
                            </div>

                            <div class="pull-left">
                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous'
                                    value='Previous' />
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
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/jquery.bootstrap-wizard.js')}}"></script>
    <script>
        $('#add_new_item').on('submit', function(e){
            e.preventDefault();
            $('#btn_save').html('<i class="now-ui-icons loader_refresh spin"></i>');
            var form_data = $(this).serialize();
            $(this).find('input, textarea, select').prop('disabled',true);
            request = $.ajax({
                url: '/api/equipment/add_equipment',
                method: 'post',
                data: form_data+'&hospital_id={{Auth::user()->hospital_id}}',
                success: function(data, status){
                    $('#btn_save').html('Save');
                    $('#add_new_item').find('input, textarea, select').prop('disabled', false);
                    $('#add_new_item').find('.resetable').val(null);
                    $('#btn_reset').val('Reset');
                    presentNotification('Item successfully added', 'info', 'top', 'right');
                },
                error: function(xhr, desc, err){
                    $('#btn_save').html('Save');
                    $('#add_new_item').find('input, textarea, select').prop('disabled', false);
                    presentNotification('Could not save the item. Try again.', 'danger', 'top', 'right');
                }
            });
        });

        $(document).ready(function () {
        // Initialise the wizard
        demo.initNowUiWizard();
        $('.card.card-wizard').addClass('active');

        demo.initDateTimePicker();
        });
    </script>
@endsection