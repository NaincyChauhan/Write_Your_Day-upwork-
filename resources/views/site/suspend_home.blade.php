@extends('layouts.site_2')
@section('meta')
@endsection
@section('js')
<script src="{{ asset('app-assets/vendors/js/vendor.bundle.base.js') }}"></script> <!-- endinject -->
<script src="{{ asset('assets/js/msg_extras.js') }}"></script>
<script src="{{ asset('assets/js/load-posts.js') }}"></script>
<script>
        $(document).ready(function () {
        LoadMorePost();
    });

    function LoadMorePost() {
        var load_more_btn = $('#load-more-post');
        var offset = load_more_btn.data('offset');
        var limit = load_more_btn.data('limit');
        if (offset < 100) {        
            // send an AJAX request to retrieve the comments and replies
            $.ajax({
                url: `${window.location.origin}/load/posts/2`,
                type: 'GET',
                data: {
                    offset: offset,
                    limit: limit
                },
                success: function (data) {
                        load_more_btn.data('offset', offset + limit);
                        $('#main-post-container').append(data);

                        if ($('#load-post-length').data('limit') < limit) {
                            // console.log("data is very very low");
                        }else{
                            LoadMorePost();
                        }
                }, error: function (error) {
                    // console.log("this is error is here",error);
                }
            });
        }
    }
</script>
@endsection
@section('content')
<!-- Box Group -->
@php
    $logged_user = Auth::user();
@endphp
<div class="container">
    <div id="session_message_box_area">
        <div class="pt-2 pb-0" id="session_message_area">
            <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <span id="danger-message">Your account has been suspended and restricted from performing any actions. <a style="text-decoration: revert;" href="{{route('account-help')}}"> Click here to support.</a></span>
            </div>
        </div>
    </div>
</div>

<section class="box_group" style="margin-top: 32px;">
    <div class="container">
        <!--  User Followers Post --------->
        @foreach ($posts as $post_)
        @php
            $post= $post_->post;
        @endphp
            <ul class="msg_box mb-3 mb-sm-5" id="post_container_{{$post->id}}">
                <li class="msg_extras_container d-flex align-items-center">
                    <a class="heart">
                        @if ($post->saves()->where('user_id', $logged_user->id)->exists())
                        <img class="red-heart d-block" style="margin-bottom: -8px;"
                            src="{{ asset('assets/images/bookmark-blue.png') }}">
                        @else
                            <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                        @endif
                    </a>
                    <button disabled class="msg_extras_btn d-flex flex-column">
                        <span class="caret"></span>
                        <span class="caret"></span>
                        <span class="caret"></span>
                    </button>                    
                </li>
                <li class="days-ago">
                    <p>{{ $post->post_number }}<sup>th</sup><br>day</p>
                </li>
                <li class="row align-items-center">
                    <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                        <div class="left_part">
                            <div class="radious_img">
                                <div class="w-100 d-flex justify-content-center">
                                    <div class="post-user-image">
                                        <img class="w-100 h-auto rounded-0" src="{{ isset($post->user->image) ? asset('storage/users/'.$post->user->image) : asset('assets/images/images.png') }}">
                                    </div>
                                </div>
                                <h4 class="post_owner"><a>{{$post->user->name}}</a></h4>
                                <p>Followers:{{$post->user->followers()->count()}}</p>
                            </div>
                            @if ($logged_user->id !== $post->user->id)
                            <div class="content_part">
                                <button class="main_btn follow_btn">
                                    {{$logged_user->following()->where('following_user_id', $post->user->id)->exists() ?
                                    'Following' : "Follow"}}
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-9 ">
                        <div class="right_part">
                            <ul class="date_time d-flex ">
                                <li>
                                    <p><i class="far fa-clock"></i>{{ date("h:i A - M d, Y", strtotime($post->created_at))
                                        }}</p>
                                </li>
                            </ul>
                            <h3><a>{{isset($post->seo_title) ? $post->seo_title : $post->title}}</a>
                            </h3>
                            <p>
                                {!! Str::limit(isset($post->meta_desc) ? $post->meta_desc : $post->desc, 200, ' ...') !!}
                            </p>

                            <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                                <li class="d-flex justify-content-center align-items-center">
                                    <small><img
                                            src="{{ asset('assets/images/eye.png') }}" /><span><span>{{$post->views()->count()}}</span>
                                            Views</span></small>
                                    <a class="heart like_post_ mt-1 d-flex">
                                        @php $liked = $post->likes()->where('user_id', $logged_user->id)->exists();
                                        @endphp
                                        <img class="red-heart {{$liked == true ? 'd-block-c' : 'd-none-c' }}"
                                                    src="{{ asset('assets/images/red-heart.png') }}">
                                                <img class="simple-heart {{$liked == true ? 'd-none-c' : 'd-block-c' }}"
                                                    src="{{ asset('assets/images/heart.png') }}">
                                                <span style="color: #626262"><span class="post_like_count" >{{$post->likes()->count()}}</span>
                                                    Likes</span>
                                    </a>
                                    <!-- Post Comments -->
                                    <a class="d-flex custom-column-margin-1"><img
                                            src="{{ asset('assets/images/messsage.png') }}" /><span class="d-flex"><span
                                                class="d-block pr-4">{{$post->comments()->count()}}</span>
                                            Comments</span>
                                    </a>
                                    <a class="d-flex" type="button">
                                        <img src="{{ asset('assets/images/share.png') }}"><span class="d-flex"><span
                                                class="share_count d-block pr-4">{{$post->shares()->count()}}</span>
                                            Shares</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        @endforeach
        <!--  User Followers Post --------->
        @foreach ($followers_posts as $post)
            <ul class="msg_box mb-3 mb-sm-5" id="post_container_{{$post->id}}">
                <li class="msg_extras_container d-flex align-items-center">
                    <a class="heart">
                        @if ($post->saves()->where('user_id', $logged_user->id)->exists())
                        <img class="red-heart d-block" style="margin-bottom: -8px;"
                            src="{{ asset('assets/images/bookmark-blue.png') }}">
                        @else
                            <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                        @endif
                    </a>
                    <button disabled class="msg_extras_btn d-flex flex-column">
                        <span class="caret"></span>
                        <span class="caret"></span>
                        <span class="caret"></span>
                    </button>                    
                </li>
                <li class="days-ago">
                    <p>{{ $post->post_number }}<sup>th</sup><br>day</p>
                </li>
                <li class="row align-items-center">
                    <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                        <div class="left_part">
                            <div class="radious_img">
                                <div class="w-100 d-flex justify-content-center">
                                    <div class="post-user-image">
                                        <img class="w-100 h-auto rounded-0" src="{{ isset($post->user->image) ? asset('storage/users/'.$post->user->image) : asset('assets/images/images.png') }}">
                                    </div>
                                </div>
                                <h4 class="post_owner"><a>{{$post->user->name}}</a></h4>
                                <p>Followers:{{$post->user->followers()->count()}}</p>
                            </div>
                            @if ($logged_user->id !== $post->user->id)
                            <div class="content_part">
                                <button class="main_btn follow_btn">
                                    {{$logged_user->following()->where('following_user_id', $post->user->id)->exists() ?
                                    'Following' : "Follow"}}
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-9 ">
                        <div class="right_part">
                            <ul class="date_time d-flex ">
                                <li>
                                    <p><i class="far fa-clock"></i>{{ date("h:i A - M d, Y", strtotime($post->created_at))
                                        }}</p>
                                </li>
                            </ul>
                            <h3><a>{{isset($post->seo_title) ? $post->seo_title : $post->title}}</a>
                            </h3>
                            <p>
                                {!! Str::limit(isset($post->meta_desc) ? $post->meta_desc : $post->desc, 200, ' ...') !!}
                            </p>

                            <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                                <li class="d-flex justify-content-center align-items-center">
                                    <small><img
                                            src="{{ asset('assets/images/eye.png') }}" /><span><span>{{$post->views()->count()}}</span>
                                            Views</span></small>
                                            @php $liked = $post->likes()->where('user_id', $logged_user->id)->exists();
                                            @endphp
                                    <a class="heart like_post_ mt-1">
                                        <img class="red-heart {{$liked == true ? 'd-block-c' : 'd-none-c' }}"
                                                    src="{{ asset('assets/images/red-heart.png') }}">
                                                <img class="simple-heart {{$liked == true ? 'd-none-c' : 'd-block-c' }}"
                                                    src="{{ asset('assets/images/heart.png') }}">
                                                   
                                                <span style="color: #626262"><span class="post_like_count" >{{$post->likes()->count()}}</span>
                                                    Likes</span>
                                    </a>
                                    <!-- Post Comments -->
                                    <a class="d-flex custom-column-margin-1"><img
                                            src="{{ asset('assets/images/messsage.png') }}" /><span class="d-flex"><span
                                                class="d-block pr-4">{{$post->comments()->count()}}</span>
                                            Comments</span>
                                    </a>
                                    <a class="d-flex" type="button">
                                        <img src="{{ asset('assets/images/share.png') }}"><span class="d-flex"><span
                                                class="share_count d-block pr-4">{{$post->shares()->count()}}</span>
                                            Shares</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        @endforeach
        <div id="main-post-container">
        </div>

        {{-- All Latest Posts --}}
        {{-- @foreach ($posts as $post)
        @endforeach --}}
    </div>

    <div>
        <a class="load-more d-none" id="load-more-post" onclick="LoadMorePost();" data-offset="0" data-limit="10">Load More</a>
        <a class="d-none" id="load-post-length" data-limit=""></a>
    </div>
</section>
<div id="like-popup">
</div>
@endsection