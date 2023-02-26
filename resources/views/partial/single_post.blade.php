@foreach ($posts as $post)    
    @php
        $logged_user = Auth::user();
    @endphp
    <ul class="msg_box mb-3 mb-sm-5 main-ul-container  main-post-container" id="post_container_{{$post->id}}">
        <li class="msg_extras_container d-flex align-items-center">
            <a class="heart">
                <form action="{{route('save-post')}}" method="POST" id="save_post_form_{{$post->id}}">
                    @csrf
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    <button class="like_button p-0" type="button" onclick="SavePostRequest({{$post->id}});"
                        id="save_post_btn_{{$post->id}}">
                        @if ($post->saves()->where('user_id', $logged_user->id)->exists())
                        <img class="red-heart d-block" style="margin-bottom: -8px;"
                            src="{{ asset('assets/images/bookmark-blue.png') }}">
                        @else
                        <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                        @endif
                    </button>
                </form>
            </a>
            <button  onclick="ShowMessageExtras($(this));" class="msg_extras_btn d-flex flex-column">
                <span class="caret"></span>
                <span class="caret"></span>
                <span class="caret"></span>
            </button>
            <ul class="msg_extras_list d-flex flex-column hide">
                <li class="msg_extra p-1 px-3 pt-2" onclick="HidePostRequest({{$post->id}},$(this))"><i
                        class="fa fa-eye-slash side_icon"></i> Hide</li>
                <li class="msg_extra p-1 px-3" onclick="ShowReportModal({{$post->id}});"><i
                        class="fa fa-user-alt-slash side_icon"></i> Report</li>
                <li class="msg_extra p-1 px-3 pb-2" onclick="ShowMessageExtras($(this))"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
            </ul>
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
                        {{-- <img src="{{ isset($post->user->image) ? asset('storage/users/'.$post->user->image) : asset('assets/images/images.png') }}"> --}}
                        <a href="{{route('search-user-profile',['username'=>$post->user->username])}}">
                            <div class="w-100 d-flex justify-content-center">
                                <div class="post-user-image">
                                    <img class="w-100 h-auto  rounded-0" src="{{ isset($post->user->image) ? asset('storage/users/'.$post->user->image) : asset('assets/images/images.png') }}">
                                </div>
                            </div>
                        </a>
                        <h4 class="post_owner"><a href="{{route('search-user-profile',['username'=>$post->user->username])}}">{{$post->user->name}}</a></h4>
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
                    <h3><a href="{{route('detail-post-view',['username'=>$post->user->username,'post_number' => $post->post_number,'slug'=>$post->slug_url])}}">{{isset($post->seo_title) ? $post->seo_title : $post->title}}</a></h3>
                    <p>
                        {!! Str::limit(isset($post->meta_desc) ? $post->meta_desc : $post->desc, 165, ' ...') !!}
                    </p>

                    <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                        <li class="d-flex justify-content-center align-items-center">
                            <small><img
                                    src="{{ asset('assets/images/eye.png') }}" /><span><span>{{$post->views_count}}</span>
                                    Views</span></small>
                            <a class="heart like_post_">
                                <form action="{{route('add-remove-like')}}" method="POST"
                                    id="like_post_form_{{$post->id}}">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{$post->id}}">
                                    <input type="hidden" name="post_type" value="{{$post->type}}">
                                    <button class="like_button d-flex align-items-end" type="button"
                                        onclick="LikePostRequest({{$post->id}},$(this));" id="like_post_btn_{{$post->id}}">
                                        @php $liked = $post->likes()->where('user_id', $logged_user->id)->exists();
                                        @endphp
                                        <img class="red-heart {{$liked == true ? 'd-block-c' : 'd-none-c' }}"
                                            src="{{ asset('assets/images/red-heart.png') }}">
                                        <img class="simple-heart {{$liked == true ? 'd-none-c' : 'd-block-c' }}"
                                            src="{{ asset('assets/images/heart.png') }}">
                                        <span><span class="post_like_count">{{$post->likes_count}}</span>
                                            Likes</span>
                                    </button>
                                </form>
                            </a>
                            <!-- Post Comments -->
                            <a class="d-flex custom-column-margin-1"><img
                                    src="{{ asset('assets/images/messsage.png') }}" /><span class="d-flex"><span
                                        class="d-block pr-4">{{$post->comments_count}}</span>
                                    Comments</span>
                            </a>
                            <form class="custom-column-margin-1" action="{{route('share-post')}}" method="POST"
                                id="share_post_form_{{$post->id}}">
                                @csrf
                                <input type="hidden" name="post_id" value="{{$post->id}}">
                                <input type="hidden" name="post_type" value="{{$post->type}}">
                                <a class="d-flex" type="button" onclick="SharePostModal({{$post->id}});"
                                    id="share_post_btn_{{$post->id}}">
                                    <img src="{{ asset('assets/images/share.png') }}"><span class="d-flex"><span
                                            class="share_count d-block pr-4">{{$post->shares_count}}</span>
                                        Shares</span>
                                </a>
                            </form>
                            <!-- Share Post Modal -->
                            <div class="overlay hide" id="share_post_container_{{$post->id}}">
                                <div class="ques_box ques_box_1" style="max-width: 31em;">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <div>
                                            <p class="ques_txt font-17">Copy Post Link</p>       
                                        </div>
                                        <span onclick="CopyPostUrl($(this),'{{route('detail-post-view',['username'=>$post->user->username,'post_number' => $post->post_number,'slug'=>$post->slug_url])}}',{{$post->id}});" class="copybutton">
                                            <i onclick="sharePostRequest({{$post->id}});" class="far fa-clipboard-list"></i>
                                        </span>
                                    </div>
                                    <div class="share_profile">
                                        <p>{{Str::limit( route('detail-post-view',['username'=>$post->user->username,'post_number' => $post->post_number,'slug'=>$post->slug_url]), 50, ' ...')}}</p> 
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
<script>
    $('#load-post-length').data('limit',"{{count($posts)}}");
</script>