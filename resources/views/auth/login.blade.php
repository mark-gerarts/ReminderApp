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
                @if ($errors->has('password'))
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
