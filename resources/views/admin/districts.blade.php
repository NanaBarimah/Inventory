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
            @include('layouts.admin_navbar', ['page_title' => 'Districts'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-10 center">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="inline-block">Districts</h4>
                                <a href="#" data-toggle="modal" data-target="#addDistrictModal" class="btn btn-purple pull-right">Add New</a>
                            </div>
                            <div class="card-body">
                                <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th class="disabled-sorting">Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th class="disabled-sorting">Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($districts as $district)
                                        <tr>
                                            <td>{{$district->name}}</td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#editDistrictModal" class="btn btn-round btn-info btn-icon btn-sm edit">
                                                    <i class="now-ui-icons design-2_ruler-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addDistrictModal" tabindex="-1" role="dialog" aria-labelledby="addDistrictLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="modal-title margin-bottom-10" id="addDistrictLabel">Add District</h5>
                        <form method="post" action="#" id="add_district">
                            <div class="form-group">
                                <input type="text" class="form-control normal-radius" placeholder="District Name" name="name" id="district_name"/>
                                <input type="hidden" name="region_id" value="{{Auth::guard('admin')->user()->region_id}}"/>
                                <span class="text-danger hidden">Enter a district name</span>
                                <button type="submit" class="pull-right btn btn-purple btn-fill btn-wd" id="btn_save">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editDistrictModal" tabindex="-1" role="dialog" aria-labelledby="editDistrictLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="modal-title margin-bottom-10" id="editDistrictLabel">Edit District</h5>
                        <form method="post" action="#" id="add_district">
                            <div class="form-group">
                                <input type="text" class="form-control normal-radius" placeholder="District Name" name="name" id="district_name"/>
                                <input type="hidden" name="region_id" value="{{Auth::guard('admin')->user()->region_id}}"/>
                                <span class="text-danger hidden">Enter a district name</span>
                                <button type="submit" class="pull-right btn btn-purple btn-fill btn-wd" id="btn_save">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.admin_core_scripts')
    <script src="{{asset('js/datatables.js')}}"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Find a district",
                }

            });

            var table = $('#datatable').DataTable();

        });

        $('#add_district').on('submit', function(e){
            e.preventDefault();

            if($('#district_name').val().length < 1){
                $('.text-danger').css('display', 'inline');
                return false;
            }
            
            $('.text-danger').css('display', 'none');
            $('#btn_save').html('<i class="now-ui-icons loader_refresh spin"></i>');
            var form_data = $(this).serialize();
            $(this).find('input').prop('disabled', true);

            request = $.ajax({
                url : '/api/districts/add_district',
                method : 'post',
                data : form_data,
                success : function(data, status){
                    $('#btn_save').html('Save');

                    if(data.error){
                        presentNotification(data.message+". Try again.", 'danger', 'top', 'right');
                    }else{
                        var table = $('#datatable').DataTable();
                        table.row.add([
                                $('#district_name').val(),
                                '<a href="#" class="btn btn-round btn-info btn-icon btn-sm edit" data-toggle="tooltip" data-placement="left" title="Edit"><i class="now-ui-icons design-2_ruler-pencil"></i></a>'
                        ]).draw(true);
                        $('#add_district').find('[type="text"]').val('');
                        $('#add_district').find('input').prop('disabled', false);
                        presentNotification('District saved', 'info', 'top', 'right');
                    }
                },
                error : function(xhr, err, desc){
                    $('#btn_save').html('Save');
                    $('#add_district').find('input').prop('disabled', false);
                    presentNotification('Could not save district', 'danger', 'top', 'right');
                }
            })
        });
    </script>
</body>

</html>