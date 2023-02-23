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
        @foreach ($users as $user)
        <div class="serch-profile-box">
                    <a href="{{route('search-user-profile',['username'=>$user->username])}}">
                    <div class="serch-profile-box-img">
                        <div class="search-user-image">
                            <img class="w-100 h-auto  rounded-0" src="{{ isset($user->image) ? asset('storage/users/'.$user->image) : asset('assets/images/images.png') }}">
                        </div>
                    </div>
                </a>
                    <div class="serch-profile-box-content">
                        <a href="{{route('search-user-profile',['username'=>$user->username])}}">
                            <h4>{{$user->name}}</h4>
                            <h6 class="text-secondary mt-1">{{$user->username}}</h6>
                        </a>
                        @php
                            $is_following  = Auth::user()->following()->where('following_user_id', $user->id)->exists();
                        @endphp
                        <p class="followers">Followers : <span>{{$user->followers()->count()}}</span></p>
                        <p>{{$user->bio}}</p>
                    </div>
                    <div class="serch-profile-box-button mla">
                        <button onclick="FollowUnFollowRequest({{$user->id}},$(this));" class="main_btn">
                            {{$is_following == false ? 'Follow' : 'Following'}}
                        </button>
                    </div>
                </div>            
            <form action="{{route('follow-unfollow-user')}}" id="follow_unfollow_user_form_{{$user->id}}" method="POST">
                @csrf
                <input type="hidden" name="username" value="{{$user->username}}">
            </form>
        @endforeach
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
    <script>
        $('#search_query').val("{{$search_query}}");
    </script>
@endsection