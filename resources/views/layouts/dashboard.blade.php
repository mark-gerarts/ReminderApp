<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ReminderApp Dashboard</title>

    <!-- Links loaded on all pages -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,600' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ url('lib/grid12.css') }}">
    <link rel="stylesheet" href="{{ url('css/dashboard.css') }}">
    <!-- Page specific styles -->
    @yield('style')

</head>


<body id="app">
    <div class="container-fluid navbar">
        <div class="container">
            <nav>
                <div class="no-padding-left">
                    <a v-link="{ path: '/'}">Dashboard</a>
                    <i class="fa fa-caret-up fa-fw arrow"></i>
                </div>
                <div><a v-link="{ path: '/contacts' }">Contacts</a></div>
                <div><a v-link="{ path: '/account' }">Account</a></div>
            </nav>
            <div class="user">Logged in as {{ Auth::user()->name }}. <a href="{{ url('/logout') }}" class="log-out">Log out</a></div>
        </div>
    </div>
    <div class="container">
        @yield('content')
    </div>

    @yield('vue-templates')

    <!-- Page specific scripts -->
    @yield('scripts')
</body>
</html>
