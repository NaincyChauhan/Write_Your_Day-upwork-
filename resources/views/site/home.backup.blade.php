@extends('layouts.site')
@section('meta')
@endsection
@section('js')
<script src="{{ asset('app-assets/vendors/js/vendor.bundle.base.js') }}"></script> <!-- endinject -->
<script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/msg_extras.js') }}"></script>
<script src="{{ asset('assets/js/like_share_post.js') }}"></script>
@endsection
@section('content')
<!-- Box Group -->
<section class="box_group main-margin">
    <!-- <------- main Li --------->
    <div class="report_msg_container overlay hide" id="report_msg_container">
        <form action="{{route('report-post')}}" method="POST" id="post-report-form">
            @csrf
            <input type="hidden" name="post_id" id="report_post_id">
            <div class="report_msg_box d-flex flex-column">
                <div class="main-form-class">
                    <textarea class="w-100" name="report" id="report_msg" cols="30" rows="10" maxlength="600"
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
    <div class="container">

        <!--  User Followers Post --------->
        @foreach ($followers_posts as $post)
            <ul class="msg_box mb-3 mb-sm-5" id="post_container_{{$post->id}}">
                <li class="msg_extras_container d-flex align-items-center">
                    <a class="heart">
                        <form action="{{route('save-post')}}" method="POST" id="save_post_form_{{$post->id}}">
                            @csrf
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <button class="like_button p-0" type="button" onclick="SavePostRequest({{$post->id}});"
                                id="save_post_btn_{{$post->id}}">
                                @if ($post->saves()->where('user_id', Auth::user()->id)->exists())
                                <img class="red-heart d-block" style="margin-bottom: -8px;"
                                    src="{{ asset('assets/images/bookmark-blue.png') }}">
                                @else
                                <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                                @endif
                            </button>
                        </form>
                    </a>
                    <button class="msg_extras_btn d-flex flex-column">
                        <span class="caret"></span>
                        <span class="caret"></span>
                        <span class="caret"></span>
                    </button>
                    <ul class="msg_extras_list d-flex flex-column hide">
                        <li class="msg_extra p-1 px-3 pt-2" onclick="HidePostRequest({{$post->id}},$(this))"><i
                                class="fa fa-eye-slash side_icon"></i> Hide</li>
                        <li class="msg_extra p-1 px-3" onclick="ShowReportModal({{$post->id}});"><i
                                class="fa fa-user-alt-slash side_icon"></i> Report</li>
                        <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                    </ul>
                </li>
                <li class="days-ago">
                    <p>{{ $post->post_number }}<sup>th</sup><br>day</p>
                </li>
                <li class="row align-items-center">
                    <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                        <div class="left_part">
                            <div class="radious_img">
                                <img src="{{ asset('assets/images/images.png') }}">
                                <h4 class="post_owner"><a href="./friendprofile.html">{{$post->user->name}}</a></h4>
                                <p>Followers:{{$post->user->followers()->count()}}</p>
                            </div>
                            @if (Auth::user()->id !== $post->user->id)
                            <div class="content_part">
                                <button class="main_btn follow_btn"
                                    onclick="FollowUnFollowRequest({{$post->user->id}},$(this));">
                                    {{Auth::user()->following()->where('following_user_id', $post->user->id)->exists() ?
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
                            <h3><a
                                    href="{{route('detail-post-view',['type'=>$post->type,'slug'=>$post->slug_url])}}">{{$post->title}}</a>
                            </h3>
                            <p>
                                {!! $post->desc !!}
                            </p>

                            <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                                <li class="d-flex justify-content-center align-items-center">
                                    <small><img
                                            src="{{ asset('assets/images/eye.png') }}" /><span><span>{{$post->views()->count()}}</span>
                                            Views</span></small>
                                    <a class="heart like_post_">
                                        <form action="{{route('add-remove-like')}}" method="POST"
                                            id="like_post_form_{{$post->id}}">
                                            @csrf
                                            <input type="hidden" name="post_id" value="{{$post->id}}">
                                            <input type="hidden" name="post_type" value="{{$post->type}}">
                                            <button class="like_button d-flex align-items-end" type="button"
                                                onclick="LikePostRequest({{$post->id}});" id="like_post_btn_{{$post->id}}">
                                                @php $liked = $post->likes()->where('user_id', Auth::user()->id)->exists();
                                                @endphp
                                                <img class="red-heart {{$liked == true ? 'd-block-c' : 'd-none-c' }}"
                                                    src="{{ asset('assets/images/red-heart.png') }}">
                                                <img class="simple-heart {{$liked == true ? 'd-none-c' : 'd-block-c' }}"
                                                    src="{{ asset('assets/images/heart.png') }}">
                                                <span><span class="post_like_count">{{$post->likes()->count()}}</span>
                                                    Likes</span>
                                            </button>
                                        </form>
                                    </a>
                                    <!-- Post Comments -->
                                    <a class="d-flex custom-column-margin-1"><img
                                            src="{{ asset('assets/images/messsage.png') }}" /><span class="d-flex"><span
                                                class="d-block pr-4">{{$post->comments()->count()}}</span>
                                            Comments</span>
                                    </a>
                                    <form class="custom-column-margin-1" action="{{route('share-post')}}" method="POST"
                                        id="share_post_form_{{$post->id}}">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{$post->id}}">
                                        <input type="hidden" name="post_type" value="{{$post->type}}">
                                        <a class="d-flex" type="button" onclick="sharePostRequest({{$post->id}});"
                                            id="share_post_btn_{{$post->id}}">
                                            <img src="{{ asset('assets/images/share.png') }}"><span class="d-flex"><span
                                                    class="share_count d-block pr-4">{{$post->shares()->count()}}</span>
                                                Shares</span>
                                        </a>
                                    </form>
                                    <!-- Share Post Modal -->
                                    <div class="overlay hide" id="share_post_container_{{$post->id}}">
                                        <div class="ques_box ques_box_1">
                                            <p class="ques_txt font-17">Copy Post Link</p>
                                            <div class="share_profile">
                                                <p>{{route('detail-post-view',['type'=>$post->type,'slug'=>$post->slug_url])}}
                                                </p>
                                            </div>
                                            <div class="d-flex justify-content-center mt-4">
                                                <button type="button" class="ques_btn suggested_btn text-primary"
                                                    onclick="SharePostModal({{$post->id}});">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
            <form action="{{route('follow-unfollow-user')}}" id="follow_unfollow_user_form_{{$post->user->id}}"
                method="POST">
                @csrf
                <input type="hidden" name="username" value="{{$post->user->username}}">
            </form>
            <form action="{{route('hide-post')}}" id="hide_post_form_{{$post->id}}" method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{$post->id}}">
            </form>
        @endforeach

        <!-- <------- main Li --------->
        @foreach ($follow_user_post as $follow)
        @foreach ($follow->following_user->posts as $post)
        <ul class="msg_box mb-3 mb-sm-5" id="post_container_{{$post->id}}">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <form action="{{route('save-post')}}" method="POST" id="save_post_form_{{$post->id}}">
                        @csrf
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <button class="like_button p-0" type="button" onclick="SavePostRequest({{$post->id}});"
                            id="save_post_btn_{{$post->id}}">
                            @if ($post->saves()->where('user_id', Auth::user()->id)->exists())
                            <img class="red-heart d-block" style="margin-bottom: -8px;"
                                src="{{ asset('assets/images/bookmark-blue.png') }}">
                            @else
                            <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                            @endif
                        </button>
                    </form>
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2" onclick="HidePostRequest({{$post->id}},$(this))"><i
                            class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3" onclick="ShowReportModal({{$post->id}});"><i
                            class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>{{ $post->post_number }}<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/images.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">{{$post->user->name}}</a></h4>
                            <p>Followers:{{$post->user->followers()->count()}}</p>
                        </div>
                        @if (Auth::user()->id !== $post->user->id)
                        <div class="content_part">
                            <button class="main_btn follow_btn"
                                onclick="FollowUnFollowRequest({{$post->user->id}},$(this));">
                                {{Auth::user()->following()->where('following_user_id', $post->user->id)->exists() ?
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
                        <h3><a
                                href="{{route('detail-post-view',['type'=>$post->type,'slug'=>$post->slug_url])}}">{{$post->title}}</a>
                        </h3>
                        <p>
                            {!! $post->desc !!}
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li class="d-flex justify-content-center align-items-center">
                                <small><img
                                        src="{{ asset('assets/images/eye.png') }}" /><span><span>{{$post->views()->count()}}</span>
                                        Views</span></small>
                                <a class="heart like_post_">
                                    <form action="{{route('add-remove-like')}}" method="POST"
                                        id="like_post_form_{{$post->id}}">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{$post->id}}">
                                        <input type="hidden" name="post_type" value="{{$post->type}}">
                                        <button class="like_button d-flex align-items-end" type="button"
                                            onclick="LikePostRequest({{$post->id}});" id="like_post_btn_{{$post->id}}">
                                            @php $liked = $post->likes()->where('user_id', Auth::user()->id)->exists();
                                            @endphp
                                            <img class="red-heart {{$liked == true ? 'd-block-c' : 'd-none-c' }}"
                                                src="{{ asset('assets/images/red-heart.png') }}">
                                            <img class="simple-heart {{$liked == true ? 'd-none-c' : 'd-block-c' }}"
                                                src="{{ asset('assets/images/heart.png') }}">
                                            <span><span class="post_like_count">{{$post->likes()->count()}}</span>
                                                Likes</span>
                                        </button>
                                    </form>
                                </a>
                                <!-- Post Comments -->
                                <a class="d-flex custom-column-margin-1"><img
                                        src="{{ asset('assets/images/messsage.png') }}" /><span class="d-flex"><span
                                            class="d-block pr-4">{{$post->comments()->count()}}</span>
                                        Comments</span>
                                </a>
                                <form class="custom-column-margin-1" action="{{route('share-post')}}" method="POST"
                                    id="share_post_form_{{$post->id}}">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{$post->id}}">
                                    <input type="hidden" name="post_type" value="{{$post->type}}">
                                    <a class="d-flex" type="button" onclick="sharePostRequest({{$post->id}});"
                                        id="share_post_btn_{{$post->id}}">
                                        <img src="{{ asset('assets/images/share.png') }}"><span class="d-flex"><span
                                                class="share_count d-block pr-4">{{$post->shares()->count()}}</span>
                                            Shares</span>
                                    </a>
                                </form>
                                <!-- Share Post Modal -->
                                <div class="overlay hide" id="share_post_container_{{$post->id}}">
                                    <div class="ques_box ques_box_1">
                                        <p class="ques_txt font-17">Copy Post Link</p>
                                        <div class="share_profile">
                                            <p>{{route('detail-post-view',['type'=>$post->type,'slug'=>$post->slug_url])}}
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-center mt-4">
                                            <button type="button" class="ques_btn suggested_btn text-primary"
                                                onclick="SharePostModal({{$post->id}});">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
        <form action="{{route('follow-unfollow-user')}}" id="follow_unfollow_user_form_{{$post->user->id}}"
            method="POST">
            @csrf
            <input type="hidden" name="username" value="{{$post->user->username}}">
        </form>
        <form action="{{route('hide-post')}}" id="hide_post_form_{{$post->id}}" method="POST">
            @csrf
            <input type="hidden" name="post_id" value="{{$post->id}}">
        </form>
        @endforeach
        @endforeach

        {{-- All Latest Posts --}}
        @foreach ($posts as $post)
        <ul class="msg_box mb-3 mb-sm-5" id="post_container_{{$post->id}}">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <form action="{{route('save-post')}}" method="POST" id="save_post_form_{{$post->id}}">
                        @csrf
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <button class="like_button p-0" type="button" onclick="SavePostRequest({{$post->id}});"
                            id="save_post_btn_{{$post->id}}">
                            @if ($post->saves()->where('user_id', Auth::user()->id)->exists())
                            <img class="red-heart d-block" style="margin-bottom: -8px;"
                                src="{{ asset('assets/images/bookmark-blue.png') }}">
                            @else
                            <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                            @endif
                        </button>
                    </form>
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2" onclick="HidePostRequest({{$post->id}},$(this))"><i
                            class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3" onclick="ShowReportModal({{$post->id}});"><i
                            class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>{{ $post->post_number }}<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/images.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">{{$post->user->name}}</a></h4>
                            <p>Followers:{{$post->user->followers()->count()}}</p>
                        </div>
                        @if (Auth::user()->id !== $post->user->id)
                        <div class="content_part">
                            <button class="main_btn follow_btn"
                                onclick="FollowUnFollowRequest({{$post->user->id}},$(this));">
                                {{Auth::user()->following()->where('following_user_id', $post->user->id)->exists() ?
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
                        <h3><a
                                href="{{route('detail-post-view',['type'=>$post->type,'slug'=>$post->slug_url])}}">{{$post->title}}</a>
                        </h3>
                        <p>
                            {!! $post->desc !!}
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li class="d-flex justify-content-center align-items-center">
                                <small><img
                                        src="{{ asset('assets/images/eye.png') }}" /><span><span>{{$post->views()->count()}}</span>
                                        Views</span></small>
                                <a class="heart like_post_">
                                    <form action="{{route('add-remove-like')}}" method="POST"
                                        id="like_post_form_{{$post->id}}">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{$post->id}}">
                                        <input type="hidden" name="post_type" value="{{$post->type}}">
                                        <button class="like_button d-flex align-items-end" type="button"
                                            onclick="LikePostRequest({{$post->id}});" id="like_post_btn_{{$post->id}}">
                                            @php $liked = $post->likes()->where('user_id', Auth::user()->id)->exists();
                                            @endphp
                                            <img class="red-heart {{$liked == true ? 'd-block-c' : 'd-none-c' }}"
                                                src="{{ asset('assets/images/red-heart.png') }}">
                                            <img class="simple-heart {{$liked == true ? 'd-none-c' : 'd-block-c' }}"
                                                src="{{ asset('assets/images/heart.png') }}">
                                            <span><span class="post_like_count">{{$post->likes()->count()}}</span>
                                                Likes</span>
                                        </button>
                                    </form>
                                </a>
                                <!-- Post Comments -->
                                <a class="d-flex custom-column-margin-1"><img
                                        src="{{ asset('assets/images/messsage.png') }}" /><span class="d-flex"><span
                                            class="d-block pr-4">{{$post->comments()->count()}}</span>
                                        Comments</span>
                                </a>
                                <form class="custom-column-margin-1" action="{{route('share-post')}}" method="POST"
                                    id="share_post_form_{{$post->id}}">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{$post->id}}">
                                    <input type="hidden" name="post_type" value="{{$post->type}}">
                                    <a class="d-flex" type="button" onclick="sharePostRequest({{$post->id}});"
                                        id="share_post_btn_{{$post->id}}">
                                        <img src="{{ asset('assets/images/share.png') }}"><span class="d-flex"><span
                                                class="share_count d-block pr-4">{{$post->shares()->count()}}</span>
                                            Shares</span>
                                    </a>
                                </form>
                                <!-- Share Post Modal -->
                                <div class="overlay hide" id="share_post_container_{{$post->id}}">
                                    <div class="ques_box ques_box_1">
                                        <p class="ques_txt font-17">Copy Post Link</p>
                                        <div class="share_profile">
                                            <p>{{route('detail-post-view',['type'=>$post->type,'slug'=>$post->slug_url])}}
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-center mt-4">
                                            <button type="button" class="ques_btn suggested_btn text-primary"
                                                onclick="SharePostModal({{$post->id}});">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
        <form action="{{route('follow-unfollow-user')}}" id="follow_unfollow_user_form_{{$post->user->id}}"
            method="POST">
            @csrf
            <input type="hidden" name="username" value="{{$post->user->username}}">
        </form>
        <form action="{{route('hide-post')}}" id="hide_post_form_{{$post->id}}" method="POST">
            @csrf
            <input type="hidden" name="post_id" value="{{$post->id}}">
        </form>
        @endforeach
        {{-- <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span>
                                        Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span>
                                        Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span>
                                        Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>

        </ul> --}}
    </div>

    <div>
        <a class="load-more" id="load-more-post" data-offset="10" data-limit="10">Load More</a>
    </div>
</section>
<div id="like-popup">
</div>
@endsection