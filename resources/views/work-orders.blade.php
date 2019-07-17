@extends('layouts.user-dashboard', ['page_title' => 'Work Order Requests'])
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
                        <h4 class="inline-block">Work Orders</h4>
                    </div>
                    <div class="card-body">
                        <!--add filter tree here-->
                        <div class="row">
                            <div class="col-md-12">
                                <table id="works" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>#</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Lead Tech</th>
                                            <th>Equip.</th>
                                            <th>Last Updated</th>
                                            <th>Created</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Title</th>
                                            <th>#</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Lead Tech.</th>
                                            <th>Equip.</th>
                                            <th>Last Updated</th>
                                            <th>Created</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                       @foreach($work_orders as $work_order)
                                        <tr>
                                            <td><a href="/work-order/{{$work_order->id}}"><b>{{$work_order->title}}</b></a></td>
                                            <td>{{$work_order->wo_number}}</td>
                                            <td>{{$work_order->due_date != null ? date('jS F, Y', strtotime($work_order->due_date)) : 'N/A'}}</td>
                                            <td>
                                                @if($work_order->status == 1)
                                                <span class="badge badge-light">Closed</span>
                                                @elseif($work_order->status == 2)
                                                <span class="badge badge-success">In Progress</span>
                                                @elseif($work_order->status == 3)
                                                <span class="badge badge-primary">On Hold</span>
                                                @elseif($work_order->status == 4)
                                                <span class="badge badge-info">Open</span>
                                                @elseif($work_order->status == 5)
                                                <span class="badge badge-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>{{$work_order->priority != null ? $work_order->priority->name : 'N/A'}}</td>
                                            <td>
                                            @if($work_order->user != null)
                                            <img data-toggle="tooltip" title="{{$work_order->user->firstname.' '.$work_order->user->lastname}}" class="round" width="30" height="30" avatar="{{$work_order->user->firstname.' '.$work_order->user->lastname}}" />
                                            @else
                                            N/A
                                            @endif
                                            </td>
                                            <td>{{$work_order->asset != null ? $work_order->asset->name : 'N/A'}}</td>
                                            <td>{{Carbon\Carbon::parse($work_order->updated_at)->format('jS F, Y')}}</td>
                                            <td>{{Carbon\Carbon::parse($work_order->created_at)->format('jS F, Y')}}</td>
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
    <a href="/work-orders/add">
        <div class="fab">
            <i class="fas fa-plus"></i>
        </div>
    </a>
@endsection
@section('scripts')
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap4.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        let works_table = generateExportDtbl('#works');
    </script>
@endsection