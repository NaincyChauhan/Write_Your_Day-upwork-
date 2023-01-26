@extends('layouts.site')
@section('content')
    <div class="site-breadcrumb" style="background: url({{asset('assets/img/bg/breadcrumb.jpg') }})">
        <div class="container">
            <h2 class="breadcrumb-title">401 Error</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{route('home')}}">Home</a></li>
                <li class="active">401 Error</li>
            </ul>
        </div>
    </div>


    <div class="error-area py-120">
        <div class="container">
            <div class="col-md-6 mx-auto">
                <div class="error-wrapper">
                    <img src="{{ asset('assets/img/error/500.png') }}" alt="">
                    <h2>Opos... Access Denied!</h2>
                    <p>You don't have permission to access this page.</p>
                    <a href="{{ route('home') }}" class="theme-btn"><i class="far fa-home"></i> Go Back Home</a>
                </div>
            </div>
        </div>
    </div>
@endsection