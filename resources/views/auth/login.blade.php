@extends('layouts.site')

@section('style')
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
@endsection

@section('content')
<main class="container">
    <div class="row">
        <div class="col-xs-12">
            <h1>Sign in</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <form method="post" action="{{ url('login') }}" class="flat-form">
                {!! csrf_field() !!}
                <label for="email">E-mail Address</label>
                @if ($errors->has('email'))
                    <span class="error-message">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <input type="email" name="email" id="email" value="{{ old('email') }}">


                <label for="password">Password</label>
                @if ($errors->has('email'))
                    <span class="error-message">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <input type="password" name="password" id="password">


                <label class="checkbox">
                    <input type="checkbox" name="remember" id="remember_me"> Remember Me
                </label>

                <button type="submit" class="btn btn-submit">
                    Log in
                </button>
                <p class="addendum">
                    <a href="{{ url('/password/reset')}}">Forgot your password?</a>
                </p>
                <p class="addendum">
                    Not a user yet? <a href="{{ url('/register') }}" class="register-link"><strong>Register here.</strong></a>
                </p>
            </form>
        </div>
    </div>
</main>
@endsection
<!-- Laravel generated code, for reference DELETE ME EVENTUALLY
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Login
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div-->
