@extends('layouts.user-dashboard', ['page_title' => $work_order->title])
@section('styles')
<style>
.card-comments .card-body{
    min-height: 350px;
    max-height: 400px;
    overflow-x: auto;
}

.nav-item .active{
    border-radius: 0;
}
</style>
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-9 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{$work_order->title}}</h5>
                    <div class="dropdown" style="position:absolute; top: 0; right: 0;">
                        <button type="button"
                            class="btn btn-round btn-default dropdown-toggle btn-simple"
                            data-toggle="dropdown" style="border:none;">
                            Actions
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item">Mark as <b>open</b></button>
                            <button class="dropdown-item">Mark as <b>in progress</b></button>
                            <button class="dropdown-item">Mark as <b>on hold</b></button>
                            <button class="dropdown-item">Mark as <b>closed</b></button>
                            <button class="dropdown-item"><b>Edit</b> work order</button>
                        </div>
                    </div>
                    <ul class="nav nav-tabs nav-tabs-primary text-center">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" role="tablist" href="#details">Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" role="tablist" href="#activity">Activity</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" role="tablist" href="#parts">Spare Parts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" role="tablist" href="#pos">Purchase Orders</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content tab-space">
                        <div class="tab-pane active" id="details">
                            <div class="row mb-4" style="margin-top: -50px">
                                <div class="col-md-12 text-right">
                                    <label><b>Status</b></label>
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
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h6>Description</h6>
                                        <p class="text-muted">{{$work_order->description != null ? $work_order->description : 'No description provided'}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>Date Created</b></label>
                                        <p>{{Carbon\Carbon::parse($work_order->created_at)->format('jS F, Y')}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>Due Date</b></label>
                                        <p>{{$work_order->due_date != null ? Carbon\Carbon::parse($work_order->due_date)->format('jS F, Y') : 'N/A'}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h6>Assignees</h6>
                                        @if($work_order->users->count() == 0 && $work_order->user == null)
                                        <span class="text-muted">No techinicians assigned yet</span>&nbsp;
                                        @endif
                                        <button class="btn btn-round btn-light btn-icon"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h6><b>Asset</b></h6>
                                        <span>{{$work_order->asset != null ? $work_order->asset->name : 'N/A'}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="activity">
                        </div>
                        <div class="tab-pane" id="parts">
                        </div>
                        <div class="tab-pane" id="pos">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="card card-comments">
                <div class="card-header">
                    <h6 class="title">Comments</h6>
                </div>
                <div class="card-body">
                    <span class="text-muted">No comments made yet</span>
                </div>
                <div class="card-footer">
                    <textarea class="form-control" placeholder="Write comment"></textarea>
                    <button class="btn btn-round btn-purple mt-2 pull-right mb-3">Comment</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection