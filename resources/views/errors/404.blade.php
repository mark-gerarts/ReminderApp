@extends('layouts.site')

@section('style')
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
@endsection

@section('content')
<main class="container">
    <h1 class="center">Page not found</h1>
    <p class="center">The page you requested was not found.</p>
    <p class="center">&gt;&gt; <a href="{{ url('/') }}" style="text-decoration:underline">Take me back to the homepage</a></p>
</main>
@endsection
