@extends('layouts.dashboard')

@section('style')
    
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h2>Balance:</h2>
            <p>&euro; 15</p>
            <a href=" {{ url('/') }}">Top up</a>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script>console.log('scripts rendered!')</script>
@endsection