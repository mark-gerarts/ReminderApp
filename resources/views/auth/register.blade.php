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
            <form method="post" action="{{ url('register') }}" class="flat-form">
                {!! csrf_field() !!}
                <label for="name"><span class="number">1</span>Name</label>
                @if ($errors->has('name'))
                    <span class="error-message">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
                <input type="text" name="name" id="name" value="{{ old('name') }}">


                <label for="email"><span class="number">2</span>E-mail Address</label>
                @if ($errors->has('email'))
                    <span class="error-message">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <input type="email" name="email" id="email" value="{{ old('email') }}">


                <label for="password"><span class="number">3</span>Password</label>
                @if ($errors->has('password'))
                    <span class="error-message">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <input type="password" name="password" id="password">


                <label for="password_confirmation"><span class="number">4</span>Confirm Password</label>
                @if ($errors->has('password_confirmation'))
                    <span class="error-message">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
                <input type="password" name="password_confirmation" id="password_confirmation">


                <button type="submit" class="btn btn-submit">Register</button>
                <p class="addendum">
                    Already have an account? <a href="{{ url('/login') }}" class="register-link"><strong>Sign in here.</strong></a>
                </p>
            </form>
        </div>
    </div>
</main>
@endsection
