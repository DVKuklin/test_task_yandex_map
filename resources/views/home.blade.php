@extends('templates.main_template')

@section('title')Яндекс карты@endsection

@section('content')
    @auth
        @include('pages.app')

    @endauth

    @guest
        @include('pages.app_description')

    @endguest


@endsection