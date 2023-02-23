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
<!--- Follower List -->
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
                            <button onclick="FollowUnFollowRequest({{$user_->id}},$(this));" class="follow_btn mla">
                                {{$is_following == false ? 'Follow Back' : 'Following'}}
                            </button>
                        @endif
                        <button class="main_btn ml-1" onclick="RemoverFromFollower({{$follwer->id}},$(this))">Remove</button>
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
<!--- Following List -->
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
                <li class="follower d-flex align-items-center">
                    <div class="follow-user-img">
                        <img class="w-100" src="{{ isset($user_->image) ? asset('storage/users/'.$user_->image) : asset('assets/images/images.png') }}" alt="profile_img" class="follower_img d-inline-block" />
                    </div>
                    <div class="follower_name">
                        <p class="username">{{$user_->username}}</p>
                        <p>{{$user_->name}}</p>
                    </div>
                    <button onclick="FollowUnFollowRequest({{$user_->id}},$(this));"  class="main_btn follow_btn">Following</button>
                </li>
                <form action="{{route('follow-unfollow-user')}}" id="follow_unfollow_user_form_{{$user_->id}}" method="POST">
                    @csrf
                    <input type="hidden" name="username" value="{{$user_->username}}">
                </form>        
            @endforeach
        </ul>
    </div>
</div>

<!--- Report Post -->
<div class="report_msg_container overlay hide">
    <div class="report_msg_box d-flex flex-column">
        <textarea name="report" id="report_msg" cols="30" rows="10" placeholder="What did glad do?"></textarea>
        <span class="msg_error"></span>
        <div class="report_btns">
            <button id="send_report" class="report_msg_btn">
                Send <i class="fa fa-paper-plane"></i>
            </button>
            <button id="close_report" class="report_msg_btn cancel_btn">
                Close <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
</div>

<section class="profile-detail-outer position-relative">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- <div class="suspender position-absolute left-0 w-100 bg-white"></div> -->
                <div
                    class="profile-thought position-relative text-white py-3 rounded-bottom mt-3 mb-2 d-flex flex-sm-row flex-column justify-content-center align-items-center">                    
                    <div class="user-photo" id="user-photo">
                        <img src="{{ isset($user->image) ? asset('storage/users/'.$user->image) : asset('assets/images/images.png') }}" class="photo img-fluid" />
                    </div>
                    <div class="thoughtoday col-sm-7 px-4">
                        <h3 class="mb-3 position-relative">Thought Of The Day</h3>
                        <p class="thought text-start">
                            {{$user->thought_of_the_day}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="profile-detail">
                    <div class="profile-detail-content">
                        <div
                            class="d-flex profile-name mb-3 align-items-center justify-content-center flex-wrap flex-sm-nowrap">
                            <h4 class="mb-0">
                                {{$user->name}}
                                <span class="d-inline-flex align-items-center"><img
                                        src="{{ asset('assets/img/verified.svg ') }}"                  alt="verified"
                      width="18"
                      height="18"
                  /></span>
                </h4>
                <ul class="profile-detail-list col-sm-7 px-4">
                  <li><span>{{count($publicposts)}}</span> Days</li>
                  <li class="followers_link"><span>{{$user->followers()->count()}}</span> Followers</li>
                  <li class="following_link"><span>{{$user->following()->count()}}</span> Following</li>
                </ul>
              </div>
              <div
                class="d-flex flex-column flex-sm-row align-items-start justify-content-center"
              >
                <div
                  class="profile-detail-content-btn w-auto mx-auto mx-sm-0 m-0 order-1 order-sm-0"
                >
                  <a href="{{route('user-profile')}}"
                    ><button class="message_btn">Edit Profile</button></a
                  >
                </div>
                <div class="col-sm-7 px-4 mb-3 px-sm-2">
                  <p class="username"><b>{{$user->username}}</b></p>
                  {{-- <p>CEO - of ABC Company</p> --}}
                  <p class="text-start">
                    {{$user->bio}}
                  </p>
                  <div class="profile-detail-a mt-0 d-block text-start">
                    <a href="{{$user->webiste}}">{{$user->website}}</a>
                  </div>
                  <div class="dropdown profile-fillter">
                    <button
                      class="btn btn-secondary w-auto mx-auto mx-sm-0 dropdown-toggle"
                      type="button"
                      id="dropdownMenuButton1"
                      data-bs-toggle="dropdown"
                      aria-expanded="false"
                    >
                      <span class="d-md-block d-none">Filter</span
                      ><i class="fas fa-sliders-h d-md-none"></i>
                      <span
                        ><img
                          class="d-none d-md-block"
                          width="18"
                          he18
                          src="{{ asset('assets/images/dropdown-next.svg') }}" /></span>
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
                                        <a class="dropdown-item"><input type="text" placeholder="Location" /></a>
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
        <div class="profile-detail-box-content">
            <ul class="nav nav-pills box_group" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <span class="nav-link active" id="pills-days-tab" data-bs-toggle="pill" data-bs-target="#pills-days"
                        type="button" role="tab" aria-controls="pills-days" aria-selected="true">Days</span>
                </li>
                <li class="nav-item" role="presentation">
                    <span class="nav-link" id="pills-privte-tab" data-bs-toggle="pill" data-bs-target="#pills-privte"
                        type="button" role="tab" aria-controls="pills-privte" aria-selected="false">Private</span>
                </li>
                <li class="nav-item" role="presentation">
                    <span class="nav-link" id="pills-draft-tab" data-bs-toggle="pill" data-bs-target="#pills-draft"
                        type="button" role="tab" aria-controls="pills-draft" aria-selected="false">Draft</span>
                </li>
                <li class="nav-item" role="presentation">
                    <span class="nav-link" id="pills-saved-tab" data-bs-toggle="pill" data-bs-target="#pills-saved"
                        type="button" role="tab" aria-controls="pills-saved" aria-selected="false">Saved</span>
                </li>
                <li class="nav-item" role="presentation">
                    <span class="nav-link" id="pills-tagged-tab" data-bs-toggle="pill" data-bs-target="#pills-tagged"
                        type="button" role="tab" aria-controls="pills-tagged" aria-selected="false">Tagged</span>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">

                <!--- Public Days List -->
                <div class="tab-pane fade show active box_group" id="pills-days" role="tabpanel"
                    aria-labelledby="pills-days-tab">
                    @foreach ($publicposts as $post)                        
                        <div class="box_group" id="main_post_container_{{$post->id}}">
                            <ul class="msg_box mb-3 mb-sm-5">
                                <li class="days-ago">
                                    @if ($post->post_number==1)                                                    
                                        <p>{{ $post->post_number }}<sup>st</sup><br />day</p>
                                    @elseif($post->post_number==2)
                                        <p>{{ $post->post_number }}<sup>nd</sup><br />day</p>
                                    @elseif($post->post_number==3)
                                        <p>{{ $post->post_number }}<sup>rd</sup><br />day</p>
                                    @else
                                        <p>{{ $post->post_number }}<sup>th</sup><br />day</p>
                                    @endif   
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
                                                <li class="msg_extra p-1 px-3 editButtonInner">
                                                    <a class="editButton" href="{{route('edit-post-view',['type'=>$post->type,'slug'=>$post->slug_url])}}">
                                                        <i class="fa fa-edit side_icon"></i>
                                                        Edit
                                                    </a>
                                                </li>                                                
                                                <li class="msg_extra p-1 px-3" onclick="ShowDeleteModal({{$post->id}})" id="delete_post_btn_{{$post->id}}">
                                                    <i class="fa fa-trash-alt side_icon"></i>
                                                    Delete
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
                                                <a href="{{route('detail-post-view',['username'=>$post->user->username,'post_number' => $post->post_number,'slug'=>$post->slug_url])}}">{{isset($post->seo_title) ? $post->seo_title : $post->title}}</a>
                                            </h3>
                                            <p>
                                                {!! Str::limit(isset($post->meta_desc) ? $post->meta_desc : $post->desc, 300, ' ...') !!}
                                            </p>

                                            <ul class="like_comment d-flex justify-content-between align-items-center">
                                                <li class="d-flex align-items-center">
                                                    <!-- Post Views -->
                                                    <small><img src="{{ asset('assets/images/eye.png') }}" /><span><span>{{$post->views_count}}</span>
                                                            Views</span></small>                                                    
                                                    <!-- Post Likes -->
                                                    <a class="heart like_post_">
                                                        <form action="{{route('add-remove-like')}}" class="like_form" method="POST" id="like_post_form_{{$post->id}}">
                                                            @csrf
                                                            <input type="hidden" name="post_id" value="{{$post->id}}">
                                                            <input type="hidden" name="post_type" value="{{$post->type}}">
                                                            <button class="like_button d-flex justify-content-center align-items-center" type="button" onclick="LikePostRequest({{$post->id}},$(this));" id="like_post_btn_{{$post->id}}">
                                                                @php $liked = $post->likes()->where('user_id', Auth::user()->id)->exists(); @endphp
                                                                    <img class="red-heart {{$liked == true ? 'd-block-c' : 'd-none-c' }}" src="{{ asset('assets/images/red-heart.png') }}">
                                                                    <img class="simple-heart {{$liked == true ? 'd-none-c' : 'd-block-c' }}" src="{{ asset('assets/images/heart.png') }}">
                                                                <span><span class="post_like_count">{{$post->likes()->count()}}</span> Likes</span>
                                                            </button>
                                                        </form>
                                                    </a>
                                                    <!-- Post Comments -->
                                                    <a><img src="{{ asset('assets/images/messsage.png') }}" /><span><span>{{$post->comments_count}}</span>
                                                            Comments</span>
                                                    </a>
                                                    <!-- Post Shares -->
                                                    <form action="{{route('share-post')}}" method="POST"  id="share_post_form_{{$post->id}}">
                                                        @csrf
                                                        <input type="hidden" name="post_id" value="{{$post->id}}">
                                                        <input type="hidden" name="post_type" value="{{$post->type}}">
                                                        <a type="button" onclick="sharePostRequest({{$post->id}});" id="share_post_btn_{{$post->id}}">
                                                            <img src="{{ asset('assets/images/share.png') }}"><span><span class="share_count">{{$post->shares_count}}</span> Shares</span> 
                                                        </a>
                                                    </form>
                                                    <!-- Share Post Modal -->
                                                    <div class="overlay hide" id="share_post_container_{{$post->id}}">
                                                        <div class="ques_box ques_box_1">
                                                            <div class="d-flex justify-content-between align-items-baseline">
                                                                <div>
                                                                    <p class="ques_txt font-17">Copy Post Link</p>       
                                                                </div>
                                                                <span onclick="CopyPostUrl($(this),'{{route('detail-post-view',['username'=>$post->user->username,'post_number' => $post->post_number,'slug'=>$post->slug_url])}}',{{$post->id}});" class="copybutton"><i class="far fa-clipboard-list"></i></span>
                                                            </div>
                                                            <div class="share_profile">
                                                                <p>{{$post->slug_url}}</p> 
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
                        <form action="{{route('delete-public-post')}}" method="POST" id="delete_post_form_{{$post->id}}">
                            @csrf
                            <input type="hidden" name="post_type" value="{{$post->type}}">
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <!-- Share Post Modal -->
                            <div class="overlay hide" id="delete_post_container_{{$post->id}}">
                                <div class="ques_box ques_box_1">
                                    <p class="ques_txt font-17">Are You Sure You Want To Delete This Post</p>        
                                    <div class="d-flex justify-content-center mt-4">           
                                        <button type="button" class="btn btn-danger" id="delete_post_btn_{{$post->id}}" onclick="DeletePostRequest({{$post->id}})">
                                            Delete
                                        </button>
                                    </div>    
                                    <div class="d-flex justify-content-center mt-4">           
                                        <button type="button" class="ques_btn suggested_btn text-primary" onclick="ShowDeleteModal({{$post->id}});">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>                            
                    @endforeach
                </div>

                <!--- Private Days List -->
                <div class="tab-pane fade" id="pills-privte" role="tabpanel" aria-labelledby="pills-privte-tab">
                    @foreach ($privateposts as $post)                        
                    <div class="box_group" id="main_post_container_{{$post->id}}">
                        <ul class="msg_box mb-3 mb-sm-5">
                            <li class="row align-items-center">
                                <div class="col-lg-12">
                                    <div class="msg_extras_container d-flex">   
                                        <button class="msg_extras_btn d-flex flex-column">
                                            <span class="caret"></span>
                                            <span class="caret"></span>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="msg_extras_list d-flex flex-column hide">                                                
                                            <li class="msg_extra p-1 px-3 editButtonInner">
                                                <a class="editButton" href="{{route('edit-post-view',['type'=>$post->type,'slug'=>$post->slug_url])}}">
                                                    <i class="fa fa-edit side_icon"></i>
                                                    Edit
                                                </a>
                                            </li>                                               
                                            <li class="msg_extra p-1 px-3" onclick="ShowDeleteModal({{$post->id}})" id="delete_post_btn_{{$post->id}}">
                                                <i class="fa fa-trash-alt side_icon"></i>
                                                Delete
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
                                            <a href="{{route('detail-post-view-private',['type'=>$post->type,'slug'=>$post->slug_url])}}">{{$post->title}}</a>
                                        </h3>
                                        <p>
                                            {!! Str::limit($post->desc, 200, ' ...') !!}
                                        </p>

                                        <ul class="like_comment d-flex justify-content-between align-items-center">
                                            <li class="d-flex align-items-center">
                                                <!-- Post Views -->
                                                <small><img src="{{ asset('assets/images/eye.png') }}" /><span><span>{{$post->countViews()}}</span>
                                                        Views</span></small>                                                    
                                                <!-- Post Likes -->
                                                <a class="heart like_post_">
                                                    <form  class="like_form" action="{{route('add-remove-like-private')}}" method="POST" id="like_post_form_{{$post->id}}">
                                                        @csrf
                                                        <input type="hidden" name="post_id" value="{{$post->id}}">
                                                        <input type="hidden" name="post_type" value="{{$post->type}}">
                                                        <button class="like_button d-flex justify-content-center align-items-center" type="button" onclick="LikePostRequest({{$post->id}},$(this));" id="like_post_btn_{{$post->id}}">
                                                            @php $liked = $post->checkUserLike(Auth::user()->id); @endphp
                                                                    <img class="red-heart {{$liked == true ? 'd-block-c' : 'd-none-c' }}" src="{{ asset('assets/images/red-heart.png') }}">
                                                                    <img class="simple-heart {{$liked == true ? 'd-none-c' : 'd-block-c' }}" src="{{ asset('assets/images/heart.png') }}">
                                                                <span><span class="post_like_count">{{$post->countLikes()}}</span> Likes</span>
                                                        </button>
                                                    </form>
                                                </a>
                                                <!-- Post Comments -->
                                                <a><img src="{{ asset('assets/images/messsage.png') }}" /><span><span>{{$post->countComments()}}</span>
                                                        Comments</span>
                                                </a>
                                                <!-- Post Shares -->
                                                <a>
                                                    <img src="{{ asset('assets/images/share.png') }}"><span><span class="share_count">{{$post->countShares()}}</span> Shares</span> 
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <form action="{{route('delete-private-post')}}" method="POST" id="delete_post_form_{{$post->id}}">
                        @csrf
                        <input type="hidden" name="post_type" value="{{$post->type}}">
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <!-- Share Post Modal -->
                        <div class="overlay hide" id="delete_post_container_{{$post->id}}">
                            <div class="ques_box ques_box_1">
                                <p class="ques_txt font-17">Are You Sure You Want To Delete This Post</p>        
                                <div class="d-flex justify-content-center mt-4">           
                                    <button type="button" class="btn btn-danger" id="delete_post_btn_{{$post->id}}" onclick="DeletePostRequest({{$post->id}})">
                                        Delete
                                    </button>
                                </div>    
                                <div class="d-flex justify-content-center mt-4">           
                                    <button type="button" class="ques_btn suggested_btn text-primary" onclick="ShowDeleteModal({{$post->id}});">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endforeach
                </div>

                <!--- Draft Days List -->
                <div class="tab-pane fade" id="pills-draft" role="tabpanel" aria-labelledby="pills-draft-tab">
                    @foreach ($draftposts as $post)                        
                        <div class="box_group" id="main_post_container_{{$post->id}}">
                            <ul class="msg_box mb-3 mb-sm-5">                                
                                <li class="row align-items-center">
                                    <div class="col-lg-12">
                                        <div class="msg_extras_container d-flex">   
                                            <button class="msg_extras_btn d-flex flex-column">
                                                <span class="caret"></span>
                                                <span class="caret"></span>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="msg_extras_list d-flex flex-column hide">                                                
                                                <li class="msg_extra p-1 px-3 editButtonInner">
                                                    <a class="editButton" href="{{route('edit-post-view',['type'=>$post->type,'slug'=>$post->slug_url])}}">
                                                        <i class="fa fa-edit side_icon"></i>
                                                        Edit
                                                    </a>
                                                </li> 
                                                <li class="msg_extra p-1 px-3" onclick="ShowDeleteModal({{$post->id}})" id="delete_post_btn_{{$post->id}}">
                                                    <i class="fa fa-trash-alt side_icon"></i>
                                                    Delete
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
                                                <a href="{{route('detail-post-view-draft',['type'=>$post->type,'slug'=>$post->slug_url])}}">{{$post->title}}</a>
                                            </h3>
                                            <p>
                                                {!! Str::limit($post->desc, 200, ' ...') !!}
                                            </p>

                                            <ul class="like_comment d-flex justify-content-between align-items-center">
                                                <li class="d-flex align-items-center">
                                                    <!-- Post Views -->
                                                    <small><img src="{{ asset('assets/images/eye.png') }}" /><span><span>{{$post->countViews()}}</span>
                                                            Views</span></small>                                                    
                                                    <!-- Post Likes -->
                                                    <a class="heart like_post_">
                                                        <form  class="like_form" action="{{route('add-remove-like-draft')}}" method="POST" id="like_post_form_{{$post->id}}">
                                                            @csrf
                                                            <input type="hidden" name="post_id" value="{{$post->id}}">
                                                            <input type="hidden" name="post_type" value="{{$post->type}}">
                                                            <button class="like_button d-flex justify-content-center align-items-center" type="button" onclick="LikePostRequest({{$post->id}},$(this));" id="like_post_btn_{{$post->id}}">
                                                                @php $liked = $post->checkUserLike(Auth::user()->id); @endphp
                                                                    <img class="red-heart {{$liked == true ? 'd-block-c' : 'd-none-c' }}" src="{{ asset('assets/images/red-heart.png') }}">
                                                                    <img class="simple-heart {{$liked == true ? 'd-none-c' : 'd-block-c' }}" src="{{ asset('assets/images/heart.png') }}">
                                                                <span><span class="post_like_count">{{$post->countLikes()}}</span> Likes</span>
                                                            </button>
                                                        </form>
                                                    </a>
                                                    <!-- Post Comments -->
                                                    <a><img src="{{ asset('assets/images/messsage.png') }}" /><span><span>{{$post->countComments()}}</span>
                                                            Comments</span>
                                                    </a>
                                                    <!-- Post Shares -->
                                                    <a>
                                                        <img src="{{ asset('assets/images/share.png') }}"><span><span class="share_count">{{$post->countShares()}}</span> Shares</span> 
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <form action="{{route('delete-draft-post')}}" method="POST" id="delete_post_form_{{$post->id}}">
                            @csrf
                            <input type="hidden" name="post_type" value="{{$post->type}}">
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <!-- Share Post Modal -->
                            <div class="overlay hide" id="delete_post_container_{{$post->id}}">
                                <div class="ques_box ques_box_1">
                                    <p class="ques_txt font-17">Are You Sure You Want To Delete This Post</p>        
                                    <div class="d-flex justify-content-center mt-4">           
                                        <button type="button" class="btn btn-danger" id="delete_post_btn_{{$post->id}}" onclick="DeletePostRequest({{$post->id}})">
                                            Delete
                                        </button>
                                    </div>    
                                    <div class="d-flex justify-content-center mt-4">           
                                        <button type="button" class="ques_btn suggested_btn text-primary" onclick="ShowDeleteModal({{$post->id}});">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>

                <!--- Save Days List -->
                <div class="tab-pane fade" id="pills-saved" role="tabpanel" aria-labelledby="pills-saved-tab">
                    @foreach ($saveposts as $save)                        
                        <div class="box_group" id="main_post_container_save_{{$save->id}}">
                            @php
                                $post = $save->post;
                            @endphp
                            <ul class="msg_box mb-3 mb-sm-5">
                                <li class="days-ago">
                                    <p>{{ $post->post_number }}<sup>th</sup><br />day</p>
                                </li>
                                <li class="row align-items-center">
                                    <div class="col-lg-12">
                                        <div class="msg_extras_container d-flex">                                            
                                            <a class="heart" style="width: 17px;">
                                                <form action="{{route('save-post')}}" method="POST" id="save_post_form_{{$save->id}}">
                                                    @csrf
                                                    <input type="hidden" name="post_id" value="{{$post->id}}">
                                                    <button class="like_button p-0" type="button" onclick="SavePostRequest({{$save->id}},1);" id="save_post_btn_{{$save->id}}">
                                                        @if ($post->saves()->where('user_id', Auth::user()->id)->exists())                                                
                                                            <img class="red-heart d-block" style="margin-bottom: -8px;" src="{{ asset('assets/images/bookmark-blue.png') }}">
                                                        @else
                                                            <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                                                        @endif
                                                    </button>
                                                </form>
                                            </a>
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
                                                <a href="{{route('detail-post-view',['username'=>$post->user->username,'post_number' => $post->post_number,'slug'=>$post->slug_url])}}">{{$post->title}}</a>
                                            </h3>
                                            <p>
                                                {!! Str::limit($post->desc, 200, ' ...') !!}
                                            </p>

                                            <ul class="like_comment d-flex justify-content-between align-items-center">
                                                <li class="d-flex align-items-center">
                                                    <!-- Post Views -->
                                                    <small><img src="{{ asset('assets/images/eye.png') }}" /><span><span>{{$post->views()->count()}}</span>
                                                            Views</span></small>                                                    
                                                    <!-- Post Likes -->
                                                    <a class="heart like_post_">
                                                        <form action="{{route('add-remove-like')}}"  class="like_form" method="POST" id="like_post_form_{{$post->id}}">
                                                            @csrf
                                                            <input type="hidden" name="post_id" value="{{$post->id}}">
                                                            <input type="hidden" name="post_type" value="{{$post->type}}">
                                                            <button class="like_button d-flex justify-content-center align-items-center" type="button" onclick="LikePostRequest({{$post->id}},$(this));" id="like_post_btn_{{$post->id}}">
                                                                @php $liked = $post->likes()->where('user_id', Auth::user()->id)->exists(); @endphp
                                                                    <img class="red-heart {{$liked == true ? 'd-block-c' : 'd-none-c' }}" src="{{ asset('assets/images/red-heart.png') }}">
                                                                    <img class="simple-heart {{$liked == true ? 'd-none-c' : 'd-block-c' }}" src="{{ asset('assets/images/heart.png') }}">
                                                                <span><span class="post_like_count">{{$post->likes()->count()}}</span> Likes</span>
                                                            </button>
                                                        </form>
                                                    </a>
                                                    <!-- Post Comments -->
                                                    <a><img src="{{ asset('assets/images/messsage.png') }}" /><span><span>{{$post->comments()->count()}}</span>
                                                            Comments</span>
                                                    </a>
                                                    <!-- Post Shares -->
                                                    <form action="{{route('share-post')}}" method="POST"  id="share_post_form_{{$post->id}}">
                                                        @csrf
                                                        <input type="hidden" name="post_id" value="{{$post->id}}">
                                                        <input type="hidden" name="post_type" value="{{$post->type}}">
                                                        <a type="button" onclick="sharePostRequest({{$post->id}});" id="share_post_btn_{{$post->id}}">
                                                            <img src="{{ asset('assets/images/share.png') }}"><span><span class="share_count">{{$post->shares()->count()}}</span> Shares</span> 
                                                        </a>
                                                    </form>

                                                    <!-- Share Post Modal -->
                                                    <div class="overlay hide" id="share_post_container_{{$post->id}}">
                                                        <div class="ques_box ques_box_1">
                                                            <div class="d-flex justify-content-between align-items-baseline">
                                                                <div>
                                                                    <p class="ques_txt font-17">Copy Post Link</p>       
                                                                </div>
                                                                <span onclick="CopyPostUrl($(this),'{{route('detail-post-view',['username'=>$post->user->username,'post_number' => $post->post_number,'slug'=>$post->slug_url])}}',{{$post->id}});" class="copybutton"><i class="far fa-clipboard-list"></i></span>
                                                            </div>
                                                            <div class="share_profile">
                                                                <p>{{$post->slug_url}}</p> 
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
                    @endforeach
                </div>

                <!--- Tagged Days List -->
                <div class="tab-pane fade" id="pills-tagged" role="tabpanel" aria-labelledby="pills-tagged-tab">
                    @for ($i=0;$i<10;$i++)                        
                        <div class="box_group">
                            <ul class="msg_box mb-3 mb-sm-5">
                                <li class="days-ago">
                                    <p>5<sup>th</sup><br />day</p>
                                </li>
                                <li class="row align-items-center">
                                    <div class="col-lg-12">
                                        <div class="msg_extras_container d-flex">
                                            <a class="heart">
                                                <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}" />
                                                <img class="red-heart"
                                                    src="{{ asset('assets/images/bookmark-blue.png') }}" />
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

                                            <ul class="like_comment d-flex justify-content-between align-items-center">
                                                <li>
                                                    <small><img
                                                            src="{{ asset('assets/images/eye.png') }}" /><span><span>1000</span>
                                                            Views</span></small>
                                                    <a class="heart">
                                                        <img class="simple-heart"
                                                            src="{{ asset('assets/images/heart.png') }}" />
                                                        <img class="red-heart"
                                                            src="{{ asset('assets/images/red-heart.png') }}" />
                                                        <span><span>1000</span> Likes</span>
                                                    </a>
                                                    <a href="#"><img
                                                            src="{{ asset('assets/images/messsage.png') }}" /><span><span>1000</span>
                                                            Comments</span>
                                                    </a>
                                                    <a href="#"><img
                                                            src="{{ asset('assets/images/share.png') }}" /><span><span>1000</span>
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
<div id="like-popup" >
</div>
@endsection
@section('js')
<script src="{{ asset('app-assets/vendors/js/vendor.bundle.base.js') }}"></script> <!-- endinject -->
<script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/msg_extras.js') }}"></script>
<script src="{{ asset('assets/js/like_share_post.js') }}"></script>
<script src="{{ asset('assets/js/delete_post.js') }}"></script>
@endsection