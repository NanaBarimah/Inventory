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
                        <div class="card card-timeline card-plain">
                            <div class="card-body">
                                <ul class="timeline timeline-simple">
                                    @foreach($requests as $request)
                                        <li class="timeline-inverted">
                                            <div class="">
                                                <span class="badge badge-primary">{{date('jS F, Y', strtotime($request->created_at))}}</span>
                                            </div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <a href="javascript:void(0)"><span class="badge <?php if($request->status == 0){echo 'badge-danger';}else if($request->status == 1){echo 'badge-success';}else{echo 'badge-warning';} ?>">{{$request->title}}</span></a>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>{{$request->description}}</p>
                                                </div>
                                                <h6>
                                                    <i class="ti-time"></i>
                                                    {{Carbon\Carbon::parse($request->created_at)->diffForHumans()}} by <a href="javascript:void(0)" class="text-small">{{$request->user == null ? $request->requester_name : $request->user->firstname.' '.$request->user->lastname}}</a>
                                                </h6>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            {{$requests->links()}}
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script>
    </script>
@endsection