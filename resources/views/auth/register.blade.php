@extends('layouts.site')

@section('style')
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/register.css">
@endsection

@section('content')
<main class="container">
    <div class="row">
        <div class="col-xs-12">
            <h1>Sign up</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <form method="post" action="{{ url('register') }}" class="register-form">
                {!! csrf_field() !!}
                <label for="name"><span class="number">1</span>Name</label>
                @if ($errors->has('name'))
                    <span class="error-message">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
                <input type="text" name="name" value="{{ old('name') }}">
                
                
                <label for="email"><span class="number">2</span>E-mail Address</label>
                @if ($errors->has('email'))
                    <span class="error-message">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <input type="email" name="email" value="{{ old('email') }}">
                
                
                <label for="password"><span class="number">3</span>Password</label>
                @if ($errors->has('password'))
                    <span class="error-message">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <input type="password" name="password">
                
                
                <label for="password_confirmation"><span class="number">4</span>Confirm Password</label>
                @if ($errors->has('password_confirmation'))
                    <span class="error-message">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
                <input type="password" name="password_confirmation">
                

                <button type="submit" class="btn btn-submit">Register</button>
                <p class="addendum">
                    Already have an account? <a href="{{ url('/login') }}" class="register-link"><strong>Sign in here.</strong></a>
                </p>   
            </form>
        </div>
    </div>
</main>
@endsection
<!--
    Laravel generated code -- DELETE ME
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

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

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
-->