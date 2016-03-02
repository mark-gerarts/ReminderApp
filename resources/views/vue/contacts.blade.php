<template id="dashboard-contacts">
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

                {{-- Contacts table --}}
                <tbody>
                    {{-- Loading spinner --}}
                    <tr v-show="isLoading.getContacts">
                        <td colspan="3">
                           <i class="fa fa-spinner fa-pulse"></i> Loading
                        </td>
                    </tr>
                    {{-- Error message --}}
                    <tr v-show="errors.getContacts">
                        <td colspan="3">
                           <i class="fa fa-exclamation-triangle error"></i> Something went wrong. <a class="try-again" @click="getContacts">Try again.</a>
                        </td>
                    </tr>
                    {{-- v-for on contactRow component, if everything is loaded succesfully --}}
                    <tr v-for="contact in sharedState.contacts | orderBy 'name'" is="contact-row" :contact.sync="contact"></tr>
                    {{-- Message shown when there are no contacts --}}
                    <tr v-if="sharedState.contacts.length == 0 && !isLoading.getContacts">
                        <td colspan="3">No contacts yet!</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4 col-md-offset-1">
            <h2>New contact</h2>
            {{-- New Contact form --}}
            <form action="{{ url('dashboard/contacts') }}" method="post" @submit.prevent="handleInsert" class="flat-form">
                <label>Name</label>
                <span class="error-message" v-if="validationErrors.name">
                    <strong>@{{ validationErrors.name }}</strong>
                </span>
                <input type="text" name="name" id="name" v-model="newContact.name" @input="validate">

                <label>Number</label>
                <span class="error-message" v-if="validationErrors.number">
                    <strong>@{{ validationErrors.number }}</strong>
                </span>
                <input type="text" name="number" id="number" v-model="newContact.number" @input="validate">

                <button type="submit" class="btn-submit" :disabled="isLoading.insertContact">
                    <span v-show="!isLoading.insertContact">Add contact</span>
                    <span v-show="isLoading.insertContact"><i class="fa fa-spinner fa-pulse"></i></span>
                </button>

                <span v-show="errors.insertContact">
                    <i class="fa fa-exclamation-triangle error"></i> Something went wrong. Try again.
                </span>
            </form>
        </div>
    </div>
</template>
