{{-- {{dd($user)}} --}}
@extends('layouts.site')
@section('meta')
<title>WYD | {{$user->username}}</title>
<meta name="title" content="{{$user->username}}" />
<meta name="keywords" content="{{$user->thought_of_the_day}}" />
<meta name="description" content="{{$user->bio}}" />
<meta name="robots" content="all" />

<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:image" content="{{asset('storage/users/'.$user->image)}}" />
<meta property="og:image:width" content="180" />
<meta property="og:image:height" content="50" />

<meta property="og:type" content=website />
<meta property="og:title" content="{{$user->username}}" />
<meta property="og:description" content="" />

<meta name="twitter:card" content="{{$user->bio}}" />
<meta name="twitter:site" content="{{ config('app.url') }}" />
<meta name="twitter:title" content="{{$user->username}}" />
<meta name="twitter:description" content="{{$user->bio}}" />
<meta name="twitter:image" content="{{asset('storage/users/'.$user->image)}}" />
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
@endsection
@section('content')    
<div class="followers_container overlay hide">
    <div class="followers_box">
        <div class="head d-flex align-items-center">
            <h4 class="title">Followers</h4>
            <span class="close_followers cancel_btn">X</span>
        </div>
        <ul class="follower_list">
            @foreach ($user->followers as $follwer)                    
                <div id="remove_follower_user_container_{{$follwer->id}}">
                    @php
                        $user_ = $follwer->follow_user;
                    @endphp
                    <li class="follower d-flex align-items-center">
                        <div class="follow-user-img">
                            <img class="w-100" src="{{ isset($user_->image) ? asset('storage/users/'.$user_->image) : asset('assets/images/images.png') }}" alt="profile_img" class="follower_img d-inline-block" />
                        </div>
                        <div class="follower_name">
                            <p class="username">{{$user_->username}}</p>
                            <p>{{$user_->name}}</p>
                        </div>
                        @php
                            $is_following  = Auth::user()->following()->where('following_user_id', $user_->id)->exists();
                        @endphp
                        @if (Auth::user()->id !== $user_->id )   
                            <button onclick="FollowUnFollowRequest({{$user_->id}},$(this));" class="main_btn follow_btn mla">
                                {{$is_following == false ? 'Follow' : 'Following'}}
                            </button>
                        @endif
                    </li>
                    <form action="{{route('follow-unfollow-user')}}" id="follow_unfollow_user_form_{{$user_->id}}" method="POST">
                        @csrf
                        <input type="hidden" name="username" value="{{$user_->username}}">
                    </form>
                    <form action="{{route('remove-follower-user',['id'=>$follwer->id])}}" id="remove_follower_user_form_{{$follwer->id}}" method="POST">
                        @csrf
                    </form>
                </div>
            @endforeach
        </ul>
    </div>
</div>
<div class="following_container hide overlay">
    <div class="following_box">
        <div class="head d-flex align-items-center">
            <h4 class="title">Following</h4>
            <span class="close_following cancel_btn">X</span>
        </div>
        <ul class="following_list">
            @foreach ($user->following as $following_)                    
                @php
                    $user_ = $following_->following_user;
                @endphp
                <a>
                    <li class="follower d-flex align-items-center">
                        <div class="follow-user-img">
                            <img class="w-100" src="{{ isset($user_->image) ? asset('storage/users/'.$user_->image) : asset('assets/images/images.png') }}" alt="profile_img" class="follower_img d-inline-block" />
                        </div>
                        <div class="follower_name">
                            <p class="username">{{$user_->username}}</p>
                            <p>{{$user_->name}}</p>
                        </div>
                            @php
                                // $is_following  = $user_->following()->where('following_user_id', Auth::user()->id)->exists();
                                $is_following  = Auth::user()->following()->where('following_user_id', $user_->id)->exists();
                            @endphp
                            @if (Auth::user()->id != $user_->id )                            
                                <button onclick="FollowUnFollowRequest({{$user_->id}},$(this));"  class="main_btn follow_btn mla">
                                    {{$is_following == false ? 'Follow' : 'Following'}}
                                </button>
                            @endif
                    </li>
                </a>
                <form action="{{route('follow-unfollow-user')}}" id="follow_unfollow_user_form_{{$user_->id}}" method="POST">
                    @csrf
                    <input type="hidden" name="username" value="{{$user_->username}}">
                </form>        
            @endforeach
        </ul>
    </div>
</div>
    <section class="profile-detail-outer position-relative">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- <div class="suspender position-absolute left-0 w-100 bg-white"></div> -->

                    <div
                        class="profile-thought position-relative py-3 rounded-bottom mt-3 mb-2 d-flex flex-sm-row flex-column justify-content-center align-items-center">
                        <div class="profile-detail-img w-auto pb-2">
                            <div class="user-photo" id="user-photo">
                                <img src="{{ isset($user->image) ? asset('storage/users/'.$user->image) : asset('assets/images/images.png') }}" class="photo img-fluid" />
                            </div>
                        </div>
                        <div class="thoughtoday col-sm-7 px-4">
                            <h3 class="mb-3 position-relative text-white">
                                Thought of the Day
                            </h3>
                            <p class="thought text-start text-white">
                                {{$user->thought_of_the_day}}
                            </p>
                        </div>
                        <button onclick="ShowMoreOption();" class="more_option_toggle position-absolute d-flex flex-column">
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                        </button>
                        <div class="overlay_container hide" id="user_profile_more_option">
                            <ul class="more_options">
                                <li class="option" id="block">Block</li>
                                <li class="option report">Report</li>
                                <li class="option" id="cancel">Cancel</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="profile-detail-content">
                        <div class="profile-detail">
                            <div
                                class="d-flex profile-name mb-3 align-items-center justify-content-center flex-wrap flex-sm-nowrap">
                                <h4 class="mb-0 d-flex align-items-center justify-content-center gap-3">
                                    <span> {{$user->name}}
                                        <span class="d-inline-flex align-items-center"><img src="{{asset('assets/img/verified.svg')}}"
                                                alt="verified" width="18" height="18" /></span></span>
                                    <div class="profile-detail-content-btn d-inline-block d-sm-none">
                                        @php
                                            $is_following  = Auth::user()->following()->where('following_user_id', $user->id)->exists();
                                            // $is_following  = App\Models\Followuser::where([['following_user_id','=',$user->id],['follower_user_id','=',Auth::user()->id]]);
                                        @endphp
                                        <button id="" onclick="FollowUnFollowRequest({{$user->id}},$(this));" class="main_btn mb-0">
                                            {{$is_following == false ? 'Follow Back' : 'Following'}}
                                        </button>                                        
                                    </div>
                                </h4>
                                <!-- <a href="" class="setting_icon"><i class="fa fa-cog fa-2x"></i></a> -->
                                <ul class="profile-detail-list col-sm-7 px-4">
                                    <li><span>{{count($user->posts)}}</span> Days</li>
                                    <li class="followers_link"><span>{{$user->followers()->count()}}</span> Followers </li>
                                    <li class="following_link"><span>{{$user->following()->count()}}</span> Following </li>
                                </ul>
                            </div>
                            <div class="d-flex flex-column flex-sm-row align-items-start justify-content-center">
                                <div class="profile-detail-content-btn d-none d-sm-block w-auto mx-auto mx-sm-0 m-0">
                                    <button onclick="FollowUnFollowRequest({{$user->id}},$(this));" class="main_btn" id="follow_friend_btn">
                                        {{$is_following == false ? 'Follow' : 'Following'}}
                                    </button>
                                </div>
                                <div class="col-sm-7 px-4 mb-3 px-sm-4">
                                    <p class="username mb-2">{{$user->username}}</p>
                                    <p class="text-start mb-2">
                                        {{$user->bio}}
                                    </p>
                                    <div class="profile-detail-a mt-0 d-block text-start">
                                        <a href="{{$user->webiste}}">{{$user->webiste}}</a>
                                    </div>

                                    <div class="profile-detail-content-btn d-flex justify-content-startgit">
                                        <a href=""><button class="message_btn">Message</button></a>
                                        <div class="dropdown profile-fillter">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="d-md-block d-none">Filter</span><i
                                                    class="fas fa-sliders-h d-md-none"></i>
                                                <span><img class="d-none d-md-block" width="18" height="18"
                                                        src="{{asset('assets/images/dropdown-next.svg')}}" /></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li>
                                                    <a class="dropdown-item">
                                                        <form action="/action_page.php">
                                                            <!-- <label for="birthday">Birthday:</label> -->
                                                            <input type="date" id="birthday" name="birthday" />
                                                        </form>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"><input type="text"
                                                            placeholder="Location" /></a>
                                                </li>
                                                <li>
                                                    <a href="" class="dropdown-item main_btn">Submit</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-detail-box-content">
                        <ul class="nav nav-pills box_group" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <span class="nav-link active" id="pills-days-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-days" type="button" role="tab" aria-controls="pills-days"
                                    aria-selected="true">Days</span>
                            </li>
                            <li class="nav-item" role="presentation">
                                <span class="nav-link" id="pills-tagged-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-tagged" type="button" role="tab" aria-controls="pills-tagged"
                                    aria-selected="false">Tagged</span>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active box_group" id="pills-days" role="tabpanel"
                                aria-labelledby="pills-days-tab">
                                @foreach ($user->posts as $post)
                                    <div class="box_group" id="main_post_container_{{$post->id}}">
                                        <ul class="msg_box mb-3 mb-sm-5">
                                            <li class="days-ago">
                                                <p>{{ $post->post_number }}<sup>th</sup><br />day</p>
                                            </li>
                                            <li class="row align-items-center">
                                                <div class="col-lg-12">
                                                    <div class="msg_extras_container d-flex">
                                                        <a class="heart">
                                                            <form action="{{route('save-post')}}" method="POST" id="save_post_form_{{$post->id}}">
                                                                @csrf
                                                                <input type="hidden" name="post_id" value="{{$post->id}}">
                                                                <button class="like_button p-0" type="button" onclick="SavePostRequest({{$post->id}});" id="save_post_btn_{{$post->id}}">
                                                                    @if ($post->saves()->where('user_id', Auth::user()->id)->exists())                                                
                                                                        <img class="red-heart d-block" style="margin-bottom: -8px;" src="{{ asset('assets/images/bookmark-blue.png') }}">
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
                                                            {{-- <li class="msg_extra p-1 px-3 pt-2">
                                                                <i class="fa fa-eye-slash side_icon"></i> Hide
                                                            </li> --}}
                                                            <li class="msg_extra p-1 px-3"  onclick="ShowPostReportModal({{$post->id}})">
                                                                <i class="fa fa-user-alt-slash side_icon"></i>
                                                                Report
                                                            </li>
                                                            <li class="msg_extra p-1 px-3 pb-2">
                                                                <i class="fa fa-times-circle side_icon"></i>
                                                                Cancel
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="right_part">
                                                        <ul class="date_time d-flex">
                                                            <li>
                                                                <p>
                                                                    <i class="far fa-clock"></i>{{ date("h:i A - M d, Y", strtotime($post->created_at)) }}
                                                                </p>
                                                            </li>
                                                        </ul>
                                                        <h3>
                                                            <a href="{{route('detail-post-view',['type'=>$post->type,'slug'=>$post->slug_url])}}">{{$post->title}}</a>
                                                        </h3>
                                                        <p>
                                                            {!! Str::limit($post->desc, 200, ' ...') !!}
                                                        </p>
    
                                                        <ul
                                                            class="like_comment d-flex justify-content-between align-items-center">
                                                            <li class="d-flex justify-content-center align-items-center">
                                                                <small><img src="{{ asset('assets/images/eye.png') }}" /><span><span>{{$post->views()->count()}}</span>
                                                                    Views</span></small>    
                                                                <a class="heart like_post_">
                                                                    <form action="{{route('add-remove-like')}}" method="POST" id="like_post_form_{{$post->id}}">
                                                                        @csrf
                                                                        <input type="hidden" name="post_id" value="{{$post->id}}">
                                                                        <input type="hidden" name="post_type" value="{{$post->type}}">
                                                                        <button class="like_button d-flex align-items-end" type="button" onclick="LikePostRequest({{$post->id}},$(this));" id="like_post_btn_{{$post->id}}">
                                                                            @php $liked = $post->likes()->where('user_id', Auth::user()->id)->exists(); @endphp
                                                                                <img class="red-heart {{$liked == true ? 'd-block-c' : 'd-none-c' }}" src="{{ asset('assets/images/red-heart.png') }}">
                                                                                <img class="simple-heart {{$liked == true ? 'd-none-c' : 'd-block-c' }}" src="{{ asset('assets/images/heart.png') }}">
                                                                            <span><span class="post_like_count">{{$post->likes()->count()}}</span> Likes</span>
                                                                        </button>
                                                                    </form>
                                                                </a>
                                                                 <!-- Post Comments -->
                                                                 <a class="d-flex"><img src="{{ asset('assets/images/messsage.png') }}" /><span class="d-flex"><span class="d-block pr-4">{{$post->comments()->count()}}</span>
                                                                        Comments</span>
                                                                </a>
                                                                <form action="{{route('share-post')}}" method="POST"  id="share_post_form_{{$post->id}}">
                                                                    @csrf
                                                                    <input type="hidden" name="post_id" value="{{$post->id}}">
                                                                    <input type="hidden" name="post_type" value="{{$post->type}}">
                                                                    <a class="d-flex" type="button" onclick="sharePostRequest({{$post->id}});" id="share_post_btn_{{$post->id}}">
                                                                        <img src="{{ asset('assets/images/share.png') }}"><span class="d-flex"><span class="share_count d-block pr-4">{{$post->shares()->count()}}</span> Shares</span> 
                                                                    </a>
                                                                </form>
                                                                <!-- Share Post Modal -->
                                                                <div class="overlay hide" id="share_post_container_{{$post->id}}">
                                                                    <div class="ques_box ques_box_1">
                                                                        <p class="ques_txt font-17">Copy Post Link</p>        
                                                                        <div class="share_profile">
                                                                            <p>{{route('detail-post-view',['type'=>$post->type,'slug'=>$post->slug_url])}}</p> 
                                                                        </div>     
                                                                        <div class="d-flex justify-content-center mt-4">           
                                                                            <button type="button" class="ques_btn suggested_btn text-primary" onclick="SharePostModal({{$post->id}});">
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
                                    </div>
                                    <div class="report_msg_container overlay hide" id="report_post_container_{{$post->id}}">
                                        <div class="report_msg_box d-flex flex-column">
                                            <textarea name="report" id="report_msg" cols="30" rows="10" placeholder="What did glad do?"></textarea>
                                            <span class="msg_error"></span>
                                            <div class="report_btns">
                                                <button id="send_report" class="report_msg_btn">
                                                    Send <i class="fa fa-paper-plane"></i>
                                                </button>
                                                <button id="" class="cancel_btn report_msg_btn" onclick="ShowPostReportModal({{$post->id}})">
                                                    Close <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="pills-tagged" role="tabpanel" aria-labelledby="pills-tagged-tab">
                                @for ($i = 0; $i < 10; $i++)
                                    <div class="box_group">
                                        <ul class="msg_box mb-3 mb-sm-5">
                                            <li class="days-ago">
                                                <p>5<sup>th</sup><br />day</p>
                                            </li>
                                            <li class="row align-items-center">
                                                <div class="col-lg-12">
                                                    <div class="msg_extras_container d-flex">
                                                        <a class="heart">
                                                            <img class="simple-heart" src="{{asset('assets/images/bookmark.png')}}" />
                                                            <img class="red-heart" src="{{asset('assets/images/bookmark-blue.png')}}" />
                                                        </a>
                                                        <button class="msg_extras_btn d-flex flex-column">
                                                            <span class="caret"></span>
                                                            <span class="caret"></span>
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="msg_extras_list d-flex flex-column hide">
                                                            <li class="msg_extra p-1 px-3 pt-2">
                                                                <i class="fa fa-eye-slash side_icon"></i> Hide
                                                            </li>
                                                            <li class="msg_extra p-1 px-3 report">
                                                                <i class="fa fa-user-alt-slash side_icon"></i>
                                                                Report
                                                            </li>
                                                            <li class="msg_extra p-1 px-3 pb-2">
                                                                <i class="fa fa-times-circle side_icon"></i>
                                                                Cancel
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="right_part">
                                                        <ul class="date_time d-flex">
                                                            <li>
                                                                <p>
                                                                    <i class="far fa-clock"></i>10:00 AM - 20 feb,
                                                                    2020 - Las Vegas, USA
                                                                </p>
                                                            </li>
                                                        </ul>
                                                        <h3>
                                                            <a href="">Loretm Ipsum is simply dummy text of the
                                                                printing</a>
                                                        </h3>
                                                        <p>
                                                            Lorem Ipsum is simply dummy text of the printing
                                                            and typesetting industry. Lorem Ipsum has been the
                                                            industry's standard dummy text ever since the
                                                            1500s, when an unknown printer took a galley of
                                                            type and scrambled it to make a type specimen
                                                            book. It has survived not centuries,Lorem Ipsum is
                                                            simply dummy Lorem Ipsum is simply dummy text of
                                                            the printing and typesetting industry. Lorem Ipsum
                                                            has been the industry's
                                                        </p>

                                                        <ul
                                                            class="like_comment d-flex justify-content-between align-items-center">
                                                            <li>
                                                                <small><img src=""{{asset('assets/images/eye.png')}}" /><span><span>1000</span>
                                                                        Views</span></small>
                                                                <a class="heart">
                                                                    <img class="simple-heart" src="{{asset('assets/images/heart.png')}}" />
                                                                    <img class="red-heart" src="{{asset('assets/images/red-heart.png')}}" />
                                                                    <span><span>1000</span> Likes</span>
                                                                </a>
                                                                <a href="#"><img
                                                                        src="{{asset('assets/images/messsage.png')}}" /><span><span>1000</span>
                                                                        Comments</span>
                                                                </a>
                                                                <a href="#"><img
                                                                        src="{{asset('assets/images/share.png')}}" /><span><span>1000</span>
                                                                        Shares</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>                                    
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <form action="{{route('follow-unfollow-user')}}" id="follow_unfollow_user_form_{{$user->id}}" method="POST">
        @csrf
        <input type="hidden" name="username" value="{{$user->username}}">
    </form>
@endsection
<div id="like-popup" >
</div>
@section('js')
<script src="{{ asset('app-assets/vendors/js/vendor.bundle.base.js') }}"></script> <!-- endinject -->
<script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/msg_extras.js') }}"></script>
<script src="{{ asset('assets/js/like_share_post.js') }}"></script>
<script>
    function ShowMoreOption() {
        $('#user_profile_more_option').toggleClass('hide');
    }
</script>
@endsection