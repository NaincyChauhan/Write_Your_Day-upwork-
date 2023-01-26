@extends('layouts.site')
@section('content')
    <div class="site-breadcrumb" style="background: url({{asset('assets/img/bg/breadcrumb.jpg') }})">
        <div class="container">
            <h2 class="breadcrumb-title">500 Error</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{route('home')}}">Home</a></li>
                <li class="active">500 Error</li>
            </ul>
        </div>
    </div>


    <div class="error-area py-120">
        <div class="container">
            <div class="col-md-6 mx-auto">
                <div class="error-wrapper">
                    <img src="{{ asset('assets/img/error/500.png') }}" alt="">
                    <h2>Opos... Internal Server Error!</h2>
                    <p>Something went wrong please reload the page or try again after sometime.</p>
                    <a href="{{ route('home') }}" class="theme-btn"><i class="far fa-home"></i> Go Back Home</a>
                </div>
            </div>
        </div>
    </div>
@endsection