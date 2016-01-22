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
                            <p v-for="contact in contacts | filterBy query in '[name,number]' | orderBy 'name' | limitBy 6 " @mousedown="selectContact(contact)">@{{contact.name}} (@{{contact.number}})</p>
                        </div>
                    </div>
                </div>
                <label><span class="number">2</span>Date &amp; time</label>
                <input type="datetime" placeholder="DD/MM/YY hh:mm">

                <label><span class="number">3</span>Message</label>
                <textarea placeholder="Your message!"></textarea>
                
                <label><span class="number">4</span>Repeat</label>
                <select>
                    <option>Never</option>
                    <option>Daily</option>
                    <option>Weekly</option>
                    <option>Monthly</option>
                    <option>Yearly</option>
                </select>
                
                <input type="submit" class="btn btn-submit" value="Submit">
            </form>
       </div>
        <div class="col-md-7 col-md-offset-1">
           <h2>Upcoming reminders</h2>
            <table>
                <thead>
                    <tr>
                        <th>To</th>
                        <th>Date</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        <p>DEBUG</p>
        <pre>@{{ $data | json }}</pre>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.14/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.6.1/vue-resource.js"></script>
    <script src="{{ url('js/dashboard.vue.js')}}"></script>
@endsection