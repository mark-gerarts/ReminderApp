@extends('layouts.site')

@section('style')
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
@endsection

@section('content')
<main class="container pricing">
    <h1>Pricing</h1>
    <p>Submitting quick reminder costs <span class="quick-price">&euro; 0.50</span> per reminder.</p>
    <p>Creating an account is free, and gives you the option to buy packages.</p>
    <div class="row">
        <div class="col-md-12">
            <table class="pricing-table">
                <thead>
                    <tr>
                        <th>Option</th>
                        <th>Price</th>
                        <th>Reminders</th>
                        <th>&euro;/reminder</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#1</td>
                        <td><span class="price">&euro;</span> 5</td>
                        <td>20 reminders</td>
                        <td>&euro; 0,25/reminder</td>
                    </tr>
                    <tr>
                        <td>#2</td>
                        <td><span class="price">&euro;</span> 10</td>
                        <td>50 reminders</td>
                        <td>&euro; 0,20/reminder</td>
                    </tr>
                    <tr>
                        <td>#3</td>
                        <td><span class="price">&euro;</span> 15</td>
                        <td>100 reminders</td>
                        <td>&euro; 0,15/reminder</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection


@section('scripts')
    <script>console.log('scripts rendered!')</script>
@endsection
