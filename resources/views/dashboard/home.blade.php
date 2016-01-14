@extends('layouts.dashboard')

@section('style')
    
@endsection

@section('content')
<div class="row row-grid">
    <div class="col-md-4">
        <h2>Create a reminder</h2>
        <form class="reminder-form">
            <label><span class="number">1</span>Phone Number</label>
            <input type="text" placeholder="International format">

            <label><span class="number">2</span>Date &amp; time</label>
            <input type="datetime" placeholder="DD/MM/YY hh:mm">

            <label><span class="number">3</span>Message</label>
            <textarea placeholder="Your message!"></textarea>

            <label><span class="number">4</span>Repeat</label>
            <select>
                <option value="">Never</option>
                <option value="">Daily</option>
                <option value="">Weekly</option>
                <option value="">Monthly</option>
                <option value="">Yearly</option>
            </select>
            <input type="submit" class="btn btn-submit" value="Submit">
        </form>
    </div>
    <div class="col-md-6 col-md-offset-2">
        <h2>Balance:</h2>
        <p>&euro; 15</p>
        <a href=" {{ url('/') }}">Top up</a>
    </div>
</div>
@endsection


@section('scripts')
    <script>console.log('scripts rendered!')</script>
@endsection