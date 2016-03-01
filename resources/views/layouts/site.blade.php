<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ReminderApp</title>

    <!-- Links loaded on all pages -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,600' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ url('lib/grid12.css')}}">

    <!-- Page specific styles -->
    @yield('style')
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid nav-wrapper">
            <header>
                <nav class="container">
                    <ul class="nav-left">
                        <li class="no-padding-left">
                            <a href="{{ url('/') }}"><span class="logo"><span class="logo-brand">Brand</span><span class="logo-name">Name</span></span></a>
                        </li>
                    </ul>
                    <ul class="nav-right">
                        <li><a href="{{ url('home/faq') }}">Contact</a></li>
                        <li><a href="{{ url('/home/pricing') }}">Pricing</a></li>
                        @if (Auth::guest())
                            <li class="no-padding-right"><a href="{{ url('/login') }}" class="highlight-text">Sign in</a></li>
                        @else
                            <li class="no-padding-right"><a href="{{ url('/dashboard') }}" class="highlight-text">Dashboard</a></li>
                        @endif
                    </ul>
                </nav>
            </header>
        </div>
        @yield('content')

        <footer>
            &copy; 2015
        </footer>
    </div>
    <!-- Page specific scripts -->
    @yield('scripts')
</body>
</html>
