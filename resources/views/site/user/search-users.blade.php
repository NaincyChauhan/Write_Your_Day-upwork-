@extends('layouts.site')
@section('meta')
<title>WYD | Users</title>

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
<section class="serch-profile-box-outer main-margin">
    <div class="container">
        @include('partial.search_users', ['users' => $users])
        <div id="main-post-container" data-page="2">

        </div>
    </div>
</section>
<div id="like-popup" >
</div>
@endsection

@section('js')
    <script src="{{ asset('app-assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/msg_extras.js') }}"></script>
    <script src="{{ asset('assets/js/like_share_post.js') }}"></script>
    <script src="{{ asset('assets/js/search_post.js') }}"></script>
    <script>
        $('#search_query').val("{{$search_query}}");
    </script>
@endsection