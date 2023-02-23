@foreach ($comments as $comment)
    <div class="review-detail-comment-box-outer">
        <div class="review-detail-comment-box">
            <div class="review-detail-comment-box-img">
                <div class="comment-user-image">
                    <img class="w-100 h-auto" src="{{ isset($comment->user->image) ? asset('storage/users/'.$comment->user->image) : asset('assets/images/images.png') }}">
                </div>
            </div>
            <div class="review-detail-comment-box-content">
                <h4>{{$comment->user->name}}</h4>
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
                        <small onclick="showReplyBox({{$comment->id}})"><img src="{{ asset('assets/images/messsage.png') }}"><span>{{$comment->replies()->count()}} Reply</span></small>
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
                @include('partial.comment', ['comments' => $comment->replies])                
            </div>
            @if (count($comment->replies) > 0)                
                <a class="load-more reply-load" id="load-more-{{$comment->id}}" onclick="loadCommentAndReply('load-more-{{$comment->id}}','writereply-box-{{$comment->id}}','comment-loading-1')" data-post-id="{{$comment->post_id}}" data-post-type="{{$comment->post_type}}" data-parent-id="{{$comment->id}}" data-offset="{{count($comment->replies)}}" data-limit="5">Load More Replies</a>
            @endif 
        <div class="review-detail-comment-box-more">
            <div class="text-center mt-4 loading_" id="comment-loading-1">
                <div class="spinner-border text-secondary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
@endforeach
