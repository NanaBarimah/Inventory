@extends('layouts.user-dashboard', ['page_title' => $work_order->title])
@section('styles')
<style>
.card-comments{
    min-height: 400px;
    max-height: 450px;
    overflow-x: auto;
}
</style>
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-9 col-sm-12">
            <div class="card">
                <div class="card-header">
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
                        </div>
                    </div>
                    <ul class="nav nav-tabs nav-tabs-primary text-center">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Activity</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Spare Parts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">Purchase Orders</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6>{{$work_order->title}}</h6>
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
                                <p>{{$work_order->description}}</p>
                            </div>
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
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection