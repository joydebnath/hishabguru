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
                    <form class="w-full" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="flex flex-row justify-center w-full">
                            <h3 class="text-xl ">Sign up</h3>
                        </div>
                        <label for="business_name"
                               class="block text-sm font-medium text-gray-700 tracking-wide">{{ __('Business Name') }}</label>
                        <div class="mt-1 mb-3 relative rounded-md ">
                            <input
                                class="block w-full px-2 focus:outline-none focus:ring focus:border-blue-300 text-sm shadow-sm py-2 border border-gray-300 @error('email') border-red-600 @enderror rounded-sm"
                                type="text"
                                id="business_name"
                                name="business_name"
                                placeholder="Enter Name"
                                value="{{ old('business_name') }}"
                                required
                                autofocus
                            >
                            @error('business_name')
                            <small class="text-red-700">
                                <strong>{{ $message }}</strong>
                            </small>
                            @enderror
                        </div>
                        <label for="name"
                               class="block text-sm font-medium text-gray-700 tracking-wide">{{ __('User Full Name') }}</label>
                        <div class="mt-1 mb-3 relative rounded-md ">
                            <input
                                class="block w-full px-2 focus:outline-none focus:ring focus:border-blue-300 text-sm shadow-sm py-2 border border-gray-300 @error('email') border-red-600 @enderror rounded-sm"
                                type="text"
                                id="name"
                                name="name"
                                placeholder="Enter Full Name"
                                value="{{ old('name') }}"
                                required
                            >
                            @error('name')
                            <small class="text-red-700">
                                <strong>{{ $message }}</strong>
                            </small>
                            @enderror
                        </div>
                        <label for="email" class="block text-sm font-medium text-gray-700 tracking-wide">Email</label>
                        <div class="mt-1 mb-3 relative rounded-md ">
                            <input
                                class="block w-full px-2 focus:outline-none focus:ring focus:border-blue-300 text-sm shadow-sm py-2 border border-gray-300 @error('email') border-red-600 @enderror rounded-sm"
                                type="email"
                                id="email"
                                name="email"
                                placeholder="Enter email address"
                                value="{{ old('email') }}"
                            >
                            @error('email')
                            <small class="text-red-700">
                                <strong>{{ $message }}</strong>
                            </small>
                            @enderror
                        </div>
                        <label for="password"
                               class="block text-sm font-medium text-gray-700 tracking-wide">{{ __('Password') }}</label>
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
                        <label for="confirm_password"
                               class="block text-sm font-medium text-gray-700 tracking-wide">{{ __('Confirm Password') }}</label>
                        <div class="mt-1 mb-4 relative rounded-md">
                            <input
                                class="block w-full px-2 focus:outline-none focus:ring focus:border-blue-300 text-sm shadow-sm py-2 border border-gray-300 @error('password') border-red-600 @enderror rounded-sm"
                                type="password"
                                id="confirm_password"
                                name="password_confirmation"
                                placeholder="Re-enter same Password"
                                required
                            >
                            @error('password')
                            <small class="text-red-700">
                                <strong>{{ $message }}</strong>
                            </small>
                            @enderror
                        </div>
                        @if(config('hishabguru.signup_require_promo_code'))
                            <label for="confirm_password"
                                   class="block text-sm font-medium text-gray-700 tracking-wide">{{ __('Promo Code') }}</label>
                            <div class="mt-1 mb-4 relative rounded-md">
                                <input
                                    class="block w-full px-2 focus:outline-none focus:ring focus:border-blue-300 text-sm shadow-sm py-2 border border-gray-300 @error('password') border-red-600 @enderror rounded-sm"
                                    type="text"
                                    id="promo"
                                    name="promo_code"
                                    placeholder="Promo Code"
                                >
                                @error('promo_code')
                                <small class="text-red-700">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                        @endif
                        <div class="mt-2 relative flex flex-row items-center">
                            <button type="submit"
                                    class="border border-blue-400 py-2 text-white bg-blue-400 hover:bg-blue-500 hover:border-blue-500 focus:bg-blue-500 focus:border-blue-500  uppercase tracking-wide font-medium w-full text-sm shadow-sm rounded">
                                {{ __('Register') }}
                            </button>
                        </div>
                        <div class="mt-4 pt-3 border-t relative flex flex-row items-center">
                            <label class="text-sm pl-1 text-gray-700 ">
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-teal-500 pl-1 font-medium">Sign in</a>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
