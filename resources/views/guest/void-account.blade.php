@extends('layouts.app')

@section('content')
    <div class="container mt-10">
        <div class="row justify-content-center max-w-2xl m-auto">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <div class="flex flex-row justify-content-between">
                        <section>
                            <h3 class="text-xl leading-6 font-medium text-gray-900">
                                Oh noo!
                            </h3>
                            <p class="mt-1 max-w-2xl text-base leading-5 text-gray-500">
                                -_-
                            </p>
                        </section>
                    </div>
                </div>
                <div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 ">
                            <dd class="mt-1 text-base leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                <p class="mb-2">
                                    Looks like you are not part of any Business/Tenancy.
                                </p>
                                <p class="leading-6">
                                    Unfortunately, we do not support user history access at this stage.
                                    Please check back later or reach our team if it's really urgent.
                                </p>
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
