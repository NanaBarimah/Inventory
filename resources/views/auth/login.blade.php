@extends('layouts.login-layout')

@section('content')
<!--div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div-->
<div class="col-md-4 col-sm-8 center overlap-30">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
            {{ __('Login') }}
            </h5>
         </div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
            @csrf
                <div class="form-group">
                    @if ($errors->has('active'))
                        <span class="invalid-feedback text-center" role="alert">
                            <strong>This account has been deactivated</strong>
                        </span>
                    @endif
                    <input type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" id="username" aria-describedby="username" placeholder="Username" name="username" value="{{ old('username') }}" required autofocus>
                    @if ($errors->has('username'))
                        <span class="invalid-feedback text-center" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" aria-describedby="password" placeholder="Password" name="password" value="{{ old('password') }}" required autofocus>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback text-center" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" {{ old('remember') ? 'checked' : '' }} id="remember" name="remember">
                        Remember Me
                        <span class="form-check-sign">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-lg btn-purple"> Login </button>
                </div>
            </form>
            <p class="text-center">Are you a regional <b>administrator</b>? Login <a href="/admin/login">here</a>
        </div>
    </div>
</div>
@endsection
