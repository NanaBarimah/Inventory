@extends('layouts.user-dashboard', ['page_title' => 'Categories'])
@section('styles')
<style>
.add_new{
    text-transform: capitalize;
    font-size: 12px;
    text-decoration: underline;
    margin-left: 12px;
}
</style>
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills nav-pills-primary text-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#assets" role="tablist">
                                Asset Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#faults" role="tablist">
                                Fault Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#works" role="tablist">
                                Work Order Priorities
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content tab-space">
                        <div class="tab-pane active" id="assets">
                            <h6 class="header">Asset Categories <span class="add_new"><a href="javascript:void(0)" data-toggle="modal" data-target="#asset-modal">Add New</a></span></h6>
                            <table id = "asset_table" class="data-table table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            Category Name
                                        </th>
                                        <th>
                                            Child Categories
                                        </th>
                                        <th  class="disabled-sorting text-right">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>
                                            Category Name
                                        </th>
                                        <th>
                                            Subcategories
                                        </th>
                                        <th class="disabled-sorting text-right">
                                            Actions
                                        </th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        <td>
                                            Computers
                                        </td>
                                        <td>
                                            <div class="col-md-12">
                                                <span class="text-muted">Laptops</span>
                                                <span class="dropdown">
                                                    <button type="button"
                                                        class="btn btn-default dropdown-toggle btn-simple btn-icon no-caret"
                                                        data-toggle="dropdown" style="border:none;">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">Edit User</a>
                                                        <a class="dropdown-item text-danger" href="#">Deactivate User</a>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="col-md-12">
                                                <span class="text-muted">Laptops</span>
                                                <span class="dropdown">
                                                    <button type="button"
                                                        class="btn btn-default dropdown-toggle btn-simple btn-icon no-caret"
                                                        data-toggle="dropdown" style="border:none;">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">Edit User</a>
                                                        <a class="dropdown-item text-danger" href="#">Deactivate User</a>
                                                    </div>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <a href="javascript:void(0)">
                                                <i class="fas fa-pen text-muted"></i>
                                            </a>
                                            &nbsp;
                                            <a href="javascript:void(0)">
                                                <i class="fas fa-trash text-danger"></i>
                                            </a>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="faults">
                        <h6 class="header">Fault Categories <span class="add_new"><a href="javascript:void(0)" data-toggle="modal" data-target="#faults-modal">Add New</a></span></h6>
                            <table id = "faults_table" class="data-table table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            Category Name
                                        </th>
                                        <th  class="disabled-sorting text-right">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>
                                            Category Name
                                        </th>
                                        <th class="disabled-sorting text-right">
                                            Actions
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="tab-pane" id="works">
                        <h6 class="header">Work Asset Categories <span class="add_new"><a href="javascript:void(0)" data-toggle="modal" data-target="#priority-modal">Add New</a></span></h6>
                            <table id = "works_table" class="data-table table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            Category Name
                                        </th>
                                        <th  class="disabled-sorting text-right">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>
                                            Category Name
                                        </th>
                                        <th class="disabled-sorting text-right">
                                            Actions
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="asset-modal" class="modal fade right">
  <div class="modal-dialog">
    <form method = "post" id="new_asset_category">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                <h6 class="header">New Asset Category</h6>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><b>Category Name</b></label>
                        <input type="tel" class="form-control resetable" name="name">
                    </div>
                </div>
                <div class="form-check mt-3">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="is_sub_category">
                        <span class="form-check-sign"></span>
                        This category is a subcategory
                    </label>
                </div>
                <div class="col-md-12 mt-3" style="display:none;" id="div_select_parent">
                    <div class="form-group">
                        <label><b>Parent Category</b></label>
                        <select class="selectpicker col-md-12" title="Parent Category" data-live-search="true">
                            <option>Electronics</option>
                            <option>Other option</option>
                            <optgroup label="Some group">
                                <option>Some sub option</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-4 right">
                <button type="submit" class="btn btn-custom">Save</button>
            </div>
        </div>
    </form>
  </div>
</div>
<div id="faults-modal" class="modal fade right">
  <div class="modal-dialog">
    <form method = "post" id="new_fault_category">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                <h6 class="header">New Fault Category</h6>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><b>Fault Type Name</b></label>
                        <input type="tel" class="form-control resetable" name="name">
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-4 right">
                <button type="submit" class="btn btn-custom">Save</button>
            </div>
        </div>
    </form>
  </div>
</div>
<div id="priority-modal" class="modal fade right">
  <div class="modal-dialog">
    <form method = "post" id="new_priority_category">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                <h6 class="header">New Work Order Priority Type</h6>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><b>Priority Type</b></label>
                        <input type="tel" class="form-control resetable" name="name">
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-4 right">
                <button type="submit" class="btn btn-custom">Save</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });

            let asset_table = $('#asset_table').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Find an item",
                    sEmptyTable: "No asset categories created"
                }
            });
        
            let faults_table = $('#faults_table').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Find an item",
                    sEmptyTable: "No fault categories created"
                }
            });

            let works_table = $('#works_table').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Find an item",
                    sEmptyTable: "No work order priorities created"
                }
            });
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

        $('#is_sub_category').on('change', function(){
            if($(this).prop('checked')){
                $('#div_select_parent').css('display', 'block');
            }else{
                $('#div_select_parent').css('display', 'none');
            }
        })
    </script>
@endsection