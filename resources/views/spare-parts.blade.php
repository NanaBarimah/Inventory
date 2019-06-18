@extends('layouts.user-dashboard', ['page_title' => 'Spare Parts'])
@section('styles')
<style>
    .text-small{
        font-size: 12px;
    }
</style>
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12 center">
            <div class="card">
                <div class="card-header">
                    <h4 class="inline-block">Spare Parts</h4>
                </div>
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Cost</th>
                                <th>Area</th>
                                <th>Category</th>
                                <th class="disabled-sorting text-right">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Cost</th>
                                <th>Area</th>
                                <th>Category</th>
                                <th class="disabled-sorting text-right">Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($parts as $part)
                            <tr class="uppercase">
                                <td>
                                    <a href="/spare-part/{{$part->id}}">{{$part->name}}</a>
                                </td>
                                <td><span class="{{$part->quantity <= $part->min_quantity ? 'badge badge-danger' : ''}}">{{$part->quantity}}</span>  <span class="text-danger text-small"> Requires restock</span></td>
                                <td>{{$part->cost}}</td>
                                <td>{{$part->area}}</td>
                                <td>{{$part->part_category != null ? $part->part_category->name : 'N/A'}}</td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret"
                                            data-toggle="dropdown">
                                            <i class="now-ui-icons loader_gear"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Edit Part</a>
                                            <a class="dropdown-item text-danger" href="#">Delete Part</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <a href="javascript:void(0)" data-toggle="modal" data-target="#addPart">
        <div class="fab">
            <i class="fas fa-plus"></i>
        </div>
    </a>
</div>
<div class="modal fade" id="addPart" tabindex="-1" role="dialog" aria-labelledby="addVendorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                <h6 class="header">New Spare Part</h6>
            </div>
            <form id="new_part">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label><b>Part Name</b> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control resetable" name="name" required="true"/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label><b>Unit Price</b> <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control resetable" name="cost" required="true"/>
                        </div>
                        <div class="form-group col-md-4">
                            <label><b>Quantity In Stock</b></label>
                            <input type="number" step="1" class="form-control resetable" name="quantity">
                        </div>
                        <div class="form-group col-md-4">
                            <label><b>Minimum Quantity</b> <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control resetable" name="min_quantity" required="true"/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4 col-sm-12">
                            <label><b>Year of Manufacture</b></label>
                            <input type="text" class="form-control resetable" name="manufacturer_year">
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label><b>Location</b></label>
                            <input type="text" class="form-control resetable" name="area">
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label><b>Category</b></label>
                            <select class="selectpicker col-sm-12" title="Category" data-style="btn btn-purple" name="part_categories_id" required="true">
                                @foreach($part_categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        
                        <div class="form-group col-md-6 mt-4 col-sm-12">
                            <label><b>Description</b></label>
                            <textarea class="form-control resetable" name="description" rows="3"></textarea>
                            <button type="submit" class="btn btn-purple mt-5" id="btn_submit">Save</button>
                        </div>

                        <div class="fileinput fileinput-new col-md-6 col-sm-12" data-provides="fileinput">
                            <div class="col-md-12 form-group">
                                    <label style="display:block;"><b>Image</b></label>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <img src="{{asset('img/image_placeholder.jpg')}}" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="image" />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists"
                                                data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jasny-bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script>
        document
        let parts_table = generateDtbl('#datatable', 'No parts specified', 'Search for part');

        $('#new_part').on('submit', function(e){
            e.preventDefault();

            let data = new FormData(this);
            data.append("hospital_id", '{{Auth::user()->hospital_id}}');
            let btn = $(this).find('[type="submit"]');
            submit_file_form("/api/spare-part/add", "post", data, undefined, btn, true);
        });
    </script>
@endsection