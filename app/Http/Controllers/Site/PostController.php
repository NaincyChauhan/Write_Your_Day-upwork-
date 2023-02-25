<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\View;
use App\Models\User;
use App\Models\Privatepost;
use App\Models\Draftpost;
use App\Models\Likepost;
use App\Models\Sharepost;
use App\Models\Comment;
use App\Models\Reportpost;
use App\Models\Hidepost;
use App\Notifications\UserNotification;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // Crate Post View
    public function CreatePost(){
        $user = Auth::user();
        $public_post =  Post::where('user_id',$user->id)->whereDate('created_at', today())->count();
        $public_private = Privatepost::where('user_id',$user->id)->whereDate('created_at', today())->count();
        $public_draft =  Draftpost::where('user_id',$user->id)->whereDate('created_at', today())->count();
        if ($public_post >= 1) {
            return back()->with([
                'error' => "One Day per day limit reached!",
            ]);
        }
        if ($public_private >= 1) {
            return back()->with([
                'error' => "Day limit reached, but today's Private Day can be edited and toggled Public!",
            ]);
        }
        if ( $public_draft >= 1) {
            return back()->with([
                'error' => "Day limit reached, but today's Draft Day can be edited and toggled Public/Private!",
            ]);
        }
        $new_post = new Draftpost();
        $title = Carbon::now()->format('YmdHis').Str::random(10); 
        $new_post->title = "Day_".$title;
        $new_post->slug_url =  (string) Str::of($new_post->title)->slug('-');
        $new_post->type = 2;
        $new_post->user_id = $user->id;
        $new_post->save();
        return view('site.post.create',[
            'user' => User::where('id',$user->id)->
                      select('name','image')->first(),
            'new_post' => $new_post,
        ]);
    }

    // Stote Post
    public function StorePost(Request $request){
        if (isset($request->post_id)) {
            $draft_post = Draftpost::where('id',$request->post_id)->first();
            if(isset($request->title))
            {
                $request['slug_url'] = (string) Str::of($request->title)->slug('-');
            }
            if ($request->type == 2) {
                $request->validate([
                    'title' => 'required|max:100',
                    'slug_url' => 'required|max:100',
                ]);
                $post = $draft_post;
            }
            if ($request->type==0 || $request->type==1) {
                $request->validate([
                    'title' => 'required|max:100',
                    'slug_url' => 'required|max:100',
                    'desc' => 'required',
                    'seo_title' => 'max:100',
                    'meta_desc' => 'max:2500',
                ]);
            }
            if ($request->type == 0) {
                $post = new Post();
                $last_post = Post::where('user_id',Auth::user()->id)->where('type',$request->type)->select('post_number')->latest()->first();
                if (isset($last_post)) {
                    if ($last_post->post_number == 365 || $last_post->post_number > 365) {
                        $post->post_number = 1;
                    }
                    $post->post_number = $last_post->post_number+1;
                }else{
                    $post->post_number = 1;
                }
            }
            if ($request->type == 1) {
                $post = new Privatepost();
            }
            $post->title = $request->title;
            $post->user_id = Auth::user()->id;
            $post->type = $request->type;
            $post->slug_url = $request->slug_url;
            $post->desc = $request->desc;
            $post->seo_title = $request->seo_title;
            $post->meta_desc = $request->meta_desc;
            $post->save();

            // Remove to Draft Posts
            if ($request->type != 2) {
                $draft_post->delete();
            }

            return response()->json([
                'status' => 1, 
                'message' => "Success.! Day has been Create successfully.",            
            ], 200);
        }
        return response()->json([
            'status' => 0, 
            'message' => "Something Went Wrong.",            
        ], 200);
    }

    // Auto Draft Saved Post
    public function autoDraftPostRequest(Request $request){
        if (isset($request->title) && isset($request->slug_url)) {
            $draft_post = Draftpost::where('id',$request->post_id)->first();
            $draft_post->title = $request->title;
            $draft_post->desc = $request->descripation;
            $draft_post->seo_title = $request->seo_title;
            $draft_post->slug_url = $request->slug_url;
            $draft_post->meta_desc = $request->meta_desc;
            $draft_post->save();
            return response()->json(['status'=>1,'message'=>"Draft Saved"], 200);
        }
        return response()->json(['status'=>0,'message'=>"Something Wrong"], 400);
    }

    // Add View in Post
    public function addPostView(Request $request){
        $user = Auth::user();
        View::firstOrCreate([
            'post_id' => $request->post_id,
            'post_type' => $request->post_type,
            'user_id' => $user->id,
        ]);
        return response()->json([
            'status' => 1, 
            'message' => "Success",            
        ], 200);
    }

    // Edit Post View
    public function editPostView($type,$slug){
        $user = Auth::user();
        $user_id = $user->id;
        if ($type == 0) {
            $post = Post::where([['slug_url', '=' ,$slug],['type', '=' ,$type],['user_id','=',$user_id]])->
            select('user_id','title','desc','seo_title','slug_url','meta_desc','type','id','created_at','post_number');
        }
        if ($type == 1) {
            $post = Privatepost::where([['slug_url', '=' ,$slug],['type', '=' ,$type],['user_id','=',$user_id]])->
            select('user_id','title','desc','seo_title','slug_url','meta_desc','type','id','created_at');
        }
        if ($type == 2) {
            $post = Draftpost::where([['slug_url', '=' ,$slug],['type', '=' ,$type],['user_id','=',$user_id]])->
            select('user_id','title','desc','seo_title','slug_url','meta_desc','type','id','created_at');
        }
        $post = $post->
                with(['user'=> function($query){
                    $query->select('id','username','image','name');
                }])->
                withCount('views','likes','shares','comments')->
                first();
        if (!isset($post)) {
            return abort(404);
        }
        return view('site.post.edit',[
            'post' => $post,
            'user' => User::where('id',$user_id)->
                      select('name','image')->first(),
        ]);
    }

    // Update Post
    public function updatePost($type,$id,Request $request){
        $user = Auth::user();
        $auth_id = $user->id;
        if(isset($request->title))
        {
            $request['slug_url'] = (string) Str::of($request->slug_url)->slug('-');
        }

        // Check Post  Type
        if ($type==0) {
            $post = Post::where('id',$id)->latest()->first();
            if (($request->type !=0 )&& ($request->type==1 || $request->type==2)) {
                $deletePost = Post::where('id',$id)->latest()->first();
            }            
            $request->validate([
                'slug_url' => 'required|max:100|unique:posts,slug_url,'.$post->id,
            ]);
        }
        if ($type==1) {
            $post = Privatepost::where('id',$id)->latest()->first();
            if ($request->type !=1) {
                $deletePost = Privatepost::where('id',$id)->latest()->first();
            }  
            $request->validate([
                'slug_url' => 'required|max:100|unique:privateposts,slug_url,'.$post->id,
            ]);
        }
        if($type==2){
            $post = Draftpost::where('id',$id)->latest()->first();
            if ($request->type !=2) {
                $deletePost = Draftpost::where('id',$id)->latest()->first();
            }
            $request->validate([
                'slug_url' => 'required|max:100|unique:draftposts,slug_url,'.$post->id,
            ]);
        }
        // Check Post is exits
        if (!isset($post) || $auth_id != $post->user_id) {
            return abort(404);
        }

        if ($post->type != $request->type) {
            // dd("debugging1111 post type".$post->type."  this is new type".$request->type);
            $public_post =  Post::where('user_id',$user->id)->whereDate('created_at', today())->select('id','type','created_at')->first();
            // dd("this is today created post". $public_post . " __ this is edited post". $post->created_at );
            if (isset($public_post) && $public_post->created_at->startOfDay() != $post->created_at->startOfDay()) {
                return response()->json([
                    'status' => 0, 
                    'message' => "One Day per day limit reached!",            
                ], 200);
            }

            // Check Private Post Type
            $private_post = Privatepost::where('user_id',$user->id)->whereDate('created_at', today())->select('id','type','created_at')->first();
            if (isset($private_post) && $private_post->created_at->startOfDay() != $post->created_at->startOfDay()) {
                return response()->json([
                    'status' => 0, 
                    'message' => "Day limit reached, but today's Private Day can be edited and toggled Public!",            
                ], 200);
            }

            // check Draft Post 
            $draft_post =  Draftpost::where('user_id',$user->id)->whereDate('created_at', today())->select('id','type','created_at')->first();
            if (isset($draft_post) && $draft_post->created_at->startOfDay() != $post->created_at->startOfDay()) {
                return response()->json([
                    'status' => 0, 
                    'message' => "Day limit reached, but today's Draft Day can be edited and toggled Public/Private!",            
                ], 200);
            }
        }
        // dd("debugging2222 post type".$post->type."  this is new type".$request->type);

        // Create New Post
        if ($request->type==0 && $type!=0) {
            $post = new Post();
            $request->validate([
                'slug_url' => 'required|unique:posts|max:100',               
            ]);
            $last_post = Post::where('user_id',$auth_id)->where('type',0)->select('post_number')->latest()->first();
            if (isset($last_post)) {
                $post->post_number = $last_post->post_number+1;
            }else{
                $post->post_number = 1;
            }
        }
        if ($request->type==1 && $type!=1) {
            $post = new Privatepost();
            $request->validate([
                'slug_url' => 'required|unique:privateposts|max:100',               
            ]);
        }
        if ($request->type==2 && $type!=2) {
            $post = new Draftpost();
            $request->validate([
                'slug_url' => 'required|unique:draftposts|max:100',               
            ]);
        }        

        $request->validate([
            'title' => 'required|max:100',
            'desc' => 'required',
            'seo_title' => 'max:100',
            'meta_desc' => 'max:2500',
        ]);

        $post->title = $request->title;
        $post->user_id = Auth::user()->id;
        $post->type = $request->type;
        $post->slug_url = $request->slug_url;
        $post->desc = $request->desc;
        $post->seo_title = $request->seo_title;
        $post->meta_desc = $request->meta_desc;
        $post->save();
        
        if (isset($deletePost)) {
            // Update Comments
            $comments = Comment::where([['post_type','=',$deletePost->type],['post_id','=',$deletePost->id]])->get();
            if (count($comments) > 0) {
                foreach ($comments as $comment) {
                    $comment->post_type = $post->type;
                    $comment->post_id = $post->id;
                    $comment->save();
                }

            }
    
            // Update Likes
            $likes = Likepost::where([['post_type','=',$deletePost->type],['post_id','=',$deletePost->id]])->get();
            if (count($likes) > 0) {
                foreach ($likes as $like) {
                    $like->post_type = $post->type;
                    $like->post_id = $post->id;
                    $like->save();
                }
            }
    
            // Update Share
            $shares = Sharepost::where([['post_type','=',$deletePost->type],['post_id','=',$deletePost->id]])->get();
            if (count($shares) > 0) {
                foreach ($shares as $share) {
                    $share->post_type = $post->type;
                    $share->post_id = $post->id;
                    $share->save();
                }
            }
    
            // Update Views
            $views = View::where([['post_type','=',$deletePost->type],['post_id','=',$deletePost->id]])->get();
            if (count($views) > 0) {
                foreach ($views as $view) {
                    $view->post_type = $post->type;
                    $view->post_id = $post->id;
                    $view->save();
                }
            }
            $deletePost->delete();
        }

        return response()->json([
            'status' => 1, 
            'message' => "Success! Day has been updated Successfully.",            
        ], 200);
    }

    // Public Post Detail
    public function PublicPostDetailView($username,$post_number,$slug){
        $post = Post::where('slug_url',$slug)->where('post_number',$post_number)->
                select('id','created_at','type','title','desc','seo_title','meta_desc','slug_url','user_id','post_number')->
                with(['user'=> function($query){
                    $query->select('username','image','name','id')->
                    with('followers');
                },'views','likes','shares','comments' => function ($query) {
                    $query->where('parent_id', null)->with(['likes','replies'=>function($query){
                        $query->with(['likes','replies'=>function($query){
                            $query->paginate(5);
                        }])->paginate(5);
                    }])->orderBy('created_at', 'desc')->paginate(5);
                }])->
                first();
        if (!isset($post)) {
            return abort(404);
        }
        $related_post = Post::where('type',0)->where('user_id',$post->user_id)->where('id','<>',$post->id)->
                with(['user','views','likes','shares','comments'])->
                select('id','created_at','type','title','desc','seo_title','meta_desc','slug_url','user_id','post_number')->
                latest()->first();
        return view('site.post.detail',[
            'post' => $post,
            'related_post' => $related_post
        ]);
    }

    // Private Post Detail
    public function PrivatePostDetailView($type,$slug){
        $auth_user= Auth::user()->id;
        $post = Privatepost::where([['slug_url','=',$slug],['type','=',$type],['user_id','=',$auth_user]])
                ->with('user')
                ->select('id','created_at','type','title','desc','seo_title','meta_desc','slug_url','user_id')
                ->first();
    
        if (!$post) {
            return abort(404);
        }
        $post_comments= Comment::where([['post_id','=',$post->id],['post_type','=',$post->type]]);
        $post_likes=Likepost::where([['post_id','=',$post->id],['post_type','=',$post->type]]);
        return view('site.post.detail_',[
            'post' => $post,
            'views' => View::where([['post_id','=',$post->id],['post_type','=',$post->type]])->count(),
            'comments_count' => $post_comments->count(),
            'comments' => $post_comments->where('parent_id',null)->with(['likes','replies'=>function($query){
                            $query->paginate(5);
                        }])->paginate(5),
            'shares' => Sharepost::where([['post_id','=',$post->id],['post_type','=',$post->type]])->count(),
            'likes' => $post_likes->count(),
            'user_like' => $post_likes->where('user_id',$auth_user)->first(),
        ]);
    }

    // Draft Post Detail
    public function draftPostDetailView($type,$slug){
        $auth_user= Auth::user()->id;
        $post = Draftpost::where([['slug_url','=',$slug],['type','=',$type],['user_id','=',$auth_user]])
            ->with('user')
            // ->with('user','countLikes','countViews','countComments','postComments')
            ->select('id','created_at','type','title','desc','seo_title','meta_desc','slug_url','user_id')
            ->first();
    
        if (!$post) {
            return abort(404);
        }
        $post_comments= Comment::where([['post_id','=',$post->id],['post_type','=',$post->type]]);
        $post_likes=Likepost::where([['post_id','=',$post->id],['post_type','=',$post->type]]);
        return view('site.post.detail_',[
            'post' => $post,
            'views' => View::where([['post_id','=',$post->id],['post_type','=',$post->type]])->count(),
            'comments_count' => $post_comments->count(),
            'comments' => $post_comments->where('parent_id',null)->with(['likes','replies'=>function($query){
                                $query->paginate(5);
                            }])->paginate(5),
            'shares' => Sharepost::where([['post_id','=',$post->id],['post_type','=',$post->type]])->count(),
            'likes' => $post_likes->count(),
            'user_like' => $post_likes->where('user_id',$auth_user)->first(),
        ]);
    }

    // Pulic Post LIke
    public function publicPostLike(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $request->validate([
            'post_id' => 'required',
            'post_type' => 'required',
        ]);
        $post = Post::where('id', $request->post_id)->
                where('type', $request->post_type)->with(['likes','user'=>function($query){
                    $query->select('username','id','name');
                }])->
                select('id','type','user_id','slug_url','post_number','title')->first();
        if (!$post) {
            return response()->json(['status' => 0,'message' => 'Something went wrong',], 404);
        }

        $un_like_post=  $this->UnLikePost($request,$user_id);
        if ($un_like_post) {
            return response()->json(['status' => 1,'message' => 'Post Disliked! ','type' => 0], 200);
        }

        $like_post=  $this->LikePost($request,$user_id);
        if ($user_id != $post->user_id) {
            $data = [
                'user_name' => $user->name,
                'user_image' => $user->image,
                'subject' => 'Reacted To Your Post',
                'desc' => $post->title,
                'comment_title'=>'',
                'link' => route('detail-post-view',[
                    'username'=>$post->user->username,
                    'post_number'=>$post->post_number,
                    'slug'=>$post->slug_url
                ]),
            ];
            $this->sendNotification($data,$post->user_id);
        }
        if ($like_post) {
            return response()->json(['status' => 1,'message' => 'Post Liked! ','type' => 1], 200);
        }
    }

    // Private Post Like
    public function privatePostLike(Request $request){
        $user_id = Auth::user()->id;
        $request->validate([
            'post_id' => 'required',
            'post_type' => 'required',
        ]);
        $post = Privatepost::where('id', $request->post_id)->where('type', $request->post_type)->exists();
        if (!$post) {
            return response()->json(['status' => 0,'message' => 'Something went wrong',], 404);
        }
        
        $un_like_post=  $this->UnLikePost($request,$user_id);
        if ($un_like_post) {
            return response()->json(['status' => 1,'message' => 'Post Disliked! ','type' => 0], 200);
        }

        $like_post=  $this->LikePost($request,$user_id);
        if ($like_post) {
            return response()->json(['status' => 1,'message' => 'Post Liked! ','type' => 1], 200);
        }
    }

    // Draft Post LIke
    public function draftPostLike(Request $request){
        $user_id = Auth::user()->id;
        $request->validate([
            'post_id' => 'required',
            'post_type' => 'required',
        ]);
        $post = Draftpost::where('id', $request->post_id)->where('type', $request->post_type)->exists();
        if (!$post) {
            return response()->json(['status' => 0,'message' => 'Something went wrong',], 404);
        }

        $un_like_post=  $this->UnLikePost($request,$user_id);
        if ($un_like_post) {
            return response()->json(['status' => 1,'message' => 'Post Disliked! ','type' => 0], 200);
        }

        $like_post=  $this->LikePost($request,$user_id);
        if ($like_post) {
            return response()->json(['status' => 1,'message' => 'Post Liked! ','type' => 1], 200);
        }
    }

    // Unlike Post
    private function UnLikePost($request,$user_id){
        $existing_like = Likepost::where('user_id', $user_id)
                        ->where('post_id', $request->post_id)
                        ->where('post_type', $request->post_type)
                        ->first();

        if ($existing_like) {
            $existing_like->delete();            
            return true;
        }
        return false;
    }

    // Like Post
    private function LikePost($request,$user_id){
        // Create a new like record
        $like = new Likepost();
        $like->user_id = $user_id;
        $like->post_id = $request->post_id;
        $like->post_type = $request->post_type;
        $like->save();
        return true;
    }

    // Share Public Post
    public function PostShare(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $post = Post::where('id', $request->post_id)->where('type', $request->post_type)->exists();
        if (!$post) {
            return response()->json(['status' => 0,'message' => 'Something went wrong',], 404);
        }
        $share_post =Sharepost::where([['user_id','=',$user_id],['post_id','=', $request->post_id],['post_type','=',$request->post_type]])->
                    latest()->first();
        if(isset($share_post)){
            return response()->json([
                'status' => 1, 
                'type' => 0,
                'message' => "Success",            
            ], 200);
        }
        Sharepost::firstOrCreate([
            'post_id' => $request->post_id,
            'post_type' => $request->post_type,
            'user_id' => $user_id,
        ]);
        return response()->json([
            'status' => 1, 
            'type' => 1,
            'message' => "Success",            
        ], 200);
    }

    // Delete Public Post
    public function deletePublicPost(Request $request){
        $post = Post::where([['id','=',$request->post_id],['type','=',$request->post_type],['user_id','=',Auth::user()->id]])->first();
        if (!$post) {
            return response()->json(['status' => 0,'message' => 'Something wrong',], 404);
        }
        $post->delete();
        return response()->json(['status' => 1,'message' => 'Post Deleted',], 200);
    }

    // Delete Pricate Post
    public function deletePrivatePost(Request $request){
        $post = Privatepost::where([['id','=',$request->post_id],['type','=',$request->post_type],['user_id','=',Auth::user()->id]])->first();
        if (!$post) {
            return response()->json(['status' => 0,'message' => 'Something wrong',], 404);
        }
        $post->delete();
        return response()->json(['status' => 1,'message' => 'Post Deleted',], 200);
    }

    // Delete Draft Post
    public function deleteDraftPost(Request $request){
        $post = Draftpost::where([['id','=',$request->post_id],['type','=',$request->post_type],['user_id','=',Auth::user()->id]])->first();
        if (!$post) {
            return response()->json(['status' => 0,'message' => 'Something wrong',], 404);
        }
        $post->delete();
        return response()->json(['status' => 1,'message' => 'Post Deleted',], 200);
    }

    // Search Post and Friends
    public function searchPostFriends(Request $request){
        if ($request->type == 1) {
            $users = $this->searchUser($request);
            return view('site.user.search-users',[
                'users' => $users,
                'search_query'=>$request->search,
            ]);

        }else{
            $posts = $this->searchPost($request);
            return view('site.post.search-posts',[
                'posts' => $posts,
                'search_query'=>$request->search,
            ]);
        }
        return abort(404);
    }

    // Search Post and Friends
    public function searchUser($request){
        $users =  User:: Where('username','like','%'.$request->search.'%')->
            orWhere('name','like','%'.$request->search.'%')->
            orWhere('email','like','%'.$request->search.'%')->
            whereNotIn('id',[Auth::user()->id])->
            with('followers','following')->
            select('name','username','id','image','thought_of_the_day','bio','website','email')->
            paginate(2, ['*'], 'page', isset($request->page) ? $request->page : 1);

        // if($users->count() < 1){
        //     $users =  User::
        //             select('name','username','id','image','thought_of_the_day','bio','website','email')->
        //             orderBy('created_at', 'desc')->take(10)->get();                
        // }
        return $users;
    }

    public function searchPost($request){
        $user = User::where('id',Auth::user()->id)->
        with(['hideposts'=> function($query){
            $query->with(['post'=>function($query){
                $query->select('id');
            }]);
        }])->first();
        // User Hide Posts
        $hidesPosts = [];
        foreach ($user->hideposts as $key => $hidepost) {
            $hidesPosts[] = $hidepost->post->id;            
        }
        $posts =Post::where(function($q) use ($request){
                    $q->where('title', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('desc', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('slug_url', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('seo_title', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('meta_desc', 'LIKE', '%'.$request->search.'%');
                })->
                whereNotIn('posts.id', $hidesPosts)->
                select('seo_title','title','desc','meta_desc','post_number','slug_url','created_at','user_id','id','type')->
                withCount(['views','shares','comments'])->
                with(['likes','user'=> function($query){
                    $query->select('name','username','id','image')->
                    withCount('followers')->
                    with('following');
                }])->
                paginate(10, ['*'], 'page', isset($request->page) ? $request->page : 1);
        // if($posts->count() < 1){
        //     $posts =Post::withCount(['views','shares','comments'])->
        //             whereNotIn('posts.id', $hidesPosts)->
        //             with(['likes','user'=> function($query){
        //                 $query->select('name','username','id','image')->
        //                 withCount('followers')->
        //                 with('following');
        //             }])->
        //             whereNotIn('posts.id', $hidesPosts)->
        //             select('seo_title','meta_desc','post_number','slug_url','created_at','user_id','id')->
        //             orderBy('created_at', 'desc')->take(10)->get();
        // }
        return $posts;
    }

    public function searchWithAjax(Request $request){
        if ($request->type == 1) {
            $users = $this->searchUser($request);
            return view('partial.search_users',[
                'users' => $users,
            ]);
        }else{
            $posts = $this->searchPost($request);
            return view('partial.search_posts',[
                'posts' => $posts,
            ]);
        }
    }

    public function reportPost(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        if ($request->post_id) {
            $post = Post::where('id',$request->post_id)->select('id','user_id')->first();
            if (isset($post)) {
                $report =  new Reportpost();
                $report->post_id = $request->post_id;
                $report->report = $request->report;
                $report->user_id = $user_id;
                $report->save();

                $user_reports = Reportpost::where('post_id',$request->post_id)->get();
                if (isset($user_reports) || $user_reports->count() >= 10) {
                    $user = User::where('id',$post->user_id)->first();
                    $user->suspend_mode = 1;
                    $user->save();
                }

                $report =  new Hidepost();
                $report->post_id = $request->post_id;
                $report->user_id = $user_id;
                $report->save();

                return response()->json(['status'=>1,'message'=>"Reported"], 200);
            }
        }
        return response()->json(['status'=>0,'message'=>"Something Wrong"], 400);
    }

    public function hidePost(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $post = Post::where('id',$request->post_id)->select('id')->first();
        if (isset($post)) {
            $report =  new Hidepost();
            $report->post_id = $post->id;
            $report->user_id = $user_id;
            $report->save();
            return response()->json(['status'=>1,'message'=>"Day Hide"], 200);
        }
        return response()->json(['status'=>0,'message'=>"Something Wrong"], 400);
    }

    public function printPost($username,$post_number,$slug){
        $post = Post::where([
                    ['slug_url', '=', $slug],
                    ['post_number', '=', $post_number],
                ])->join('users', 'users.id', '=', 'posts.user_id')
                ->where('users.username', $username)
                ->with(['likes', 'shares', 'comments', 'views', 'user'])
                ->first();
        
        if (isset($post)) {
            return view('site.post.print_post',[
                'post' => $post,
            ]);
        }else{
            return abort(404);
        }
    }
    
    private function sendNotification($data,$user_id){
        $user = User::where('id',$user_id)->first();        
        $user->notify(new UserNotification($data));
    }
}
