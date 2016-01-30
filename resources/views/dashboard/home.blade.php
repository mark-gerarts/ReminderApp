@extends('layouts.dashboard')

@section('style')
@endsection

@section('content')
<div class="container" id="app">
    <div class="row">
       <div class="col-md-4">
           <h2>Schedule a Reminder</h2>
            <form class="reminder-form">
                <input type="hidden" id="csrf_token" value="{{ csrf_token()}}">
                
                
                <label><span class="number">1</span>Phone Number</label>
                <div class="suggestion-wrapper">
                    <input  type="text" placeholder="International format" id="fi_search" 
                            v-model="query" 
                            @focus="showSuggestions = true" 
                            @blur="showSuggestions = false"
                            autocomplete="off"
                    >
                    <div class="suggestionbox-wrapper" v-show="query.length > 1 && showSuggestions">
                        <div class="suggestionbox">
                            <p v-for="contact in contacts | filterBy query in 'name' 'number' | orderBy 'name' | limitBy 6 " @mousedown="selectContact(contact)">@{{contact.name}} (@{{contact.number}})</p>
                        </div>
                    </div>
                </div>
                <label><span class="number">2</span>Date &amp; time</label>
                <input type="text" placeholder="DD/MM/YY hh:mm" v-model="newReminder.datetime">

                <label><span class="number">3</span>Message</label>
                <textarea placeholder="Your message!" v-model="newReminder.message"></textarea>
                
                <label><span class="number">4</span>Repeat</label>
                <select v-model="newReminder.repeatId">
                    <option value="0">Never</option>
                    <option value="1">Daily</option>
                    <option value="2">Weekly</option>
                    <option value="3">Monthly</option>
                    <option value="4">Yearly</option>
                </select>
                
                <input type="submit" class="btn btn-submit" value="Submit" @click.prevent="submitReminder">
            </form>
       </div>
        <div class="col-md-7 col-md-offset-1">
            <h2>Upcoming reminders</h2>
            <table class="upcoming-table">
                <thead>
                    <tr>
                        <th>To</th>
                        <th>Date &amp; time</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="reminder in upcomingReminders | orderBy 'send_datetime'">
                        <td v-if="reminder.contact_id">
                            <span v-for="contact in contacts | exactFilterBy reminder.contact_id in 'id'">@{{ contact.name }}</span>
                        </td>
                        <td v-else>@{{ reminder.recipient }}</td>
                        <td>@{{ reminder.send_datetime.substr(0, reminder.send_datetime.length-3) }}</td>
                        <td>@{{ reminder.message }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.14/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.6.1/vue-resource.js"></script>
    <script src="{{ url('js/dashboard.vue.js')}}"></script>
@endsection