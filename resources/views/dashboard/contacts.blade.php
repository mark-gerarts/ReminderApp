@extends('layouts.dashboard')

@section('style')
    <link rel="stylesheet" href="{{ url('css/contacts.css') }}">
@endsection

@section('content')
<div class="container" id="app">
    <div class="row">
        <div class="col-md-4">
            <!--<p>Contacts</p>
            <ol>
            @foreach($contacts as $contact)
                <li>{{ $contact->name }}, {{ $contact->number }}</li>
            @endforeach
            </ol>-->
            <ul>
                <li v-for="contact in contacts">
                    @{{ contact.name }} - @{{ contact.number }}
                    <a @click.prevent="deleteContact(contact)">delete</a>
                </li>
            </ul>
            
        </div>
        <div class="col-md-8">
           <p>Add a contact:</p>
            <form action="{{ url('dashboard/contacts') }}" method="post" @submit.prevent="insertContact()">
            {!! csrf_field() !!}
            <span style="display:none" id="csrf_token">{{ csrf_token() }}</span>
            <p>
                <label>Name</label>
                @if ($errors->has('name'))
                    <span class="error-message">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
                <input type="text" name="name" id="name" v-model="newContact.name">
            </p>
            <p>
                <label>Number</label>
                @if ($errors->has('number'))
                    <span class="error-message">
                        <strong>{{ $errors->first('number') }}</strong>
                    </span>
                @endif
                <input type="text" name="number" id="number" v-model="newContact.number">
            </p>
            <p>
                <input type="submit">
            </p>
            </form>
            <pre>@{{ $data.newContact | json }}</pre>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.14/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.6.1/vue-resource.js"></script>
    <script src=" {{ url('js/contacts.vue.js') }}"></script>
@endsection