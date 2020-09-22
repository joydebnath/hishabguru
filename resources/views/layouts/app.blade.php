<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/buefy.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">

    <style>
        .title {
            color: #636b6f;
            font-family: 'Raleway', sans-serif !important;
            font-size: 19px !important;
            letter-spacing: 1.5px !important;
            margin-top: 5px !important;
            margin-left: 5px !important;
        }

        #app {
            min-height: 100vh;
        }

        .dropdown-menu {
            padding-bottom: 0
        }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand flex flex-row items-center p-0" href="{{ url('/') }}">
                <img src="{{asset('/images/logo.png')}}" alt="logo" class="d-inline" style="width: 110px">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle nav-item text-base leading-6 px-3 py-2 font-medium focus:outline-none hover:no-underline text-gray-600 hover:text-gray-900 focus:text-gray-900"
                               href="#" role="button" data-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <h6 class="dropdown-header">Businesses</h6>
                                <section class="dropdown-item">
                                    Meghomitra
                                </section>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/settings">Settings</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @auth
        @include('layouts.topnav')
        @if(isset($title))
            <header class="max-w-6xl mx-auto pt-5">
                <h1 class="text-xl font-medium tracking-wider leading-tight px-2 text-gray-700 uppercase">
                    {{$title}}
                </h1>
            </header>
        @endif
    @endauth
    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
@yield('footer-script')
</html>
