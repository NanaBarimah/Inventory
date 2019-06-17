@php $user = Auth::user() @endphp
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
                            <a class="nav-link" data-toggle="tab" href="#spare-parts" role="tablist">
                               Spare Part Categories
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
                            <h6 class="header">Asset Categories <span class="add_new"><a href="javascript:void(0)" data-toggle="modal" data-target="#asset-modal">Add New</a></span><span class="add_new"><a href="javascript:void(0)" data-toggle="tooltip" title="Import CSV">Import CSV</a></span></h6>
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
                                    @foreach($parent_categories as $category)
                                        <tr>
                                            <td>
                                                {{$category->name}}
                                            </td>
                                            <td>
                                                @if($category->children->count() > 0)
                                                @foreach($category->children as $child)
                                                <div class="col-md-12">
                                                    <span class="text-muted">{{$child->name}}</span>
                                                    <span class="dropdown">
                                                        <button type="button"
                                                            class="btn btn-default dropdown-toggle btn-simple btn-icon no-caret"
                                                            data-toggle="dropdown" style="border:none;">
                                                            <i class="fas fa-cog"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0)"  onclick="edit_asset_category('{{$child->name}}', '{{$child->id}}', '{{$category->id}}')">Edit Asset Category</a>
                                                            <a class="dropdown-item text-danger" href="javascript:void(0)">Delete Asset Category</a>
                                                        </div>
                                                    </span>
                                                </div>
                                                @endforeach
                                                @else
                                                <div class="col-md-12">
                                                    <span class="text-muted">
                                                        N/A
                                                    </span>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <a href="javascript:void(0)" data-toggle="tooltip" title = "Edit"  onclick="edit_asset_category('{{$category->name}}', '{{$category->id}}', undefined, {{$category->children->count() > 0 ? true : false}})">
                                                    <i class="fas fa-pen text-muted"></i>
                                                </a>
                                                &nbsp;
                                                <a href="javascript:void(0)" data-toggle="tooltip" title = "Delete">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </a>
                                                &nbsp;
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="spare-parts">
                            <h6 class="header">Spare Part Types <span class="add_new"><a href="javascript:void(0)" data-toggle="modal" data-target="#spare-part-modal">Add New</a></span><span class="add_new"><a href="javascript:void(0)" data-toggle="tooltip" title="Import CSV">Import CSV</a></span></h6>
                            <table id = "spare_parts_table" class="data-table table table-striped">
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
                                <tbody>
                                    @foreach($part_categories as $category)
                                        <tr>
                                            <td>
                                                {{$category->name}}
                                            </td>
                                            <td class="text-right">
                                                <a href="javascript:void(0)" data-toggle="tooltip" title = "Edit" onclick="edit_spare_part('{{$category->name}}', '{{$category->id}}')">
                                                    <i class="fas fa-pen text-muted"></i>
                                                </a>
                                                &nbsp;
                                                <a href="javascript:void(0)" data-toggle="tooltip" title = "Delete">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </a>
                                                &nbsp;
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="faults">
                            <h6 class="header">Fault Categories <span class="add_new"><a href="javascript:void(0)" data-toggle="modal" data-target="#faults-modal">Add New</a></span><span class="add_new"><a href="javascript:void(0)" data-toggle="tooltip" title="Import CSV">Import CSV</a></span></h6>
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
                                <tbody>
                                    @foreach($fault_categories as $category)
                                        <tr>
                                            <td>
                                                {{$category->name}}
                                            </td>
                                            <td class="text-right">
                                                <a href="javascript:void(0)" data-toggle="tooltip" title = "Edit" onclick="edit_fault_category('{{$category->name}}', '{{$category->id}}')">
                                                    <i class="fas fa-pen text-muted"></i>
                                                </a>
                                                &nbsp;
                                                <a href="javascript:void(0)" data-toggle="tooltip" title = "Delete">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </a>
                                                &nbsp;
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="works">
                            <h6 class="header">Work Order Priorities <span class="add_new"><a href="javascript:void(0)" data-toggle="modal" data-target="#priority-modal">Add New</a></span><span class="add_new"><a href="javascript:void(0)" data-toggle="tooltip" title="Import CSV">Import CSV</a></span></h6>
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
                                <tbody>
                                    @foreach($priority_categories as $category)
                                        <tr>
                                            <td>
                                                {{$category->name}}
                                            </td>
                                            <td class="text-right">
                                                <a href="javascript:void(0)" data-toggle="tooltip" title = "Edit" onclick="edit_priority('{{$category->name}}', '{{$category->id}}')">
                                                    <i class="fas fa-pen text-muted"></i>
                                                </a>
                                                &nbsp;
                                                <a href="javascript:void(0)" data-toggle="tooltip" title = "Delete">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </a>
                                                &nbsp;
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
                        <label><b>Category Name</b> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control data" name="name" required>
                    </div>
                </div>
                <div class="form-check mt-3">
                    <label class="form-check-label">
                        <input class="form-check-input data" name="is_subcategory" type="checkbox" id="is_sub_category">
                        <span class="form-check-sign"></span>
                        This category is a subcategory
                    </label>
                </div>
                <div class="col-md-12 mt-3" style="display:none;" id="div_select_parent">
                    <div class="form-group">
                        <label><b>Parent Category</b></label>
                        <select class="selectpicker col-md-12 data" title="Parent Category" name="parent_id" data-live-search="true">
                            @foreach($parent_categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-4 right">
                <button type="submit" class="btn btn-purple text-right pull-right" id="btn_save_asset">Save</button>
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
                        <input type="text" class="form-control resetable" name="name" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-4 right">
                <button type="submit" class="btn btn-purple">Save</button>
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
                        <input type="text" class="form-control resetable" name="name" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-4">
                <button type="submit" class="btn btn-purple text-right pull-right">Save</button>
            </div>
        </div>
    </form>
  </div>
</div>
<div id="spare-part-modal" class="modal fade right">
  <div class="modal-dialog">
    <form method = "post" id="new_spare_part_category">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                <h6 class="header">New Spare Part Type</h6>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><b>Spare Part Type Name</b></label>
                        <input type="text" class="form-control resetable" name="name" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-4">
                <button type="submit" class="btn btn-purple text-right pull-right">Save</button>
            </div>
        </div>
    </form>
  </div>
</div>
<div id="edit-asset-modal" class="modal fade right">
  <div class="modal-dialog">
    <form method = "post" id="edit_asset_category">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                <h6 class="header">Edit Asset Category</h6>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><b>Category Name</b> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control data" name="name" id="edit_asset_name" required>
                    </div>
                </div>
                <div class="form-check mt-3 edit_parent">
                    <label class="form-check-label">
                        <input class="form-check-input data" name="is_subcategory" type="checkbox" id="edit_is_sub_category">
                        <span class="form-check-sign"></span>
                        This category is a subcategory
                    </label>
                </div>
                <div class="col-md-12 mt-3" style="display:none;" id="edit_select_parent">
                    <div class="form-group">
                        <label><b>Parent Category</b></label>
                        <select class="selectpicker col-md-12 data" title="Parent Category" 
                        name="parent_id" data-live-search="true" id="edit_parent_id">
                            @foreach($parent_categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-4 right">
                <button type="submit" class="btn btn-purple text-right pull-right" id="btn_save_asset">Save</button>
            </div>
        </div>
    </form>
  </div>
</div>
<div id="edit-fault-modal" class="modal fade right">
  <div class="modal-dialog">
    <form method = "post" id="edit_fault_category">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                <h6 class="header">Edit Fault Category</h6>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><b>Fault Type Name</b></label>
                        <input type="text" class="form-control resetable" name="name" id="edit_fault_name">
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-4 right">
                <button type="submit" class="btn btn-purple">Save</button>
            </div>
        </div>
    </form>
  </div>
</div>
<div id="edit-priority-modal" class="modal fade right">
  <div class="modal-dialog">
    <form method = "post" id="edit_priority">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                <h6 class="header">Edit Priority Type</h6>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><b>Priority Type Name</b></label>
                        <input type="text" class="form-control resetable" name="name" id="edit_priority_name">
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-4 right">
                <button type="submit" class="btn btn-purple">Save</button>
            </div>
        </div>
    </form>
  </div>
</div>
<div id="edit-spare-part-modal" class="modal fade right">
  <div class="modal-dialog">
    <form method = "post" id="edit_spare_part">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                <h6 class="header">Edit Spare Part Type</h6>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><b>Spare Part Type Name</b></label>
                        <input type="text" class="form-control resetable" name="name" id="edit_spare_part_name">
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-4 right">
                <button type="submit" class="btn btn-purple">Save</button>
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
        let temp_asset_id, temp_fault_id, temp_priority, temp_spare_part_id;

        $(document).ready(function () {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });

            let asset_table = generateDtbl('#asset_table');
        
            let faults_table = generateDtbl('#faults_table');

            let works_table = generateDtbl('#works_table');
            
            let spare_parts_table = generateDtbl('#spare_parts_table');
        });

        $('#is_sub_category').on('change', function(){
            if($(this).prop('checked')){
                $('#div_select_parent').css('display', 'block');
            }else{
                $('#div_select_parent').css('display', 'none');
            }
        });


        $('#new_asset_category').on('submit', function(e){
            e.preventDefault();

            var data = {
                hospital_id : '{{$user->hospital_id}}'
            };
            
            $.each($(this).find('.data'), function(i, e){
                data[$(e).attr('name')] = $(e).val();
            });

            if($('#is_sub_category').prop('checked') == false){
                data.parent_id = null;
            }
            
            let btn = $(this).find('[type=submit]');

            submit_form("/api/asset-category/add", "post", data, undefined, btn, true);
        });

        $('#new_fault_category').on('submit', function(e){
            e.preventDefault();
            let data = {
                hospital_id: '{{$user->hospital_id}}',
            }

            data.name = $(this).find('[name="name"]').val();
            
            let btn = $(this).find('[type=submit]');
            submit_form("/api/fault-category/add", "post", data, undefined, btn, true);
        });

        $('#new_priority_category').on('submit', function(e){
            e.preventDefault();
            let data = {
                hospital_id: '{{$user->hospital_id}}',
            }

            data.name = $(this).find('[name="name"]').val();
            let btn = $(this).find('[type=submit]');
            submit_form("/api/priority/add", "post", data, undefined, btn, true);
        });

        let edit_asset_category = (name, id, parent_id = null, has_children = false) => {
            $("#edit_asset_name").val(name);
            temp_asset_id = id;

            if(parent_id != null && parent_id != undefined){
                $("#edit_parent_id").val(parent_id);
                $("#edit_parent_id").selectpicker('refresh');
                $("#edit_is_sub_category").prop("checked", true);
                $("#edit_select_parent").css("display", 'block');
            }else{
                $("#edit_parent_id").val(null);
                $("#edit_parent_id").selectpicker('refresh');
                $("#edit_is_sub_category").prop("checked", false);
                $("#edit_select_parent").css("display", 'none');
            }

            if(has_children){
                $(".edit_parent").css('display', 'none');
            }else{
                $(".edit_parent").css('display', 'block');
            }
            
            $('#edit-asset-modal').modal("show");
        }

        $('#edit_is_sub_category').on('change', function(){
            if($(this).prop('checked')){
                $('#edit_select_parent').css('display', 'block');
            }else{
                $('#edit_select_parent').css('display', 'none');
            }
        });

        $('#edit_asset_category').on('submit', function(e){
            e.preventDefault();

            var data = {
                hospital_id : '{{$user->hospital_id}}'
            };
            
            $.each($(this).find('.data'), function(i, e){
                data[$(e).attr('name')] = $(e).val();
            });

            if($('#edit_is_sub_category').prop('checked') == false){
                data.parent_id = null;
            }
            
            let btn = $(this).find('[type=submit]');

            submit_form("/api/asset-category/update/"+temp_asset_id, "put", data, undefined, btn, true);
        });

        let edit_fault_category = (name, id) => {
            $("#edit_fault_name").val(name);
            temp_fault_id = id;

            $('#edit-fault-modal').modal("show");
        }

        $("#edit_fault_category").on("submit", function(e){
            e.preventDefault();
            
            let data = {
                hospital_id: '{{$user->hospital_id}}',
            }

            data.name = $(this).find('[name="name"]').val();
            
            let btn = $(this).find('[type=submit]');
            submit_form("/api/fault-category/update/"+temp_fault_id, "put", data, undefined, btn, true);
        });

        let edit_priority = (name, id) => {
            $("#edit_priority_name").val(name);
            temp_priority_id = id;

            $('#edit-priority-modal').modal("show");
        }

        $("#edit_priority").on("submit", function(e){
            e.preventDefault();
            
            let data = {
                hospital_id: '{{$user->hospital_id}}',
            }

            data.name = $(this).find('[name="name"]').val();
            
            let btn = $(this).find('[type=submit]');
            submit_form("/api/part-category/update/"+temp_priority_id, "put", data, undefined, btn, true);
        });

        $('#new_spare_part_category').on('submit', function(e){
            e.preventDefault();
            let data = {
                hospital_id: '{{$user->hospital_id}}',
            }

            data.name = $(this).find('[name="name"]').val();
            let btn = $(this).find('[type=submit]');
            submit_form("/api/part-category/add", "post", data, undefined, btn, true);
        });

        let edit_spare_part = (name, id) => {
            $("#edit_spare_part_name").val(name);
            temp_spare_part_id = id;

            $('#edit-spare-part-modal').modal("show");
        }

        $("#edit_spare_part").on("submit", function(e){
            e.preventDefault();
            
            let data = {
                hospital_id: '{{$user->hospital_id}}',
            }

            data.name = $(this).find('[name="name"]').val();
            
            let btn = $(this).find('[type=submit]');
            submit_form("/api/part-category/update/"+temp_spare_part_id, "put", data, undefined, btn, true);
        });
    </script>
@endsection