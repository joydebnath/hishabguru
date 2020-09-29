@extends('layouts.app')

@section('content')
    <div class="container mt-10">
        <div class="row justify-content-center max-w-2xl m-auto">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <div class="flex flex-row justify-content-between">
                        <section>
                            <h3 class="text-xl leading-6 font-medium text-gray-900">
                                Final step...
                            </h3>
                            <p class="mt-1 max-w-2xl text-base leading-5 text-gray-500">
                                Set <span class="text-gray-600">{{$tenant->name}}'s</span> Inventory Location
                            </p>
                        </section>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-5 ">
                    <form class="d-block mb-3" method="POST" action="/init" id="form">
                        @csrf
                        <input hidden name="address_type" type="text" value="headquarter">
                        <input hidden name="tenant_id" type="number" value="{{$tenant->id}}">
                        <div class="field">
                            <label class="label">Site</label>
                            <div class="control">
                                <input class="input" name="name" type="text" value="{{ old('name') }}" placeholder="Enter location name">
                            </div>
                        </div>
                        <p class="font-semibold mt-4 my-3 ">
                        <span class="mr-2">
                            Address
                            <span class="tag">
                                Headquarter
                            </span>
                        </span>
                        </p>
                        <div class="field">
                            <div class="control mb-3">
                                <input class="input mb-3" type="text" name="address_line_1"
                                       placeholder="Address line 1" value="{{ old('address_line_1') }}">
                                <input class="input" type="text" name="address_line_2" placeholder="Address line 2" value="{{ old('address_line_2') }}">
                            </div>
                            <div class="field-body mb-3">
                                <div class="field is-grouped">
                                    <div class="control is-clearfix">
                                        <input type="text" placeholder="City/Town" name="city" class="input" value="{{ old('city') }}">
                                    </div>
                                    <div class="control is-clearfix">
                                        <input type="text" placeholder="Postal/Zip Code" name="postcode" class="input" value="{{ old('postcode') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="field-body ">
                                <div class="field is-grouped">
                                    <div class="control is-clearfix">
                                        <input type="text" placeholder="Division" name="state" class="input" value="{{ old('state') }}">
                                    </div>
                                    <div class="control is-clearfix">
                                        <input type="text" name="country" value="Bangladesh" placeholder="Country"
                                               class="input" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Description</label>
                            <div class="control">
                                <textarea class="textarea" name="description"
                                          placeholder="Write something..." value="{{ old('description') }}"></textarea>
                            </div>
                        </div>
                    </form>
                    <div class="flex flex-row-reverse">
                        <button
                            type="submit"
                            id="submit"
                            onClick="(function stop() {
                                    var btn = document.getElementById('submit');
                                    btn.disabled = true;
                                    btn.innerText = 'loading...'
                                    var form = document.getElementById('form');
                                    form.submit()
                                })()"
                            class="text-white bg-gray-800 tracking-wider uppercase text-sm px-4 py-2 rounded-md">
                            Start
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
