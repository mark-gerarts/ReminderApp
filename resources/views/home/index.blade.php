@extends('layouts.site')

@section('style')
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
@endsection

@section('content')
<div class="container-fluid first-heading">
    <div class="container">
        <div class="row row-grid">
            <div class="col-md-8">
                <h1>Set up text message reminders.</h1>
                <p>
                    Create a reminder and receive a text message at the specified date &amp; time. You can set up a reminder in no-time using our quick reminder form.
                </p>
                <a href="#vue-app" class="heading-button">Remind me! &gt;&gt;</a>
            </div>
        </div>
        <!-- http://superawesomevectors.deviantart.com/ -->
        <img src="{{ url('img/smartphone_hand_flipped.png')}}" alt="smartphone image" class="phone-img" />
    </div>
</div>
<main class="container" id="vue-app">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 quick-reminder-title">
            <h2 class="title">Schedule a quick reminder</h2>
            <p>Don't want to sign up? No problem!<br /> Use this form te create a quick reminder - no need to create an account.</p>
        </div>
    </div>
    <div class="row row-grid">
        <div class="col-md-4 overflow">
            <section class="section-right">
                <form class="flat-form" @submit.prevent="handleSubmit">
                    <label><span class="number">1</span>Phone Number</label>
                    <span class="error-message" v-if="validationErrors.recipient">
                        <strong>@{{ validationErrors.recipient }}</strong>
                    </span>
                    <input type="text" placeholder="International format" v-model="newQuickReminder.recipient" @input="validate">

                    <label><span class="number">2</span>Date &amp; time</label>
                    <span class="error-message" v-if="validationErrors.send_datetime">
                        <strong>@{{ validationErrors.send_datetime }}</strong>
                    </span>
                    <input type="datetime" placeholder="DD/MM/YY hh:mm" v-model="newQuickReminder.send_datetime" @input="validate">

                    <label><span class="number">3</span>Message</label>
                    <span class="error-message" v-if="validationErrors.message">
                        <strong>@{{ validationErrors.message }}</strong>
                    </span>
                    <textarea placeholder="Your message!" v-model="newQuickReminder.message" @input="validate"></textarea>
                    <input type="submit" class="btn btn-submit" value="Submit">
                </form>
            </section>
        </div>
        <div class="col-md-6 col-md-offset-2">
            <!-- Adapted from http://codepen.io/2ne/pen/osvpj -->
            <div class="cellphone">
                <div class="cellphone-header">
                    <span class="left">Messages</span>
                    <h2>@{{ phoneRecipient }}</h2>
                    <span class="right">Contact</span>
                </div>
                <div class="messages-wrapper">
                  <div class="message to">
                      @{{ phoneMessage }}
                      <br /><span class="message-time">Received: @{{ phoneDate }}</span>
                  </div>
                  <div class="message from">
                      Oh right! Thanks for reminding me!
                      <br /><span class="message-time">Sending...</span>
                  </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="container-fluid features">
    <main class="container">
        <section class="example-section">
            <h2 class="features-title">Sign up to...</h2>
            <div class="row row-grid">
                <div class="col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2">
                    <img src="{{ url('img/calendar.png')}}" />
                    <h2>Set up repeated reminders</h2>
                    <p>Schedule a reminder to be sent daily, weekly, monthly or even yearly.</p>
                </div>
                <div class="col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2">
                    <img src="{{ url('img/money.png')}}" />
                    <h2>Save money</h2>
                    <p>Signing up gives you the ability to top up your account. This results in cheaper reminders!</p>
                </div>
                <div class="col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2">
                    <img src="{{ url('img/clipboard.png')}}" />
                    <h2>Save contacts</h2>
                    <p>No more need to find everyone's number. Save frequently used numbers in your contact book.</p>
                </div>
            </div>
            <div class="row row-grid">
                <div class="col-md-12">
                    @if (Auth::guest())
                        <a class="btn btn-signup-big" href="{{ url('/register') }}">Sign up</a>
                    @else
                        <a class="btn btn-signup-big" href="{{ url('/dashboard') }}">Dashboard</a>
                    @endif

                </div>
            </div>
        </section>
    </main>
</div>
@endsection


@section('scripts')
    <script>
        var csrf_token = "{{ csrf_token() }}";
        var myRootUrl = "{{ env('MY_ROOT_URL') }}";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.14/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.6.1/vue-resource.js"></script>
    <script src="{{ url('js/vue/mixins/validatorMixin.js') }}"></script>
    <script src="{{ url('js/vue/mixins/remindersMixin.js') }}"></script>
    <script src="{{ url('js/vue/homepage.vue.js')}}"></script>
@endsection
