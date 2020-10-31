@extends('layouts.app')

@section('content')
    <section id="app">
        <app :tenant="{{$tenant}}"/>
    </section>
@endsection

@section('footer-script')
    <script src="{{ mix('js/index.js') }}"></script>
@endsection
