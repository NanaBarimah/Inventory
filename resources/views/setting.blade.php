@extends('layouts.user-dashboard', ['page_title' => 'Settings'])
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
                            
                        </div>
                    </div>
                </div>
            </div> <!-- wizard container -->
        </div>

    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
@endsection