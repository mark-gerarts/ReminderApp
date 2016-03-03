@extends('layouts.site')

@section('style')
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
@endsection

@section('content')
<main class="container">
    <h1>Thank you!</h1>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <p class="payment-message">{{ $message }}</p>
            <ul class="other-options">
                <li>&gt;&gt; <a href="{{ url('/') }}">Take me back to the homepage</a></li>
                <li>&gt;&gt; <a href="{{ url('/contact') }}">Contact us</a></li>
                <li>&gt;&gt; <a href="{{ url('/register') }}">Create an account</a></li>
            </ul>
        </div>
    </div>
</main>
@endsection


@section('scripts')
    <script>console.log('scripts rendered!')</script>
@endsection
