<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="google-site-verification" content="0g_4LzjtPrz_dqHD9jIffdGqf3rnQxMTHIeK77-z2Rs" />
    
    <title>@yield('title')</title>
    <meta name="meta_keywords" content="@yield('meta_keywords')">
    <meta name="meta_description" content="@yield('meta_description')">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	
    <!-- Favicons -->
    <link href="{{ asset('imgs/favicon.png') }}" rel="icon">
    <link href="{{ asset('imgs/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Custom CSS -->
    <link href="{{ asset('css/main_style.css') }}@php echo '?'.time(); @endphp" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
	<script src="//code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}@php echo '?'.time(); @endphp" rel="stylesheet">
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
    
    <script type="text/javascript">
		var APP_URL = {!! json_encode(url('/')) !!}
		var userID = "{{Auth::id()}}"
	</script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-dark shadow-sm">
        <div class="hderrr" style="width:100%;">
            <div class="col-md-12">
            	@guest
            	<div class="col-md-4 text-left col-xs-4 pull-left mobile-nav-icon"><span class="nav_icon" style="background-color:#000000 !important"></div>
                @else
            	<div class="col-md-4 text-left col-xs-4 pull-left mobile-nav-icon sh2" style="padding-left: 0px;"><a href="javascript:;" onClick="openNav()"><span class="nav_icon"></span><span class="nav_icon"></span><span class="nav_icon"></span></a></div>
                @endguest
                
                <div class="col-md-4 text-center col-xs-4 pull-left mobile-nav-logo">
                    <a class="navbar-brand" href="{{ url('/submissions') }}">
                        <img src="{{ asset('imgs') }}/{{ config('app.app_header_logo') }}" title="{{ config('app.app_email_title') }}">
                    </a>
                </div>
                <div class="col-md-4 text-right col-xs-4 pull-left mobile-nav-settings">
                	<ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        	<style>.nav-item {display: inline-block;}</style>
                            <li class="nav-item mobile-login-link">
                                <a class="nav-link" href="{{ route('legal') }}">{{ __('Legal') }}</a>
                            </li>
                            <li class="nav-item mobile-login-link">
                                <a class="nav-link" href="{{ route('faq') }}">{{ __('FAQ') }}</a>
                            </li>
                            <li class="nav-item mobile-login-link">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <!--<li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>-->
                            @endif
                        @else
                        	<li class="nav-item dropdown" style="position:relative;">
                                <a id="navbarDropdownnoti" class="nav-link text-light dropdown-toggle" onClick="readNoti();" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                	<i class="fa fa-bell"><span class="noti_counter" id="noti_counter"></span></i>
                                </a>
                                <ul class="dropdown-menu notifi" id="noti_result_data"></ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                   <span class="author_name"> {{ Auth::user()->name }}</span><i class="fa fa-cog"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" id="logout_drp">
                                	@role('admin')
                                    <a class="dropdown-item" href="{{ route('white_labels') }}">
                                        {{ __('Publisher Settings') }}
                                    </a>
                                    @endrole
                                    <a class="dropdown-item" href="{{ route('my_profile') }}">
                                        {{ __('My Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
        </nav>
        
        @guest
        @else
        
        @role('admin')
            <div id="mySidenav" class="sidenav">
                <h4>IRP System</h4>
                <ul class="navside_list">
                    <li><a href="{{ url('submissions') }}">Dashboard</a></li>
                    <li class="dropdown">
                    	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Users <i class="fa fa-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <li class="active"><a href="{{ url('/add_new_user') }}">Add New Users</a></li>
                            <li class=""><a href="{{ url('manage_users') }}">Manage Users</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pitches <i class="fa fa-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <li class=""><a href="{{ route('create_pitch') }}">Create Pitch</a></li>
                            <li class=""><a href="{{ route('pitches') }}">Manage Pitches</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Submissions <i class="fa fa-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <li class=""><a href="{{ route('submissions') }}">All Submissions</a></li>
                            <!--<li class=""><a href="#">Search</a></li>-->
                            <!--<li class=""><a href="{{ route('create_submission') }}">Create Submission</a></li>-->
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Profiles <i class="fa fa-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <li class=""><a href="{{ route('profiles') }}">Writer Profiles</a></li>
                        </ul>
                    </li>
                    
                    <li><a href="{{ route('reports') }}">Reporting</a></li>
                </ul>
			</div>
        @endrole
        
        @role('editor')
            <div id="mySidenav" class="sidenav">
                <h4>IRP System</h4>
                <ul class="navside_list">
                    <li><a href="{{ url('submissions') }}">Dashboard</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pitches <i class="fa fa-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <li class=""><a href="{{ route('create_pitch') }}">Create Pitch</a></li>
                            <li class=""><a href="{{ route('pitches') }}">Manage Pitches</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Submissions <i class="fa fa-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <li class=""><a href="{{ route('submissions') }}">All Submissions</a></li>
                            <!--<li class=""><a href="{{ route('create_submission') }}">Create Submission</a></li>-->
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Profiles <i class="fa fa-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <li class=""><a href="{{ route('profiles') }}">Writer Profiles</a></li>
                        </ul>
                    </li>
                </ul>
			</div>
        @endrole
        
        @role('writer')
            <div id="mySidenav" class="sidenav">
                <h4>IRP System</h4>
                <ul class="navside_list">
                    <li><a href="{{ url('submissions') }}">Dashboard</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pitches <i class="fa fa-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <li class=""><a href="{{ route('create_pitch') }}">Create Pitch</a></li>
                            <li class=""><a href="{{ route('pitches') }}">My Pitches</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Submissions <i class="fa fa-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <li class=""><a href="{{ route('submissions') }}">My Submissions</a></li>
                        </ul>
                    </li>
                </ul>
			</div>
        @endrole

        @endguest
        
        @if (\Request::is('login'))  
			<div class="login_fullwidth">
                @yield('content')
            </div> 
        @else
            <div class="container">
                @yield('content')
            </div>
        @endif
    </div>
    @extends('layouts.footer')
    <style>
		.login_fullwidth .half_Sec_left {
			background: #EBEBEB;
			float: left;
			width: 50%;
		}
		.login_fullwidth .half_Sec_right {
			background: #fff;
			float: left;
			width: 50%;
		}
	</style>
