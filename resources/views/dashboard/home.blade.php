@extends('layouts.dashboard')

@section('style')
    
@endsection

@section('content')
<div class="container">
    <div class="row">
       <div class="col-md-4">
           <h2>Schedule a Reminder</h2>
            <form class="reminder-form">
                <label><span class="number">1</span>Phone Number</label>
                <input type="text" placeholder="International format">

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
        <div class="col-md-3">
            <section>
                <h2>Balance:</h2>
                <p>&euro; 15</p>
                <a href=" {{ url('/') }}">Top up</a>
            </section>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script>console.log('scripts rendered!')</script>
@endsection