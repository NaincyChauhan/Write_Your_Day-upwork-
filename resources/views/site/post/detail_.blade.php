@extends('layouts.site')
@section('meta')
<title>Day | WYD</title>

<meta name="title" content="{{ config('app.name') }}" />
<meta name="keywords" content="{{$post->seo_title}}" />
<meta name="description" content="{{$post->meta_desc}}" />
<meta name="robots" content="all" />

<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:image" content="{{ asset('storage/products/writeyourday.jpeg') }}" />
<meta property="og:image:width" content="180" />
<meta property="og:image:height" content="50" />

<meta property="og:type" content=website />
<meta property="og:title" content="{{$post->seo_title}}" />
<meta property="og:description" content="{{$post->meta_desc}}" />

<meta name="twitter:card" content="{{$post->seo_title}}" />
<meta name="twitter:site" content="{{ config('app.name') }}" />
<meta name="twitter:title" content="{{$post->seo_title}}" />
<meta name="twitter:description" content="{{$post->meta_desc}}" />
<meta name="twitter:image" content="{{ asset('storage/products/writeyourday.jpeg') }}" />
@endsection
@section('css')
@endsection
@section('content')
<section class="preview">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="preview-custmor-detail  d-flex justify-content-center">                    
                    <div class="user-photo-post">
                        <a href="{{route('search-user-profile',['username'=>$post->user->username])}}">
                            <img class="w-100 h-auto rounded-0" src="{{ isset($post->user->image) ? asset('storage/users/'.$post->user->image) : asset('assets/images/images.png') }}">
                        </a>
                    </div>
                    <div class="profile-info">
                        <h4>{{$post->user->name}}</h4>
                        <button class="main_btn follow_btn">Follow</button>
                        <button class="message_btn"><a href="">Message</a></button>
                    </div>
                    <a style="z-index: 1000;" @disabled(true) target="_blank" class="active folder-img"><img src="{{ asset('assets/images/folder.png') }}"></a>
                </div>
                <div class="review-detail ">
                    <ul class="date_time d-flex ">
                        <li>
                            <p><i class="far fa-clock"></i>{{ date("h:i A - M d, Y", strtotime($post->created_at)) }}</p>
                        </li>
                    </ul>
                    <h4>{{$post->title}}</h4>
                </div>
                <div class="review-detail-content">
                    {!! $post->desc !!}

                    <!-- Posst view,like,share and comment -->
                    <div class="review-detail-content-view">
                        <ul class="like_comment d-flex justify-content-between align-items-center mt-0">
                            <!-- Post Views -->
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>{{$views}}</span> Views</span></small>
                            </li>
                            <!-- Like Form -->
                            <li>
                                <a class="heart">
                                    <form action="{{$post->type==1 ? route('add-remove-like-private') : route('add-remove-like-draft') }}" method="POST" id="like_post_form_{{$post->id}}">
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
                            </li>
                            <!-- Share Form -->
                            <li>
                                <a type="button">
                                    <img src="{{ asset('assets/images/share.png') }}"><span><span class="share_count">{{$shares}}</span> Shares</span> 
                                </a>
                            </li>
                            <!-- Comment Form -->
                            <li>
                                <a><img src="{{ asset('assets/images/messsage.png') }}"><span><span>{{$comments_count}}</span> Comments</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Post Comments -->
                    <div class="review-detail-comment">
                        <ul class="like_comment mt-0">
                            <li>
                                <small><img src="{{ asset('assets/images/messsage.png') }}"><span><span>{{$comments_count}}</span>
                                        Comments</span></small>
                            </li>
                        </ul>
                        <div id="all-post-comments">                            
                            @include('partial.comment', ['comments' => $comments])
                        </div>
                        <div class="text-center mt-4 loading_" id="comment-loading">
                            <div class="spinner-border text-secondary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        @if (count($comments) > 1)  
                            <div class="review-detail-comment-box-more">
                                <a class="load-more" id="load-more" onclick="loadCommentAndReply('load-more','all-post-comments','comment-loading')" data-post-id="{{ $post->id }}" data-post-type="{{ $post->type }}" data-parent-id="" data-offset="{{ count($comments) }}" data-limit="5">Load More</a>
                            </div>
                        @endif
                        <form class="mt-4" action="{{route('add-comment')}}" id="comment-form" method="post">
                            @csrf
                            <div class="comment-form-box mb-3">
                                <div class="review-detail-comment-write mb-0">
                                    <img src="{{ asset('assets/images/messsage.png') }}">
                                    <input type="text" class="content" name="content" placeholder="Write Comment..." required>
                                    <input type="hidden" name="post_id" value="{{$post->id}}">
                                    <input type="hidden" name="post_type" value="{{$post->type}}">
                                    <button type="submit" id="comment-submit">Post</button>
                                </div>
                                <p class="text-danger mt-0 comment-error"></p>
                            </div>
                        </form>
                        <h5>More Relative Days</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Post --->
<section class="box_group">
    <div class="container">
        <!-- <------- main Li --------->
        {{-- @include('partial.related_post') --}}
    </div>
</section>

<div id="like-popup" >
</div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                AddView("{{route('add-post-view')}}","{{$post->id}}","{{$post->type}}");
            }, 10000);
        });
    </script>
    <script>
        function appendUserComment(container) {
            container.append(``);
        }
    </script>
    <script src="{{ asset('app-assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{asset('assets/js/msg_extras.js') }}"></script>
    <script src="{{asset('assets/js/post_detail.js') }}"></script>
    <script src="{{asset('assets/js/like_share_post.js') }}"></script>
@endsection