@extends('layouts.dashboard')

@section('style')
    <link rel="stylesheet" href="{{ url('css/contacts.css') }}">
@endsection

@section('content')
<div class="container" id="app">
    <h1>Contacts</h1>
    <div class="row row-grid">
        <div class="col-md-7">
            <!--<p>Contacts</p>
            <ol>
            @foreach($contacts as $contact)
                <li>{{ $contact->name }}, {{ $contact->number }}</li>
            @endforeach
            </ol>-->
            <table class="contacts">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Number</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="contact in contacts">
                        <td>@{{ contact.name }}</td>
                        <td>@{{ contact.number }}</td>
                        <td><i class="fa fa-pencil"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4 col-md-offset-1">
            <form action="{{ url('dashboard/contacts') }}" method="post" @submit.prevent="insertContact()" class="contact-form">
                {!! csrf_field() !!}
                <span style="display:none" id="csrf_token">{{ csrf_token() }}</span>
                <label>Name</label>
                @if ($errors->has('name'))
                    <span class="error-message">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
                <input type="text" name="name" id="name" v-model="newContact.name">
                <label>Number</label>
                @if ($errors->has('number'))
                    <span class="error-message">
                        <strong>{{ $errors->first('number') }}</strong>
                    </span>
                @endif
                <input type="text" name="number" id="number" v-model="newContact.number">
                <input type="submit" class="btn-submit">
            </form>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.14/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.6.1/vue-resource.js"></script>
    <script src=" {{ url('js/contacts.vue.js') }}"></script>
@endsection