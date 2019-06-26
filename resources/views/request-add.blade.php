@extends('layouts.user-dashboard', ['page_title' => 'Add Work Order Request'])
@section('content')
<div class="content">
    <div class="col-md-12 mr-auto ml-auto">
        <div>
            <div class="card" data-color="primary">
                <form method="post" action="#" id="add_request_form" class="p=4">
                    <div class="card-header">
                        <h4 class="inline-block">
                            Create Work Order Request
                        </h4>
                    </div>

                    
                <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 pr-1">
                                <div class="form-group">
                                    <label><b>Title</b> <span class="text-danger">*</span></label>
                                    <input class="form-control form-line resetable" placeholder="Title" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-4 pl-1">
                                <div class="form-group">
                                    <label class="pl-3"><b>Role</b>  <span class="text-danger">*</span></label>
                                    <select class="selectpicker col-md-12" data-style="btn btn-purple btn-round" name="priority_id" title="Priority" required>
                                        @foreach($hospital->priorities as $priority)
                                        <option value="{{$priority->id}}">{{$priority->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4 pr-1">
                                <div class="form-group">
                                    <label><b>Department</b></label>
                                    <select class="selectpicker col-md-12" data-style="btn form-control" name="department_id" title="Department" id="department" data-show-tick="true">
                                    @if($hospital->departments->count() > 0)
                                        @foreach($hospital->departments as $department)
                                        <option value="{{$department->id}}" data-units = "{{$department->units}}">{{$department->name}}</option>
                                        @endforeach
                                    @else
                                        <option disabled>No known departments</option>
                                    @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 pr-1">
                                <div class="form-group">
                                    <label><b>Unit</b></label>
                                    <select class="selectpicker col-md-12" data-style="btn form-control" name="unit_id" id="unit" title="Unit" data-show-tick="true">
                                        <option disabled>Select a department</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 pr-1">
                                <div class="form-group">
                                    <label><b>Assets</b></label>
                                    <select class="selectpicker col-md-12" data-style="btn form-control" name="asset_id" title="Equipment" 
                                    data-show-tick="true" data-live-search="true">
                                        @if($hospital->assets->count() > 0)
                                            @foreach($hospital->assets as $asset)
                                            <option value="{{$asset->id}}">{{$asset->name}}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No assets recorded</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-9 pr-1">
                                <div class="form-group form-file-upload form-file-simple">
                                    <label><b>Description</b></label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-1">
                                <div class="form-group form-file-upload form-file-simple">
                                    <label><b>Attach Image</b></label>
                                    <input type="text" class="form-control inputFileVisible" placeholder="Simple chooser...">
                                    <input type="file" class="inputFileHidden" name="image">
                                </div>
                            </div>
                            <div class="col-md-6 pr-1">
                                <div class="form-group form-file-upload form-file-simple">
                                    <label><b>Attach File</b></label>
                                    <input type="text" class="form-control inputFileVisible" placeholder="Simple chooser...">
                                    <input type="file" class="inputFileHidden" name="fileName">
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
        $("#add_request_form").on("reset", function(){
            $('.selectpicker').selectpicker("refresh");
        });

        $('input[type="file"]').change(function(e){
            const file_name = e.target.files[0].name;
            $(this).closest("div").find(".inputFileVisible").val(file_name);
        });

        $("#add_request_form").on("submit", function(e){
            e.preventDefault();

            let data = new FormData(this);
            data.append("hospital_id", '{{Auth::user()->hospital_id}}');
            data.append("requested_by", '{{Auth::user()->id}}');
            let btn = $(this).find('[type="submit"]');
            submit_file_form("/api/requests/add", "post", data, undefined, btn, true);
        });

        $("#department").on("change", function(){
            $("#unit").val(null);
            $("#unit").html(null);

            let units = $(this).find(":selected").data("units");

            if(units.length > 0){
                $("#unit").selectpicker("refresh");

                $.each(units, function(index, unit){
                    $("#unit").append(`<option value="${unit.id}">${unit.name}</option>`);
                });

            }else{
                $("#unit").append(`<option disabled>No units for this department</option>`);
            }

            $("#unit").selectpicker("refresh");
        });
    </script>
@endsection