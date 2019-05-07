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
            @include('layouts.admin_navbar', ['page_title' => 'Category List'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-10 center">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="inline-block">Equipment Type List</h4>
                                <a href="#" class="btn btn-purple pull-right" data-toggle="modal" data-target="#addCategoryModal">Add New</a>
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
                                            <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{$category->name}}</td>
                                            <td>
                                                <span data-toggle="modal" data-target="#editCategoryModal" data-id="{{$category->id}}" data-name="{{$category->name}}">
                                                    <a href="#" class="btn btn-round btn-info btn-icon btn-sm edit" data-placement="left" title="Edit" data-toggle="tooltip">
                                                        <i class="now-ui-icons design-2_ruler-pencil"></i>
                                                    </a>
                                                </span>
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
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title margin-bottom-10" id="addCategoryLabel">New Category</h5>
                    <form method="post" action="#" id="add_new_cat_form">
                        <div class="form-group">
                            <input type="text" class="form-control normal-radius" placeholder="Category Name" name="name" id="cat_name"/>
                            <button type="submit" class="pull-right btn btn-purple btn-fill btn-wd" id="btn_submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title margin-bottom-10" id="editCategoryLabel">Edit Category</h5>
                    <form method="post" action="#" id="edit_cat_form">
                        <div class="form-group">
                            <input type="text" class="form-control normal-radius" placeholder="Category Name" name="name" id="edit_cat_name"/>
                            <input type="hidden" id="edit_cat_id" name="id"/>
                            <button type="submit" class="pull-right btn btn-purple btn-fill btn-wd" id="btn_edit" disabled>Save</button>
                        </div>
                    </form>
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

        $('#add_new_cat_form').on('submit', function(e){
            e.preventDefault();
            
            $('#btn_submit').html('<i class="now-ui-icons loader_refresh spin"></i>');
            var data = $(this).serialize();
            $(this).find('input').prop('disabled', true);

            $request = $.ajax({
                url: '/api/categories/add_category',
                method: 'post',
                data: data,
                success: function(data, status){
                    $('#btn_submit').html('Save');
                    $('#add_new_cat_form').find('input').prop('disabled', false);

                    if(data.error){
                        presentNotification(data.message+". Try again.", 'danger', 'top', 'right');
                    }else{
                        var table = $('#datatable').DataTable();
                        table.row.add([
                            $('#cat_name').val(),
                            '<a href="#" class="btn btn-round btn-info btn-icon btn-sm edit" data-toggle="tooltip" data-placement="left" title="Edit"><i class="now-ui-icons design-2_ruler-pencil"></i></a>'
                        ]).draw(true);
                        $('#add_new_cat_form').find('input').html('');
                        presentNotification(data.message, 'success', 'top', 'right');
                    }
                },
                error: function(xhr, desc, err){
                    $('#btn_submit').html('Save');
                    $('#add_new_cat_form').find('input').prop('disabled', false);
                    presentNotification('Could not save the category. Try again.', 'danger', 'top', 'right');

                    console.log(err);
                }
            });
        });

        $('#editCategoryModal').on('show.bs.modal', function(e){
            var cat_id = $(e.relatedTarget).data('id');
            var cat_name = $(e.relatedTarget).data('name');

            $('#edit_cat_name').val(cat_name);
            $('#edit_cat_id').val(cat_id);
        });
        
        $('#editCategoryModal').on('hide.bs.modal', function(e){
            $('#btn_edit').prop('disabled', true);
        });

        $('#edit_cat_form').on('submit', function(e){
            e.preventDefault();
            form_data = $(this).serialize();
            var id = $('#edit_cat_id').val();
            $('#btn_edit').html('<i class="now-ui-icons loader_refresh spin"></i>');

            request = $.ajax({
                url : 'api/categories/update/'+id,
                method: 'PUT',
                data: form_data,
                success: function(data, status){
                    $('#btn_edit').html('Save');
                    presentNotification('Category updated', 'info', 'top', 'right');     
                    setTimeout(function(){
                        location.reload()
                    }, 1700);             
                },
                error: function(xhr, desc, err){
                    $('#btn_edit').html('Save');
                    presentNotification('Could not update the category', 'danger', 'top', 'right');
                }
            });
        });

        $('#edit_cat_form input').on('input', function(){
            $('#btn_edit').prop('disabled', false);
        });

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