@extends('layouts.app')

@section('content')
    <div class="container mt-10">
        <div class="flex-row justify-content-center max-w-xl m-auto">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @else
                <div class="h-12 my-1">&nbsp;</div>
            @endif
        </div>
        <div class="row justify-content-center max-w-2xl m-auto">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <div class="flex flex-row justify-content-between">
                        <section>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ __('Account Verification') }}
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                                {{ __('Verify Your Email Address') }}
                            </p>
                        </section>
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                    class="text-white bg-gray-800 tracking-wider uppercase text-sm px-4 py-2 rounded-md">
                                {{ __('resend') }}
                            </button>
                        </form>
                    </div>
                </div>
                <div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 ">
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ __('Before proceeding, please check your email for a verification link.') }}
                                {{ __('If you did not receive the email') }},
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

        </div>
    </div>
@endsection
