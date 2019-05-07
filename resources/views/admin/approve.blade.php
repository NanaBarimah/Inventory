<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Inventory Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport'
    />
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <!-- Styles -->
    <!--link href="{{ asset('css/app.css') }}" rel="stylesheet"-->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/now-ui-dashboard.min.css?v=1.2.0')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/main.css')}}" />
</head>

<body>
    <div class="wrapper">
        @include('layouts.admin_sidebar')
        <div class="main-panel">
            @include('layouts.admin_navbar', ['page_title' => 'Maintenance Approval'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-10 center">
                        <div class="card">
                            <div class="card-header text-center" data-background-color="gray">
                                <h3 class="card-title">
                                   Maintenance Approval
                                </h3>
                                <h3 class="description">Toggle to approve / disapprove a maintenance</h3>
                            </div>
                            <div class="card-body">
                                <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Job No.</th>
                                            <th>Equipment No.</th>
                                            <th>Maintenance Type</th>
                                            <th>Maintenance Date</th>
                                            <th>Reported</th>
                                            <th>Approve</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Job No.</th>
                                            <th>Equipment No.</th>
                                            <th>Maintenance Type</th>
                                            <th>Maintenance Date</th>
                                            <th>Reported</th>
                                            <th>Approve</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($maintenances as $maintenance)
                                        <tr class="uppercase">
                                            <td>
                                                <a href="#">{{$maintenance->id}}</a>
                                            </td>
                                            <td>{{$maintenance->equipment_code}}</td>
                                            <td>{{$maintenance->type}}</td>
                                            <td>{{Carbon\Carbon::parse($maintenance->date_inspected)->format('M d Y')}}</td>
                                            <td>{{Carbon\Carbon::parse($maintenance->created_at)->diffForHumans()}}</td>
                                            <td>
                                                <input type="checkbox" class="bootstrap-switch"  id="toggle-{{$maintenance->id}}" <?php if($maintenance->is_approved == 1){echo 'checked';}?>
                                                data-on-label="<i class='now-ui-icons ui-1_check'></i>" 
                                                data-off-label="<i class='now-ui-icons ui-1_simple-remove'></i>" onchange="approve(this, {{$maintenance}})"/>
                                                <span id="check-{{$maintenance->id}}" style="display: none"><i class="now-ui-icons loader_refresh spin"></i></span>
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
        </div>
    </div>
    
    <!--   Core JS Files   -->
    <!--script src="{{ asset('js/app.js') }}" defer></script-->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('js/now-ui-dashboard.min.js?v=1.2.0')}}" type="text/javascript"></script>
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });

            $('#datatable').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Find an item",
                }
            });

            var table = $('#datatable').DataTable();
        });


        //approve function comes here
        function approve(el, maintenance){
            var is_approved = maintenance.is_approved;
            var id = maintenance.id;

            $('#check-{{$maintenance->id}}').css('display', 'inline');
            if($('#toggle-{{$maintenance->id}}').prop('checked') == true){
                is_approved = 1;
            }else{
                is_approved = 0;
            }

            var form_data = "id="+id+"&is_approved="+is_approved;
                
            $.ajax({
                url : '/api/maintenances/admin-approve',
                method: 'put',
                data : form_data,
                success: function(data, status){
                    $('#check-{{$maintenance->id}}').css('display', 'none');
                    if(data.error){
                        presentNotification(data.message, 'danger', 'top', 'right');
                    }else{

                        if(is_approved == 1){
                            Swal.fire(
                                'All Done!',
                                'The maintenance has been approved.',
                                'success'
                            );
                        }else{
                            Swal.fire(
                                'Updated!',
                                'The maintenance approved status has been revoked.',
                                'success'
                            );
                        }
                    }
                },

                error : function(xhr, desc, err){
                    $('#check-{{$maintenance->id}}').css('display', 'none');
                    presentNotification('Network error', 'danger', 'top', 'right');
                }
            });
        }

        
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
</body>

</html>