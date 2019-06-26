@php
    $sorted = $requests->groupBy('status');
@endphp
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
                        <h4 class="inline-block">Requests</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-3 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-body ">
                                        <div class="statistics statistics-horizontal">
                                            <div class="info info-horizontal">
                                                <div class="row">
                                                    <div class="col-5">
                                                        <div class="icon icon-primary icon-circle">
                                                            <i class="now-ui-icons travel_info"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-7 text-right">
                                                        <h3 class="info-title">{{$requests->count()}}</h3>
                                                        <h6 class="stats-title">Total Requests</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-body ">
                                        <div class="statistics statistics-horizontal">
                                            <div class="info info-horizontal">
                                                <div class="row">
                                                    <div class="col-5">
                                                        <div class="icon icon-warning icon-circle">
                                                            <i class="now-ui-icons ui-1_simple-delete"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-7 text-right">
                                                        <h3 class="info-title">{{isset($sorted['2']) ? $sorted['2']->count() : 0}}</h3>
                                                        <h6 class="stats-title">Pending </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-body ">
                                        <div class="statistics statistics-horizontal">
                                            <div class="info info-horizontal">
                                                <div class="row">
                                                    <div class="col-5">
                                                        <div class="icon icon-success icon-circle">
                                                            <i class="now-ui-icons ui-1_check"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-7 text-right">
                                                        <h3 class="info-title">{{isset($sorted['1']) ? $sorted['1']->count() : 0}}</h3>
                                                        <h6 class="stats-title">Accepted</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-body ">
                                        <div class="statistics statistics-horizontal">
                                            <div class="info info-horizontal">
                                                <div class="row">
                                                    <div class="col-5">
                                                        <div class="icon icon-danger icon-circle">
                                                            <i class="now-ui-icons ui-1_simple-remove"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-7 text-right">
                                                        <h3 class="info-title">{{isset($sorted['0']) ? $sorted['0']->count() : 0}}</h3>
                                                        <h6 class="stats-title">Declined</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="requests" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Date Requested</th>
                                            <th>Requested By</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Title</th>
                                            <th class="disable-sorting">Date Requested</th>
                                            <th class="disable-sorting">Requested By</th>
                                            <th class="disable-sorting">Priority</th>
                                            <th class="disable-sorting">Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($requests as $request)
                                        <tr>
                                            <td><a href="request/{{$request->id}}"><b>{{$request->title}}</b></a></td>
                                            <td>{{date('jS F, Y', strtotime($request->created_at))}}</td>
                                            <td>{{$request->user == null ? $request->requester_name : $request->user->firstname.' '.$request->user->lastname}}</td>
                                            <td>{{$request->priority->name}}</td>
                                            <td><span class="badge <?php 
                                                if($request->status == 1){echo 'badge-success';}
                                                else if($request->status == 2){echo 'badge-warning';}
                                                else if($request->status == 0){echo 'badge-danger';}?>"><?php 
                                                if($request->status == 1){echo 'Accepted';}
                                                else if($request->status == 2){echo 'Pending';}
                                                else if($request->status == 0){echo 'Declined';} ?></td>
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
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script>
        let request_table = generateDtbl('#requests');
    </script>
@endsection