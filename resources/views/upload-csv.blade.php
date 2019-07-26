@extends('layouts.user-dashboard', ['page_title' => 'Upload CSV'])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class = "jumbotron bg-transparent">
                            <h1 class="display-4">Bulk {{$action}} upload</h1>
                            <p class="lead">Upload CSV for bulk <b>{{$action}}</b> uploads. Please download this <a href="/download/category-csv"><b>csv file</b></a> template for bulk uploads and enter information as required.
                            Upload the completed CSV file when you are done with your entries using the upload field below.
                            </p>
                            <p><i><b>NB:</b> files that are not uploaded with the provided template will be rejected</i></p>
                            <hr/>
                            <form method="post" id="upload_csv">
                                <p class="lead">
                                <input type="file" name="file"/>
                                <button type="submit" class="btn btn-primary btn-lg">Upload File</button>
                                </p>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
<script>
    $("#upload_csv").on("submit", function(e){
        e.preventDefault();
        const action = "{{$action}}";
        let url = "";

        switch(action){
            case "equipment category":
                url = "/api/asset-category/bulk-save";
                break;
            case "part category":
                url = "/api/part-category/bulk-save";
                break;
            case "fault category":
                url = "/api/fault-category/bulk-save";
                break;
            case "priority":
                url = "/api/priority/bulk-save";
                break;
            default:
                break;
        }

        if(url != ""){
            const data = new FormData(this);
            let btn = $(this).find("[type=submit]");
            data.append("hospital_id", "{{$user->hospital_id}}");

            submit_file_form(url, "post", data, undefined, btn, true);
        }else{
            presentNotification("Invalid operation", "danger", "top", "right");
        }
    })
</script>
@endsection