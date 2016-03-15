@extends('layouts.site')

@section('style')
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
@endsection

@section('content')
<main class="container-fluid">
    <h1>Contact us</h1>
    <p class="center">
        {{ isset($message) ? $message : '' }}
    </p>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <form class="flat-form overflow" method="post" action="{{ url('/contact') }}">
                {!! csrf_field() !!}
                <label for="email">Your email</label>
                @if ($errors->has('email'))
                    <span class="error-message">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <input type="text" id="email" name="email" placeholder="Your email"/>

                <label for="subject">Subject</label>
                @if ($errors->has('subject'))
                    <span class="error-message">
                        <strong>{{ $errors->first('subject') }}</strong>
                    </span>
                @endif
                <input type="text" id="subject" name="subject" placeholder="Subject"/>

                <label for="message">Your message</label>
                @if ($errors->has('message'))
                    <span class="error-message">
                        <strong>{{ $errors->first('message') }}</strong>
                    </span>
                @endif
                <textarea id="message" rows="10" name="message" placeholder="Your message"></textarea>

                <button class="btn btn-submit margin-bottom">Submit</button>
            </form>
        </div>
    </div>
</main>
@endsection
