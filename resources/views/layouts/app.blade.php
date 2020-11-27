<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HishabGuru') }} - Inventory & Account Manager for SME Bangladesh</title>
    <meta name="description"
          content="HishabGuru helps online businesses to manage their inventory and accounts. We support your e-commerce business, so that you can focus on your business">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
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
                <ul class="navbar-nav ml-auto">
                    @guest
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a href="/login">
                                    <button
                                        class="px-3 py-2 text-blue-500 tracking-wider rounded font-semibold mx-1  hover:bg-blue-500 focus:outline-none hover:text-white text-xs"
                                    >
                                        Sign in
                                    </button>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="/register">
                                <button
                                    class="px-3 py-2 border-blue-300 text-blue-500 tracking-wider rounded font-semibold mx-1 border hover:bg-blue-500 focus:outline-none hover:text-white text-xs"
                                >
                                    Sign up
                                </button>
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
@yield('footer-script')
</html>
