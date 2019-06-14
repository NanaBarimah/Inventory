@extends('layouts.user-dashboard', ['page_title' => 'Service Vendors'])
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12 center">
                <div class="card">
                    <div class="card-header">
                        <h4 class="inline-block">Service Vendors List</h4>
                        <a href="#" class="btn btn-purple pull-right" data-toggle="modal" data-target="#addVendorModal">Add New</a>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Contact Name</th>
                                    <th>Contact Number</th>
                                    <th>Email</th>
                                    <th>Vendor Type</th>
                                    <th>Address</th>
                                    <th>Website</th>
                                    <th class="disabled-sorting">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Contact Name</th>
                                    <th>Contact Number</th>
                                    <th>Email</th>
                                    <th>Vendor Type</th>
                                    <th>Address</th>
                                    <th>Website</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            @foreach($vendors as $vendor)
                                <tr>
                                    <td>{{$vendor->name}}</td>
                                    <td>{{$vendor->contact_name !== null ? $vendor->contact_name : 'N/A'}}</td>
                                    <td>{{$vendor->contact_number !== null ? $vendor->contact_number : 'N/A'}}</td>
                                    <td>{{$vendor->email !== null ? $vendor->email : 'N/A'}}</td>
                                    <td>{{$vendor->vendor_type !== null ? $vendor->vendor_type : 'N/A'}}</td>
                                    <td>{{$vendor->address !== null ? $vendor->address : 'N/A'}}</td>
                                    <td>{{$vendor->website !== null ? $vendor->website : 'N/A'}}</td>
                                    <td>
                                        <span data-toggle="modal" data-target="#editVendorModal" data-id="{{$vendor->id}}" data-name="{{$vendor->name}}" data-contact="{{$vendor->contact_number}}">
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
    <div class="modal fade" id="addVendorModal" tabindex="-1" role="dialog" aria-labelledby="addVendorLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <form method = "post" id="add_new_vendor_form">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                <h6 class="header">New Vendor</h6>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label><b>Vendor Name</b> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control resetable" name="name">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><b>Contact Person Name</b></label>
                        <input type="text" class="form-control resetable" name="contact_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label><b>Contact Number</b></label>
                        <input type="tel" class="form-control resetable" name="contact_number">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><b>Email</b></label>
                        <input type="email" class="form-control resetable" name="email">
                    </div>
                    <div class="form-group col-md-6">
                        <label><b>Website</b></label>
                        <input type="url" class="form-control resetable" name="website">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><b>Vendor Type</b> <span class="text-danger">*</span></label>
                        <select class="selectpicker col-md-12" title="Vendor Type" data-style="btn btn-purple" name="vendor_type">
                            <option>Maintenance Contractors</option>
                            <option>Purchase equipment</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label><b>Address</b></label>
                        <input type="text" class="form-control resetable" name="address">
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-4">
                <button type="submit" class="btn btn-purple float-right" id="btn_submit">Save</button>
            </div>
        </div>
    </form>
        </div>
    </div>
    <div class="modal fade" id="editVendorModal" tabindex="-1" role="dialog" aria-labelledby="editVendorLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title margin-bottom-10" id="editVendorLabel">Edit Vendor</h5>
                    <form method="post" action="#" id="edit_cat_form">
                        <div class="form-group">
                            <input type="text" class="form-control normal-radius" placeholder="Vendor Name" name="name" id="edit_vendor_name"/>
                            <input type="text" class="form-control normal-radius" placeholder="Vendor Contact" name="contact_number " id="edit_vendor_contact"/>
                            <input type="hidden" id="edit_vendor_id" name="id"/>
                            <input type="hidden" name="hospital_id" value="{{Auth::user()->hospital_id}}"/>
                            <button type="submit" class="pull-right btn btn-purple btn-fill btn-wd" id="btn_edit" disabled>Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });

            let table = $('#datatable').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search for vendor",
                }

            });
        });

        $('#add_new_vendor_form').on('submit', function(e){
            e.preventDefault();
            
            $('#btn_submit').html('<i class="now-ui-icons loader_refresh spin"></i>');
            var data = $(this).serialize();
            $(this).find('input').prop('disabled', true);

            $request = $.ajax({
                url: '/api/vendors/add',
                method: 'post',
                data: data+'&hospital_id='+{{Auth::user()->hospital_id}},
                success: function(data, status){
                    $('#btn_submit').html('Save');
                    $('#add_new_vendor_form').find('input').prop('disabled', false);

                    if(data.error){
                        presentNotification(data.message+". Try again.", 'danger', 'top', 'right');
                    }else{
                        var table = $('#datatable').DataTable();
                        table.row.add([
                            $('#vendor_name').val(),
                            $('#vendor_contact').val(),
                            '<a href="#" class="btn btn-round btn-info btn-icon btn-sm edit" data-toggle="tooltip" data-placement="left" title="Edit"><i class="now-ui-icons design-2_ruler-pencil"></i></a>'
                        ]).draw(true);
                        $('#add_new_vendor_form').find('input').val('');
                        presentNotification(data.message, 'success', 'top', 'right');
                    }
                },
                error: function(xhr, desc, err){
                    $('#btn_submit').html('Save');
                    $('#add_new_vendor_form').find('input').prop('disabled', false);
                    presentNotification('Could not save the vendor. Try again.', 'danger', 'top', 'right');
                }
            });
        });

        $('#editVendorModal').on('show.bs.modal', function(e){
            var vendor_id = $(e.relatedTarget).data('id');
            var vendor_contact = $(e.relatedTarget).data('contact');
            var vendor_name = $(e.relatedTarget).data('name');

            $('#edit_vendor_name').val(vendor_name);
            $('#edit_vendor_contact').val(vendor_contact);
            $('#edit_vendor_id').val(vendor_id);
        });
        
        $('#editVendorModal').on('hide.bs.modal', function(e){
            $('#btn_edit').prop('disabled', true);
        });

        $('#edit_cat_form').on('submit', function(e){
            e.preventDefault();
            form_data = $(this).serialize();
            var id = $('#edit_vendor_id').val();
            $('#btn_edit').html('<i class="now-ui-icons loader_refresh spin"></i>');
            
            request = $.ajax({
                url : 'api/vendors/update/'+id,
                method: 'PUT',
                data: form_data,
                success: function(data, status){
                    $('#btn_edit').html('Save');
                    if(data.error){
                        presentNotification(data.message, 'warning', 'top', 'right');
                    }else{
                        presentNotification(data.message, 'info', 'top', 'right');
                        setTimeout(function(){
                        location.reload()
                        }, 1700);
                    }                
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
@endsection