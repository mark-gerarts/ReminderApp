@extends('layouts.dashboard')

@section('style')
    <link rel="stylesheet" href="css/contacts.css">
@endsection

@section('content')
<div class="container">
    <div class="row row-grid">
        <div class="col-md-2"></div>
        <div class="col-md-10">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Number</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mark gerarts</td>
                        <td>+3265489321</td>
                        <td><a href="#">edit</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script>console.log('scripts rendered!')</script>
@endsection