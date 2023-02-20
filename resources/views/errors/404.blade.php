@extends('layouts.site')
@section('meta')
<title>404 page</title>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/404.css') }}">
@endsection
@section('content')
<section class="container d-flex notfound-container">
    <div class="left-side">
        <img src="{{ asset('assets/images/404.png') }}" alt="404 image"/>
    </div>
    <div class="right-side">
        <h2 class="title">Ooops!!!</h2>
        <p class="description">It seems there was a break in transmission due to either the replacement or deleting of the page you're looking for.</p>
        <p class="description">Try checking out our <a href=".{{route('home')}}">homepage</a> for more features</p>
    </div>
</section>
@endsection