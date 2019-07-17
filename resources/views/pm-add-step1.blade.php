@extends('layouts.user-dashboard', ['page_title' => 'Record preventive maintenance'])
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
                        <h4 class="inline-block">Record preventive maintenance</h4>
                        <p class="subtitle">Select a preventive maintenance schedule to continue</p>
                    </div>
                    <div class="card-body">
                        <!--add filter tree here-->
                        <div class="row">
                            <div class="col-md-12">
                                <table id="pm" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Priority</th>
                                            <th>Next Maintenance</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Priority</th>
                                            <th>Next Maintenance</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                       @foreach($pmSchedules as $pmSchedule)
                                        <tr>
                                            @php
                                            $due_date = Carbon\Carbon::parse($pmSchedule->due_date)
                                            @endphp
                                            <td><a href="/pm-schedule/{{$pmSchedule->id}}/record">{{$pmSchedule->title}}</a></td>
                                            <td>{{$pmSchedule->description != null ? $pmSchedule->description : 'N/A'}}</td>
                                            <td>{{$pmSchedule->priority->name}}</td>
                                            <td>{{$pmSchedule->due_date != null ? $due_date->format('jS F, Y') : 'N/A'}}
                                                @if($pmSchedule->due_date != null && $due_date->isPast())
                                                <span>&nbsp;<i class="fas fa-question text-danger" data-toggle="tooltip" title="This preventive maintenance was supposed to be carried out {{$due_date->diffForHumans()}}"></i></span>
                                                @endif
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
@endsection
@section('scripts')
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap4.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        let pm_table = generateExportDtbl('#pm', 'No preventive maintenances recorded', 'Search pm schedule');
    </script>
@endsection