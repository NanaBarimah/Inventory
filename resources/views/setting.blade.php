@extends('layouts.user-dashboard', ['page_title' => 'Settings'])
@section('styles')
<style>
.link-generate, .link-send{
    font-size: 12px;
    font-weight: bold;
    margin-top: 4px;
    cursor: pointer;
}

.link-generate:hover, .link-send:hover{
    text-decoration: underline;
}
</style>
@endsection
@section('content')
    <div class="content">
        <div class="col-md-12 mr-auto ml-auto">
            <div>
                <div class="card" data-color="primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            Settings
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><b>Request Link: </b></label>
                                    <input class="form-control" value="<?php if($hospital->setting != null){
                                        if($hospital->setting->request_link != null){
                                            echo URL::route('request.guest', $hospital->setting->request_link);
                                        }else{
                                            echo 'N/A';
                                        }
                                    }else{
                                        echo 'N/A';
                                    } ?>" id="request_link" readonly/>
                                    <p class="text-right">
                                        @if($user->role == 'Admin')
                                            <span class="link-generate">Generate</span> &nbsp; 
                                        @endif
                                        <a href="javascript:void(0)" data-target="#send-link" data-toggle="modal"
                                        <?php if($hospital->setting != null){
                                            if($hospital->setting->request_link == null){
                                                echo 'disabled';
                                            }
                                        }else{
                                            echo 'disabled';
                                        } ?>><span  class="link-send">Send Link</span></a></p>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- wizard container -->
        </div>

    </div>
    <div class="modal fade" id="send-link">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="send_link_form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;<span class="sr-only">Close</span></button>
                        <h4>Send Guest Request Link</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Email address</b></label>
                                <input class="form-control" id="email" type="email" name="email" required/>
                            </div>
                        </div>
                        <div class="modal-footer mt-4 pull-right float-right">
                            <div>
                                <button type="submit" class="btn btn-purple">Send</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script>
        $(".link-generate").on("click", function(){
            let btn = $(this);

            const success = (data) => {
                $('#request_link').val(`{{URL::to('/')}}/request/guest/${data.data.request_link}`);
            }
            
            submit_form("/api/settings/{{$hospital->id}}/generate-link", "post", null, success, btn, false);
        });

        $("#send_link_form").on("submit", function(e){
            e.preventDefault();
            let data = new FormData(this);

            let btn = $(this).find('[type="submit"]');
            submit_file_form("/api/settings/{{$hospital->id}}/send-link", "post", data, undefined, btn, false);
        })
    </script>
@endsection