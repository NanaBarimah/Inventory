<?php use App\Category; ?>
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
            @include('layouts.admin_navbar', ['page_title' => 'Categories'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="col-md-12 center">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="inline-block">Categories</h4>
                        </div>
                        <div class="card-body">
                            <table id="categories_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th class="disabled-sorting">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th class="disabled-sorting">Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>{{$category->name}}</td>
                                        <td>
                                            <a href="javascript:void(0)" data-toggle="tooltip" title = "Edit" onclick="edit('{{$category->name}}', '{{$category->id}}')">
                                                <i class="fas fa-pen text-muted"></i>
                                            </a>
                                            &nbsp;
                                            <a href="javascript:void(0)" data-toggle="tooltip" title = "Delete" onclick="deleteCategory('{{$category->id}}')">
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
            <div id="category-modal" class="modal fade">
                <div class="modal-dialog">
                    <form method = "post" id="new_category">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                                <h6 class="header">New Category</h6>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><b>Category Name</b> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control data" name="name" required>
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
            <div id="edit-modal" class="modal fade">
                <div class="modal-dialog">
                    <form method = "post" id="edit_category">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                                <h6 class="header">Edit Category</h6>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><b>Category Name</b> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control data" name="name" id="edit_name" required>
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
            <div id="delete-modal" class="modal fade right">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method = "post" id="delete_category">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                                <h6 class="header">Delete Category</h6>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <p>Are you sure you want to delete this category. Be very sure you want to do this before you continue. This action cannot be undone</p>
                                </div>
                                <input name="id"  type="hidden" id="del_id"/>
                            </div>
                            <div class="modal-footer mt-4 pull-right">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#category-modal">
                <div class="fab">
                    <i class="fas fa-plus"></i>
                </div>
            </a>
        </div>
    </div>
    @include('layouts.admin_core_scripts')
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/datatables.js')}}"></script>
    <script>
        const categories_table = generateDtbl("#categories_table", "No categories registered");
        
        let temp_id = null;
        
        $("#new_category").on("submit", function(e){
            e.preventDefault();
            let data = $(this).serialize();
            data += "&region_id={{$admin->region_id}}";
            let btn = $(this).find("[type=submit]");

            submit_form("/api/categories/add", "post", data, undefined, btn, true);
        });


        let edit = (name, id) => {
            $("#edit_name").val(name);
            temp_id = id;

            $('#edit-modal').modal("show");
        }

        $("#edit_category").on("submit", function(e){
            e.preventDefault();
            
            let data = {
                region_id: '{{$admin->region_id}}',
            }

            data.name = $(this).find('[name="name"]').val();
            
            let btn = $(this).find('[type=submit]');
            submit_form("/api/categories/update/"+temp_id, "put", data, undefined, btn, true);
        });

        const deleteCategory = (category) => {
            $("#del_id").val(category);
            $("#delete-modal").modal("show");
        }

        $("#delete_category").on("submit", function(e){
            e.preventDefault();
            
            let btn = $(this).find('[type=submit]');
            const id = $(this).find('[name=id]').val();
            submit_form("/api/categories/delete/"+id, "delete", null, undefined, btn, true);
        });
    </script>
</body>

</html>