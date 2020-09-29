@extends('layouts.app')

@section('content')
    <div class="container mt-10">
        <div class="row justify-content-center max-w-2xl m-auto">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <div class="flex flex-row justify-content-between">
                        <section>
                            <h3 class="text-xl leading-6 font-medium text-gray-900">
                                You are almost there...
                            </h3>
                            <p class="mt-1 max-w-2xl text-base leading-5 text-gray-500">
                                Check your email account
                            </p>
                        </section>
                    </div>
                </div>
                <div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 ">
                            <dd class="mt-1 text-base leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                <p class="mb-2">Thanks for Signing up!</p>
                                <p class="mb-4">
                                    We have sent you an <strong>email</strong> to <strong>verify</strong> your account.Please check you email account.
                                </p>
                                <p>Let's grow your business together <span class="text-xl">🚀</span></p>
                                <br>
                                <p class="mb-1">Yours in Business,</p>
                                <p>HishabGuru</p>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

        </div>
    </div>
@endsection
