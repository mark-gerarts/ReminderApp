@extends('layouts.dashboard')

@section('style')
    <link rel="stylesheet" href="{{ url('css/contacts.css') }}">
@endsection

@section('content')
<div class="container" id="app">
    <div class="row row-grid">
        <div class="col-md-7">
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
                    <tr v-show="isLoading.getContacts">
                        <td colspan="3">
                           <i class="fa fa-spinner fa-pulse"></i> Loading
                        </td>
                    </tr>
                    <tr v-show="hasError.getContacts">
                        <td colspan="3">
                           <i class="fa fa-exclamation-triangle error"></i> Something went wrong. <a class="try-again" @click="getContacts()">Try again.</a>
                        </td>
                    </tr>
                    <tr v-for="contact in contacts | orderBy 'name'" is="contact-row" :contact.sync="contact"></tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4 col-md-offset-1">
            <h2>New contact</h2>
            <form action="{{ url('dashboard/contacts') }}" method="post" @submit.prevent="insertContact()" class="contact-form">
                <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
                <label>Name</label>
                <span class="error-message" v-if="validationErrors.name">
                    <strong>@{{ validationErrors.name[0] }}</strong>
                </span>
                <input type="text" name="name" id="name" v-model="newContact.name">
                <label>Number</label>
                <span class="error-message" v-if="validationErrors.number">
                    <strong>@{{ validationErrors.number[0] }}</strong>
                </span>
                <input type="text" name="number" id="number" v-model="newContact.number">
                <button type="submit" class="btn-submit" :disabled="isLoading.insertContact">
                    <span v-show="!isLoading.insertContact">Add contact</span>
                    <span v-show="isLoading.insertContact"><i class="fa fa-spinner fa-pulse"></i></span>
                </button>
                <span v-show="hasError.insertContact">
                    <i class="fa fa-exclamation-triangle error"></i> Something went wrong. Try again.
                </span>
            </form>
        </div>
    </div>
</div>

<script type="x/template" id="contact-template">
    <tr>
        <td v-show="!editing">@{{ contact.name }}</td>
        <td v-else>
            <input value="@{{ contact.name }}" v-model="contact.name">
            <div v-if="validationErrors.name">@{{ validationErrors.name[0] }}</div>
        </td>
        <td v-show="!editing">@{{ contact.number }}</td>
        <td v-else>
            <input value="@{{ contact.number }}" v-model="contact.number">
            <div v-if="validationErrors.number">@{{ validationErrors.number[0] }}</div>
        </td>
        <td class="actions">
            <span v-show="!editing">
                <i class="fa fa-pencil edit" @click="editing = true"></i> 
                <i class="fa fa-times delete" @click="deleteContact" v-show="!isLoading.delete && !hasError.delete"></i>   
                <i class="fa fa-spinner fa-pulse delete" v-show="isLoading.delete"></i>
                <i class="fa fa-exclamation-triangle error" v-show="hasError.delete" title="An error has occurred"></i>
            </span>
            <span v-show="editing">
                <i class="fa fa-floppy-o save" @click="updateContact" ></i>
                <i class="fa fa-spinner fa-pulse" v-show="isLoading.update"></i>
                <i class="fa fa-exclamation-triangle error" v-show="hasError.update" title="An error has occurred"></i>
                <span @click="editing = false" class="cancel">Cancel</span>
            </span>
        </td>
    </tr>
</script>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.14/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.6.1/vue-resource.js"></script>
    <script src=" {{ url('js/contacts.vue.js') }}"></script>
@endsection