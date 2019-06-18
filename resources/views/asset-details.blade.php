@extends('layouts.user-dashboard', ['page_title' => $asset->name])
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="">
                    <img src="{{asset('img/assets/equipment/'.$asset->image)}}" onerror = "this.src = '{{asset('img/image_placeholder.jpg')}}'"/>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title pb-2">{{$asset->name}}</h5>
                        <ul class="nav nav-tabs nav-tabs-primary text-center mt-2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#details" role="tablist">
                                    Asset Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#assets" role="tablist">
                                    Associated Parts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#work-orders" role="tablist">
                                    Work Orders
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#files" role="tablist">
                                    Files
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#child" role="tablist">
                                    Child Assets
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#down-time" role="tablist">
                                    Down Time & Depreciation
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#edit" role="tablist">
                                    Edit
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#actions" role="tablist">
                                    Actions
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content tab-space">
                            <div class="tab-pane active" id="details">
                                <div class="row pl-4">
                                    <div class="col-md-3">
                                        <div id="qrcode"></div>
                                        <button class="btn btn-purple btn-block">Print QR Code</button>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="description-label">Warranty Expiration</label>
                                                    <p class="text-highlighted">
                                                        {{$asset->warranty_expiration != null && !Carbon\Carbon::parse($asset->warranty_expiration)->isPast() ? Carbon\Carbon::parse($asset->warranty_expiration)->diffForHumans() : 'No warranty available for this equipment'}}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="description-label">Equipment Code</label>
                                                    <p class="no-border"><b>{{$asset->asset_code}}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                        {{--<div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="description-label">Category</label>
                                                    <p class="">{{$part->part_category != null ? $part->part_category->name : 'N/A'}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="description-label">Manufacture Year</label>
                                                    <p class="">{{$part->manufacturer_year != null ? Carbon\Carbon::parse($part->manufacturer_year)->format('Y') : 'N/A'}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="description-label">Description</label>
                                                    <p class="">{{$part->description != null ? $part->description : 'No description for this part yet'}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="description-label">Location</label>
                                                    <p class="">{{$part->area != null ? $part->area : 'N/A'}}</p>
                                                </div>
                                            </div>
                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/qrcode.min.js')}}" type="text/javascript"></script>
    
    <script type="text/javascript">
        $(document).ready(function(){
            if($('#qrcode').html() == ''){
                qr = new QRCode(document.getElementById("qrcode"), "{{$asset->id}}");
            }
        });
        function viewQr(){
            $('#qrModal').modal('show');
        }

        function printContent(el){
            var restorepage = $('body').html();
            var printcontent = $('#' + el).clone();
            $('body').empty().html(printcontent);
            window.print();
            window.location.reload();
        }
    </script>
@endsection