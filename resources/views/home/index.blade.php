@extends('layouts.site')

@section('style')
    <link rel="stylesheet" href="css/main.css">
@endsection

@section('content')
<main class="container">
    <div class="row">
        <div class="col-xs-12">
            <h1>Set up text message reminders.</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 section-left">
            <h2>Easy to use</h2>
            <p>Get your reminders sent to you -or a friend- through SMS. </p>
            <ol>
                <li>Lorem ipsum.</li>
                <li>Dolor sit amet.</li>
                <li>Consectetur ipse.</li>
            </ol>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio quo, corrupti laudantium harum similique nobis aspernatur eius, minus impedit, quod consequuntur! Itaque mollitia facere obcaecati nesciunt. Porro, sit perspiciatis. Nulla.</p>
            <a href="register" class="btn sign-up">Sign up</a>
        </div>
        <div class="col-md-4 col-md-offset-2">
            <section class="section-right">
                <h2>Quick Reminder</h2>
                <p>You can schedule a quick reminder without the need of creating an account.</p>
                <form class="quick-reminder-form">
                    <label><span class="number">1</span>Phone Number</label>
                    <input type="text" placeholder="International format">

                    <label><span class="number">2</span>Date &amp; time</label>
                    <input type="datetime" placeholder="DD/MM/YY hh:mm">

                    <label><span class="number">3</span>Message</label>
                    <textarea placeholder="Your message!"></textarea>
                    <input type="submit" class="btn btn-submit" value="Submit">
                </form>
            </section>
        </div>
    </div>
    <div class="hidden-sm arrow-down">
        &gt;
    </div>
</main>
<main class="container">
    <section class="example-section">
        <h2>Lorem ipsum dolor sit amet, consectetur.</h2>
        <div class="example">
            <div class="example-placeholder">Placeholder</div>
            <div class="example-arrow"><i class="fa fa-arrow-right"></i></div>
            <div class="example-placeholder">Placeholder</div>
            <div class="example-arrow"><i class="fa fa-arrow-right"></i></div>
            <div class="example-placeholder">Placeholder</div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-4">lorem</div>
        <div class="col-md-4">lorem</div>
        <div class="col-md-4">lorem</div>
    </div>
</main>
@endsection


@section('scripts')
    <script>console.log('scripts rendered!')</script>
@endsection