@extends('layouts.site')

@section('style')
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
@endsection

@section('content')
<main class="container">
    <div class="row row-grid">
        <div class="col-xs-12">
            <h1>Set up text message reminders.</h1>
        </div>
    </div>
    <div class="row row-grid">
        <div class="col-md-6 section-left">
            <h2>Easy to use</h2>
            <p>Create a reminder and receive a text message at the specified date &amp; time.</p>
            <p>Don't want to create an account? No problem. You can use the quick reminder form without signing up.</p>

            <h2 class="title-margin">Signing up is <span class="highlight-text">free</span></h2>
            <p>//ToDo: Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis mollitia natus quas, repudiandae necessitatibus perspiciatis dignissimos libero minus neque dolore quo modi, voluptates, praesentium recusandae accusantium dolorum obcaecati quis excepturi.</p>
            <ul>
                <li><i class="fa fa-check"></i> Save money</li>
                <li><i class="fa fa-check"></i> Create a contact list</li>
                <li><i class="fa fa-check"></i> Schedule repeated reminders</li>
                <li><i class="fa fa-check"></i> Get reminders in your mailbox</li>
            </ul>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi, consectetur nisi!</p>
            <div class="row">
                <div class="col-xs-8 col-xs-offset-4 col-md-offset-0">
                    <a href="{{ url('register') }}" class="btn sign-up">Sign up</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-offset-2">
            <section class="section-right" id="app">
                <h2>Quick Reminder</h2>
                <p>Schedule a quick reminder without the need of creating an account.</p>
                <pre>@{{ $data.newReminder | json}}</pre>
                <form class="quick-reminder-form" @submit.prevent="submitReminder">
                    <input type="hidden" id="csrf_token" value="{{ csrf_token()}}">
                    <label><span class="number">1</span>Phone Number</label>
                    <input type="text" placeholder="International format" v-model="newReminder.recipient">

                    <label><span class="number">2</span>Date &amp; time</label>
                    <input type="datetime" placeholder="DD/MM/YY hh:mm" v-model="newReminder.send_datetime">

                    <label><span class="number">3</span>Message</label>
                    <textarea placeholder="Your message!" v-model="newReminder.message"></textarea>
                    <input type="submit" class="btn btn-submit" value="Submit">
                </form>
            </section>
        </div>
    </div>
</main>
<div class="container-fluid features">
    <main class="container">
        <section class="example-section">
            <h2 class="features-title">Sign up to...</h2>
            <div class="row row-grid">
                <div class="col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2">
                    <span class="icon-bubble"><i class="fa fa-eur fa-lg"></i></span>
                    <h2>Save money</h2>
                    <p>Signing up gives you the ability to top up your account. This results in cheaper reminders!</p>
                </div>
                <div class="col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2">
                    <span class="icon-bubble"><i class="fa fa-calendar fa-lg"></i></span>
                    <h2>Set up repeated reminders</h2>
                    <p>Schedule a reminder to be send daily, weekly, monthly or even yearly.</p>
                </div>
                <div class="col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2">
                    <span class="icon-bubble"><i class="fa fa-users fa-lg"></i></span>
                    <h2>Save contacts</h2>
                    <p>No more need to find everyone's number. Save frequently used numbers in your contact book.</p>
                </div>
            </div>
            <div class="row row-grid">
                <div class="col-md-12">
                    <a class="btn btn-signup-big" href="{{ url('/register') }}">Sign up</a>
                </div>
            </div>
        </section>
    </main>
</div>
@endsection


@section('scripts')
    <script>
        var myRootUrl = "{{ env('MY_ROOT_URL') }}";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.14/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.6.1/vue-resource.js"></script>
    <script src="{{ url('js/home.vue.js')}}"></script>
@endsection
