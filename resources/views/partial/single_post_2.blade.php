@foreach ($posts as $post)    
    @php
        $logged_user = Auth::user();
    @endphp
    <ul class="msg_box mb-3 mb-sm-5 main-ul-container" id="post_container_{{$post->id}}">
        <li class="msg_extras_container d-flex align-items-center">
            <a class="heart">
                @if ($post->saves()->where('user_id', $logged_user->id)->exists())
                        <img class="red-heart d-block" style="margin-bottom: -8px;"
                            src="{{ asset('assets/images/bookmark-blue.png') }}">
                        @else
                        <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                        @endif
            </a>
            <button  disabled class="msg_extras_btn d-flex flex-column">
                <span class="caret"></span>
                <span class="caret"></span>
                <span class="caret"></span>
            </button>
        </li>
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
            <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                <div class="left_part">
                    <div class="radious_img">
                        <a>
                            <div class="w-100 d-flex justify-content-center">
                                <div class="post-user-image">
                                    <img class="w-100 h-auto  rounded-0" src="{{ isset($post->user->image) ? asset('storage/users/'.$post->user->image) : asset('assets/images/images.png') }}">
                                </div>
                            </div>
                        </a>
                        <h4 class="post_owner"><a>{{$post->user->name}}</a></h4>
                        <p>Followers:{{$post->user->followers_count}}</p>
                    </div>
                    @if ($logged_user->id !== $post->user->id)
                    <div class="content_part">
                        <button class="main_btn follow_btn"
                            onclick="FollowUnFollowRequest({{$post->user->id}},$(this));">
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
                    <h3><a>{{isset($post->seo_title) ? $post->seo_title : $post->title}}</a></h3>
                    <p>
                        {!! Str::limit(isset($post->meta_desc) ? $post->meta_desc : $post->desc, 200, ' ...') !!}
                    </p>

                    <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                        <li class="d-flex justify-content-center align-items-center">
                            <small><img
                                    src="{{ asset('assets/images/eye.png') }}" /><span><span>{{$post->views_count}}</span>
                                    Views</span></small>
                                    <a class="heart like_post_ mt-1">
                                        <button class="like_button d-flex align-items-end" type="button">
                                                @php $liked = $post->likes()->where('user_id', $logged_user->id)->exists();
                                                @endphp
                                                <img class="red-heart {{$liked == true ? 'd-block-c' : 'd-none-c' }}"
                                                    src="{{ asset('assets/images/red-heart.png') }}">
                                                <img class="simple-heart {{$liked == true ? 'd-none-c' : 'd-block-c' }}"
                                                    src="{{ asset('assets/images/heart.png') }}">
                                                <span style="color: #626262"><span class="post_like_count" >{{$post->likes_count}}</span>
                                                    Likes</span>
                                            </button>
                                    </a>
                            <!-- Post Comments -->
                            <a class="d-flex custom-column-margin-1"><img
                                    src="{{ asset('assets/images/messsage.png') }}" /><span class="d-flex"><span
                                        class="d-block pr-4">{{$post->comments_count}}</span>
                                    Comments</span>
                            </a>
                            <a class="d-flex" type="button" onclick="sharePostRequest({{$post->id}});"
                                id="share_post_btn_{{$post->id}}">
                                <img src="{{ asset('assets/images/share.png') }}"><span class="d-flex"><span
                                        class="share_count d-block pr-4">{{$post->shares_count}}</span>
                                    Shares</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
@endforeach
<script>
    $('#load-post-length').data('limit',"{{count($posts)}}");
</script>