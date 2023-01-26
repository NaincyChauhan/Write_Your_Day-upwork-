@extends('layouts.site')
@section('meta')

@endsection
@section('js') 
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.all.min.js"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('app-assets/masterX/js/captcha.js') }}"></script>
    <script src="{{ asset('app-assets/masterX/js/custom.js') }}"></script>
    <script src="{{ asset('app-assets/masterX/js/send-message.js') }}"></script>
    <script>createCaptcha();</script>

@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('app-assets/masterX/css/captcha.css') }}">
@endsection
@section('content')
	
@endsection