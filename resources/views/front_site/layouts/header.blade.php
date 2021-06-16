<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <title>@yield('title')</title>
    <meta name="meta_keywords" content="@yield('meta_keywords')">
    <meta name="meta_description" content="@yield('meta_description')">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicons -->
    <link href="{{ asset('imgs/favicon.png') }}" rel="icon">
    <link href="{{ asset('imgs/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    
    <!-- Template Main CSS File -->
    <link href="{{ asset('css/main_front_style.css') }}@php echo '?'.time(); @endphp" rel="stylesheet">
    <script type="text/javascript">
		var APP_URL = {!! json_encode(url('/')) !!}
		var userID = "{{Auth::id()}}"
	</script>
</head>
<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top">
        <div class="container container-xl align-items-center justify-content-between">
            <div class="logo-div">
                <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                    <img class="img-fluid" src="{{ asset('imgs') }}/{{ config('app.app_header_logo') }}" title="{{ config('app.app_email_title') }}">
                </a>
            </div>
            <nav id="navbar" class="navbar">
                <ul>
                	@guest
                    <li><a class="nav-link scrollto" href="{{ route('legal') }}">Legal</a></li>
                    <li><a class="nav-link scrollto" href="{{ route('faq') }}">FAQ</a></li>
                    <li><a class="nav-link scrollto active" href="{{ route('login') }}">Login</a></li>
                    @else
                    <li class="dropdown"><a href="{{ route('dashboard') }}"><span>{{ Auth::user()->name }}</span> <i class="bi bi-gear-fill"></i></a>
                        <ul>
                            <li><a href="{{ route('submissions') }}">Dashboard</a></li>
                            <li><a href="{{ route('legal') }}">Legal</a></li>
                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                            <li><a href="{{ route('logout') }}" onClick="event.preventDefault(); document.getElementById('logout-form').submit();">
								{{ __('Logout') }}
    						</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
                        </ul>
                    </li>
                    @endguest
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
            <!-- .navbar -->
        </div>
    </header>
    <!-- End Header -->
	@yield('content')
    
    @extends('front_site.layouts.footer')  
