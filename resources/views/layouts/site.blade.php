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
    <link rel="stylesheet" href="lib/grid12.css">
    
    <!-- Page specific styles -->
    @yield('style')
    
</head>

<!--

    Laravel generated body;
    as reference; DELETE ME

<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#spark-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                
                <a class="navbar-brand" href="{{ url('/') }}">
                    Laravel
                </a>
            </div>

            <div class="collapse navbar-collapse" id="spark-navbar-collapse">
                
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                </ul>

                
                <ul class="nav navbar-nav navbar-right">
                    
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
-->
   
<body>
    <header>
        <nav class="container">
            <ul class="nav-left">
                <li class="no-padding-left">
                    <a href="{{ url('/') }}"><span class="logo"><span class="logo-brand">Brand</span><span class="logo-name">Name</span></span></a>
                </li>
            </ul>
            <ul class="nav-right">
                <li><a href="{{ url('home/faq') }}">FAQ</a></li>
                <li><a href="{{ url('/home/pricing') }}">Pricing</a></li>
                @if (Auth::guest())
                    <li class="no-padding-right"><a href="{{ url('/login') }}" class="highlight-text">Sign in</a></li>
                @else
                    <li class="no-padding-right"><a href="{{ url('/dashboard') }}" class="highlight-text">Dashboard</a></li>
                @endif
            </ul>
        </nav>
    </header>
    <div class="wrapper">
        @yield('content')
        <!-- Scripts used on all pages -->

        <footer>
            &copy; 2015
        </footer>
    </div>
    <!-- Page specific scripts -->
    @yield('scripts')
</body>
</html>
