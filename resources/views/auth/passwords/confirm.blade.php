<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>HishabGuru</title>
    <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400&display=swap" rel="stylesheet">
</head>
<body class="antialiased">
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
    @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block" style="font-family: 'Raleway', sans-serif">
            <a href="{{ url('/') }}" class="text-sm text-gray-700">Home</a>
        </div>
    @endif

    <div class="max-w-md w-full mx-auto sm:px-4 lg:px-6">
        <div class="flex justify-center pt-8  sm:pt-0 m-auto ww-full">
            <a href="{{ url('/') }}">
                <img src="{{asset('/images/logo.png')}}" alt="logo" class="d-inline" style="width: 120px">
            </a>
        </div>

        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <form class="w-full" method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                        <div class="flex flex-row justify-center w-full">
                            <h3 class="text-xl ">{{ __('Confirm Password') }}</h3>
                        </div>
                        <p class="text-sm text-gray-700 py-2">{{ __('Please confirm your password before continuing.') }}</p>
                        <div class="mt-1 mb-3 relative rounded-md">
                            <input
                                class="block w-full px-2 focus:outline-none focus:ring focus:border-blue-300 text-sm shadow-sm py-2 border border-gray-300 @error('password') border-red-600 @enderror rounded-sm"
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Password"
                                required
                            >
                            @error('password')
                            <small class="text-red-700">
                                <strong>{{ $message }}</strong>
                            </small>
                            @enderror
                        </div>

                        <div class="mt-2 relative flex flex-row items-center">
                            <button type="submit"
                                    class="border border-blue-400 py-2 text-white bg-blue-400 hover:bg-blue-500 hover:border-blue-500 focus:bg-blue-500 focus:border-blue-500  uppercase tracking-wide font-medium w-full text-sm shadow-sm rounded">
                                {{ __('Confirm Password') }}
                            </button>
                        </div>
                        <div class="py-2 flex flex-row-reverse">
                            @if (Route::has('password.request'))
                                <a class="text-sm text-teal-500" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
