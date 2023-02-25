{{-- {{dd($user)}} --}}
@extends('layouts.site')
@section('meta')
<title>WYD | Days</title>

<meta name="title" content="{{ config('app.name') }}" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="robots" content="all" />

<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:image" content="{{ asset('storage/products/writeyourday.jpeg') }}" />
<meta property="og:image:width" content="180" />
<meta property="og:image:height" content="50" />

<meta property="og:type" content=website />
<meta property="og:title" content="{{ config('app.name') }}" />
<meta property="og:description" content="" />

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="idigitalgroups.com" />
<meta name="twitter:title" content="{{ config('app.name') }}" />
<meta name="twitter:description" content="" />
<meta name="twitter:image" content="{{ asset('storage/products/writeyourday.jpeg') }}" />
@endsection
@section('css')
@endsection
@section('content')    
<section class="box_group main-margin">
    <div class="container">
        <!-- <------- main Li --------->      
        <div class="report_msg_container overlay hide" id="report_msg_container">
            <form action="{{route('report-post')}}" method="POST" id="post-report-form">
                @csrf
                <input type="hidden" name="post_id" id="report_post_id">
                <div class="report_msg_box d-flex flex-column">
                    <div class="main-form-class">
                        <textarea class="w-100" name="report" id="report_msg" cols="30" rows="10"
                        maxlength="600"
                        placeholder="What did glad do?"></textarea>
                        <span class="report_msg_error"></span>
                    </div>
                    <div class="report_btns">
                        <button type="submit" id="send_report" class="report_msg_btn">
                        Send <i class="fa fa-paper-plane"></i>
                        </button>
                        <button type="button" id="close_report" class="report_msg_btn cancel_btn">
                        Close <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @include('partial.search_posts', ['posts' => $posts])
        <div id="main-post-container" data-page="2">

        </div>
    </div>
</section>
<div id="like-popup" >
</div>
@endsection
@section('js')
<script src="{{ asset('app-assets/vendors/js/vendor.bundle.base.js') }}"></script> <!-- endinject -->
<script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/msg_extras.js') }}"></script>
<script src="{{ asset('assets/js/like_share_post.js') }}"></script>
<script src="{{ asset('assets/js/search_post.js') }}"></script>
<script>
    $('#search_query').val("{{$search_query}}");
</script>
@endsection