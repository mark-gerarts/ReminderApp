@extends('layouts.dashboard')

@section('style')
    <link rel="stylesheet" href="css/contacts.css">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <p>Contacts</p>
            <ol>
            @foreach($contacts as $contact)
                <li>{{ $contact->name }}, {{ $contact->number }}</li>
            @endforeach
            </ol>
        </div>
        <div class="col-md-8">
           <p>Add a contact:</p>
            <form action="{{ url('dashboard/contacts') }}" method="post">
            {!! csrf_field() !!}
            <p>
                <label>Name</label>
                @if ($errors->has('name'))
                    <span class="error-message">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
                <input type="text" name="name" id="name">
            </p>
            <p>
                <label>Number</label>
                @if ($errors->has('number'))
                    <span class="error-message">
                        <strong>{{ $errors->first('number') }}</strong>
                    </span>
                @endif
                <input type="text" name="number" id="number">
            </p>
            <p>
                <input type="submit">
            </p>
            </form>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script>console.log('scripts rendered!')</script>
@endsection