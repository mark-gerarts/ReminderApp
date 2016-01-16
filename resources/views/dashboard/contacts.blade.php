@extends('layouts.dashboard')

@section('style')
    <link rel="stylesheet" href="{{ url('css/contacts.css') }}">
@endsection

@section('content')
<div class="container" id="app">
    <div class="row row-grid">
        <div class="col-md-7">
            <!--<p>Contacts</p>
            <ol>
            @foreach($contacts as $contact)
                <li>{{ $contact->name }}, {{ $contact->number }}</li>
            @endforeach
            </ol>-->
            <h2>Contacts</h2>
            <table class="contacts">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Number</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <!--<tr v-for="contact in contacts">
                        <td>@{{ contact.name }}</td>
                        <td>@{{ contact.number }}</td>
                        <td><i class="fa fa-pencil"></i></td>
                    </tr>-->
                    <tr v-for="contact in contacts" is="contact-row" :contact.sync="contact" :editing="false"></tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4 col-md-offset-1">
            <h2>New contact</h2>
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
                <input type="submit" class="btn-submit" value="Add contact">
            </form>
        </div>
    </div>
</div>

<template id="contact-template">
    <tr>
        <td v-show="!editing">@{{ contact.name }}</td>
        <td v-else>
            <input value="@{{ contact.name }}" v-model="contact.name">
        </td>
        <td v-show="!editing">@{{ contact.number }}</td>
        <td v-else>
            <input value="@{{ contact.number }}" v-model="contact.number">
        </td>
        <td class="actions">
            <span v-show="!editing">
                <i class="fa fa-pencil edit" @click="editing = true"></i> 
                <i class="fa fa-times delete" @click="$parent.deleteContact(contact)"></i>   
            </span>
            <span v-show="editing">
                <i class="fa fa-floppy-o save" @click="updateContact()" ></i>
                <span @click="editing = false" class="cancel">Cancel</span>
            </span>
            
        </td>
    </tr>
</template>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.14/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.6.1/vue-resource.js"></script>
    <script src=" {{ url('js/contacts.vue.js') }}"></script>
@endsection