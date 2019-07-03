@extends('layouts.user-dashboard', ['page_title' => 'Equipment'])
@section('styles')
    <style>
        .btn-outline{
            background: #fff;
            color: #666;
            border: 1px solid #666;
        }

        .btn-outline:hover{
            background: #666;
            color: #fff;
        }

        .btn-outline:disabled{
            color:#fff;
        }
    </style>
@endsection
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12 center">
                <div class="card">
                    <div class="card-header">
                        <h4 class="inline-block">Equipment List</h4>
                    </div>
                    <div class="card-body">
                        {{--<div class="row">
                            <div class="col-sm-12">
                                <h6>Filter Items</h6>
                                <form method="get" action="javascript:void(0)">
                                    <select class="selectpicker form-control" data-style="btn btn-outline btn-round"
                                        title="Filter By">
                                        <option>--N/A--</option>
                                        <option value="departments">Departments</option>
                                        <option value="units">Units</option>
                                    </select>
                                    <select class="selectpicker mt-2 form-control col-md-5 col-sm-12" data-style="btn btn-outline btn-round"
                                        title="Status">
                                        <option>--N/A--</option>
                                        <option>Active</option>
                                        <option>Inactive</option>                                                
                                    </select>
                                    <select class="selectpicker mt-2 form-control col-md-6 col-sm-12" data-style="btn btn-outline btn-round"
                                        title="Manufacturer">
                                        <option>--N/A--</option>                                                
                                    </select>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox">
                                            <span class="form-check-sign"></span>
                                            Pending work order
                                        </label>
                                    </div>
                                    <select class="selectpicker form-control mt-2" data-style="btn btn-outline btn-round"
                                        title="Work order priority" disabled>
                                        <option>--N/A--</option>
                                        <option value="departments">High</option>
                                        <option value="units">Mid Level</option>
                                        <option value="units">Low</option>
                                    </select>
                                    <button type="submit" class="float-right right btn-purple btn">Filter</button>
                                </form>
                                <div class="filter-overlay"></div>
                            </div>
                        </div>--}}
                        <div class="row">
                            <div class="col-md-12">
                                                                    
                            <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Asset Number</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Availability</th>
                                        <th>Date Created</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Asset Number</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Availability</th>
                                        <th>Date Created</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                @foreach($assets as $item)
                                    <tr class="uppercase">
                                        <td>
                                            <a href="/inventory/{{$item->id}}"><b>{{$item->name}}</b></a>
                                        </td>
                                        <td>{{$item->asset_code}}</td>
                                        <td>{{$item->asset_category != null ? $item->asset_category->name : "N/A"}}</td>
                                        <td>{{$item->status}}</td>
                                        <td>{{$item->availability}}</td>
                                        <td>{{Carbon\Carbon::parse($item->created_at)->format('j F, Y')}}</td>
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
    <a href="/inventory/add">
        <div class="fab">
            <i class="fas fa-plus"></i>
        </div>
    </a>
@endsection
@section('scripts')
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
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
    </script>
@endsection