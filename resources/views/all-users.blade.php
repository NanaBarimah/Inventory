    @extends('layouts.user-dashboard', ['page_title' => 'Users'])
    @section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12 center">
                <div class="card">
                    <div class="card-header">
                        <h4 class="inline-block">System Users</h4>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email Address</th>
                                    <th>Role</th>
                                    <th>Phone No.</th>
                                    <th>Job Title</th>
                                    <th>Profile Status</th>
                                    <th class="disabled-sorting text-right">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email Address</th>
                                    <th>Role</th>
                                    <th>Phone No.</th>
                                    <th>Job Title</th>
                                    <th>Profile Status</th>
                                    <th class="disabled-sorting text-right">Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr class="uppercase">
                                    <td>
                                        Kwame Gyan
                                    </td>
                                    <td style="text-transform:lowercase;">kwamegyan@codbitgh.com</td>
                                    <td>Admin</td>
                                    <td>0244111666</td>
                                    <td>Senior Engineer</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret"
                                                data-toggle="dropdown">
                                                <i class="now-ui-icons loader_gear"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#">Edit User</a>
                                                <a class="dropdown-item text-danger" href="#">Deactivate User</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <a href="/users/add">
            <div class="fab">
                +
            </div>
        </a>
    </div>
    @endsection
    @section('scripts')
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
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

        /*$('#active').on('switchChange.bootstrapSwitch', function(e, s){
            var form_data = $('toggle_active').serialize();
            alert(form_data);

            request = $.ajax({
                url : '/api/users/activate',

            })
        });*/

        function setActive(user, el){
            var active;
            var id = user.id;

            if(el.checked == 1){
                active = 1;
            }else{
                active = 0;
            }

            var form_data = "user_id="+id+"&active="+active;
            
            $.ajax({
                url : '/api/users/activate',
                method: 'put',
                data : form_data,
                success: function(data, status){
                    if(data.error){
                        presentNotification(data.message, 'danger', 'top', 'right');
                    }else{
                        presentNotification(data.message, 'info', 'top', 'right');
                    }
                },

                error : function(xhr, desc, err){
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
    @endsection