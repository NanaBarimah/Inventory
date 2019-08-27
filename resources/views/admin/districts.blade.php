<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Inventory Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <!--link href="{{ asset('css/app.css') }}" rel="stylesheet"-->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/now-ui-dashboard.min.css?v=1.2.0')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/main.css')}}" />
</head>

<body>
    <div class="wrapper ">
        @include('layouts.admin_sidebar')
        <div class="main-panel">
            @include('layouts.admin_navbar', ['page_title' => 'Districts'])
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12 center">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="inline-block">Districts</h4>
                                <a href="#" data-toggle="modal" data-target="#addDistrictModal" class="btn btn-purple pull-right">Add New</a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    <ul>
                                    @foreach($districts as $district)
                                        <li>
                                            <h6 class="title"><a href="javascript:void(0)" onclick="viewHospitals('{{$district->id}}')">{{$district->name}}</a></h6>
                                            @foreach($district->children as $child)
                                                <ul>
                                                    <li><p><a href="javascript:void(0)"  onclick="viewHospitals('{{$child->id}}')">{{$child->name}}</a></p>
                                                        @foreach($child->children as $baby)
                                                            <ul>
                                                                <li><span class="text-muted text-small">
                                                                <a href="javascript:void(0)"  onclick="viewHospitals('{{$baby->id}}')">{{$baby->name}}</a>
                                                                </span>
                                                                </li>
                                                            </ul>
                                                        @endforeach
                                                    </li>
                                                </ul>
                                            @endforeach
                                        </li>
                                    @endforeach
                                    </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="hospitals-modal" class="modal fade right">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                    <h6 class="header">Hospitals</h6>
                </div>
                <div class="modal-body">
                    <div class="col-md-12" id="hospitals-list">

                    </div>
                    <input name="id"  type="hidden" id="del_id"/>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.admin_core_scripts')
    <script>
        const viewHospitals = (id) => {
            $("#hospitals-list").html('<p class="text-center"><i class="now-ui-icons education_atom spin" style="font-size: 24px;"></i></p>');
            $("#hospitals-modal").modal("show");
            
            $.ajax({
                "url" : `/api/districts/${id}/view-hospitals`,
                "method" : "get",
                "success" : data => {
                    $("#hospitals-list").html(null);
                    $("#hospitals-list").append("<ul>");
                    if(data.length > 0){
                        data.forEach(function(hospital, index){
                            $("#hospitals-list").append(`<li><a href="/admin/hospitals/${hospital.id}">${hospital.name}</a></li>`);
                        })
                    }else{
                        $("#hospitals-list").append("<li><i class='text-muted'>No hospitals in this location</i></li>");
                    }
                    $("#hospitals-list").append("</ul>");
                },
                "error" : err => {
                    $("#hospitals-list").html(`<p><i class='text-muted'>Could not retrieve hospital data. <a href='javscript:void(0)' onclick='viewHospitals('${id}')'>Try again.</a></i></p>`);
                }
            })
        }
    </script>
</body>

</html>