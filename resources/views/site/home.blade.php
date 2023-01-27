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
@section('content')
<section class="search_box">
    <div class="container">
        <form class="search_bar huge">
            <div class="search_dropdown">
                <span><img src="{{ asset('assets/images/dropdown-next.svg') }}"></span>
                <ul style="z-index: 2;">
                    <li class="selected"><i class="fa fa-user-friends side_icon"></i> Friend</li>
                    <li><i class="fa fa-sticky-note side_icon"></i> Post</li>
                </ul>
            </div>
            <input type="text" placeholder="Search for anything" />
            <button type="submit" value="Search">Search</button>
        </form>
    </div>
</section>
<div class="report_msg_container overlay hide">
    <div class="report_msg_box d-flex flex-column">
        <textarea name="report" id="report_msg" cols="30" rows="10" placeholder="What did glad do?"></textarea>
        <span class="msg_error"></span>
        <div class="report_btns">
            <button id="send_report" class="report_msg_btn">Send <i class="fa fa-paper-plane"></i></button>
            <button id="close_report" class="report_msg_btn cancel_btn">Close <i class="fa fa-times"></i></button>
        </div>
    </div>
</div>
@endsection