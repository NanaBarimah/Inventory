@extends('layouts.user-dashboard', ['page_title' => 'Preventive Maintenance Types'])
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
                        <h4 class="inline-block">Preventive Maintenance Types</h4>
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
                                            <th>Next Maintenance</th>
                                            <th>Priority</th>
                                            <th>Scheduled Until</th>
                                            <th>Recurrence</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Next Maintenance</th>
                                            <th>Priority</th>
                                            <th>Scheduled Until</th>
                                            <th>Recurrence</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                       @foreach($pmSchedules as $pmSchedule)
                                        <tr>
                                            <td>{{$pmSchedule->title}}</td>
                                            <td>{{$pmSchedule->description}}</td>
                                            <td>{{date('jS F, Y', $pmSchedule->title)}}</td>
                                            <td>{{$pmSchedule->priority->name}}</td>
                                            <td>{{date('jS F, Y', $pmSchedule->endDueDate)}}</td>
                                            <td>{{ucwords($pmSchedule->recurringSchedule)}}</td>
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
    <a href="/pm-schedules/add">
        <div class="fab">
            <i class="fas fa-plus"></i>
        </div>
    </a>
@endsection
@section('scripts')
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        let pm_table = generateDtbl('#pm', 'No preventive maintenances recorded', 'Search pm schedule');
    </script>
@endsection