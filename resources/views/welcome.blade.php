<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'HishabGuru') }} - Inventory & Account Manager for SME Bangladesh</title>
        <meta name="description" content="HishabGuru helps online businesses to manage their inventory and accounts. We support your e-commerce business, so that you can focus on your business">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <link rel="preload" href="{{asset('/images/logo.png')}}" as="image" media="(min-width: 100px)">
        <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">

    </head>
<body>
<div id="app">
    <app
        logo="{{asset('/images/logo.png')}}"
        welcome_banner="{{asset('/images/welcome.png')}}"
        svg_1="{{asset('/svg/1.svg')}}"
        svg_2="{{asset('/svg/2.svg')}}"
        svg_3="{{asset('/svg/3.svg')}}"
        svg_4="{{asset('/svg/4.svg')}}"
        svg_5="{{asset('/svg/5.svg')}}"
        svg_6="{{asset('/svg/6.svg')}}"
        svg_7="{{asset('/svg/7.svg')}}"
    />
</div>
@auth
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endauth
</body>
<script src="{{ mix('js/welcome.js') }}"></script>
</html>
