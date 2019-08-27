<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Inventory Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <!--link href="{{ asset('css/app.css') }}" rel="stylesheet"-->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/now-ui-dashboard.min.css?v=1.2.0')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/main.css')}}" />
</head>

<body>
    <div class="wrapper ">
        @include('layouts.admin_sidebar')
        <div class="main-panel">
            @include('layouts.admin_navbar', ['page_title' => 'Add Donation'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="col-md-12 mr-auto ml-auto">
                    <div>
                        <div class="card">
                            <form action="#" method="POST" id="add_donation">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Record New Donation
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <div class="row justify-content-center">
                                            <div class="col-sm-11">
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label><b>Donation Title</b> <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control resetable" name="title" required="true"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-4 col-sm-12">
                                                        <label><b>Equipment</b> <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <select class="col-md-12 selectpicker" data-style="form-control" data-show-tick="true"
                                                            name="equipment[]" multiple title="Equipment" data-live-search="true" data-show-subtext = "true" required>
                                                                @foreach($region->equipment as $eq)
                                                                   <option value="{{$eq->id}}" data-subtext="{{$eq->serial_number}}">{{$eq->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4 col-sm-12">
                                                        <label><b>Hospital</b> <span class="text-danger">*</span></label>
                                                        <select class="col-md-12 selectpicker" data-style="form-control" data-show-tick="true"
                                                        name="hospital_id" data-live-search="true" title="Hospital" required>
                                                            @foreach($region->districts as $district)
                                                                @foreach($district->hospitals as $hospital)
                                                                <option value="{{$hospital->id}}">{{$hospital->name}}</option>
                                                                @endforeach
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4 col-sm-12">
                                                        <label><b>Date Donated</b> <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control datepicker resetable" name="date_donated" required="true"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label><b>Presented To</b></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control resetable" name="presented_to"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label><b>Presented By</b> <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control resetable" name="presented_by"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-sm-12">
                                                        <label><b>Description</b></label>
                                                        <div class="input-group">
                                                            <textarea class="form-control" name="description"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="pull-right">
                                        <button type='submit' class='btn btn-purple btn-fill btn-rose btn-wd mb-4'>Save</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.admin_core_scripts')
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script>
        demo.initDateTimePicker();

        $("#add_donation").on("submit", function(e){
            e.preventDefault();
            let data = $(this).serialize();
            data += "&region_id={{$admin->region_id}}";
            let btn = $(this).find("[type=submit]");

            submit_form("/api/donations/add", "post", data, undefined, btn, true);
        })
    </script>
</body>

</html>