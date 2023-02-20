<div class="review-detail-comment-box-outer" id="post-comment-{{$comment->id}}">
    <div class="review-detail-comment-box">
        <div class="review-detail-comment-box-img">
            <img class="rounded-circle" src="{{ isset($auth_user->image) ? asset('storage/users/'.$auth_user->image) : asset('assets/images/images.png') }}">
        </div>
        <div class="review-detail-comment-box-content">
            <h4>{{$auth_user->name}}</h4>
            <p>{{$comment->content}}</p>
            <ul>
                <li>
                    <a class="heart">
                        <form action="{{route('like-comment')}}" method="POST" id="like_comment_form_{{$comment->id}}">
                            @csrf
                            <input type="hidden" name="comment_id" value="{{$comment->id}}">
                            <button class="like_button d-flex justify-content-center align-items-center" type="button" onclick="LikeCommentRequest({{$comment->id}});" id="like_comment_btn_{{$comment->id}}">
                                @if ($comment->likes()->where('user_id', Auth::user()->id)->exists())                                                
                                    <img class="red-heart d-block" src="{{ asset('assets/images/red-heart.png') }}">
                                @else
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                @endif
                                <span><span class="comment_like_count">{{$comment->likes()->count()}}</span> Likes</span>
                            </button>
                        </form>
                    </a>
                </li>
                <li class="red-hearta">
                    <small onclick="showReplyBox({{$comment->id}})"><img src="{{ asset('assets/images/messsage.png') }}"><span>{{count($comment->replies)}} Reply</span></small>
                </li>
            </ul>
        </div>
        <div class="reply-comment-write" id="reply-comment-box-{{$comment->id}}">
            <form action="{{route('add-comment')}}" method="POST" id="reply-comment-form-{{$comment->id}}">
                @csrf
                <input type="text" hidden  name="parent_id" value="{{$comment->id}}">
                <input type="text" hidden  name="post_id" value="{{$comment->post_id}}">
                <input type="text" hidden  name="post_type" value="{{$comment->post_type}}">
                <div class="comment-form-box">
                    <div class="review-detail-comment-write">
                        <input type="text" name="content"class="reply-content" placeholder="Write Comment...">
                        <button data-bs-dismiss="modal" type="button" id="reply-comment-btn-{{$comment->id}}" onclick="CommentReply({{$comment->id}});">Post</button>
                    </div>
                    <p class="text-danger mt-0 comment-error"></p>
                </div>
            </form>
        </div>
    </div>
    <div class="writereply-box" id="writereply-box-{{$comment->id}}">        
    </div>
</div> 