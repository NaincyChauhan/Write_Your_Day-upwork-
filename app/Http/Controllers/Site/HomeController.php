<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Followuser;
use App\Models\Post;
use App\Models\Popularpost;
use Mail,Auth,Session;

class HomeController extends Controller
{
    public function index()
    {
        $auth_user = Auth::user();
        $user = User::where('id',$auth_user->id)->
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
        // User Followers
        $followedUsers = Followuser::where('follower_user_id', $user->id)->pluck('following_user_id');
        // Get Posts
        $todayPosts = Post::select('posts.*')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->whereIn('users.id', $followedUsers)
            ->whereNotIn('posts.id', $hidesPosts)
            ->whereDate('posts.created_at', today());
        // Slip In to Random Order
        if (Session::has('viewed_posts')) {
            $viewedPosts = Session::get('viewed_posts');
            $todayPosts->inRandomOrder();
        } else {
            $todayPosts->orderByDesc('created_at');
        }

        $todayPosts = $todayPosts->get();
        
        // Store the IDs of the viewed posts in the session
        $viewedPosts = Session::get('viewed_posts', []);
        foreach ($todayPosts as $post) {
            $viewedPosts[] = $post->id;
        }
        Session::put('viewed_posts', $viewedPosts);    

        // Get Popular Post if todayPosts
        $popularPosts = Popularpost::
        with(['post'=>function($query) use ($hidesPosts){
            $query->select('posts.*')->
            withCount('comments','views','shares')->
            with(['likes','user'=>function($query){
                $query->select('id','username','image','name')
                    ->withCount(['followers']);
            }]);
        }])->whereNotIn('post_id', $hidesPosts)->take(2)->inRandomOrder()->get();

        // Load Scroll Posts -------->
        $posts_ = Post::withCount(['views', 'likes', 'shares','comments'])->
                        with(['likes','user'=>function($query){
                            $query->select('id','username','image','name')
                                    ->withCount(['followers']);
                        }])
                        ->whereNotIn('posts.id', $hidesPosts)
                        ->orderByDesc('created_at')
                        ->paginate(10, ['*'], 'page', 1);
        
        return view('site.home',[
            'followers_posts' => $todayPosts,
            'posts' => $popularPosts,
            'logged_user' => $auth_user,
            'posts_' => $posts_
        ]);
    }

    public function suspend_user_home()
    {
        $auth_user = Auth::user();
        $user = User::where('id',$auth_user->id)->
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
        // User Followers
        $followedUsers = Followuser::where('follower_user_id', $user->id)->pluck('following_user_id');
        // Get Posts
        $todayPosts = Post::select('posts.*')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->whereIn('users.id', $followedUsers)
            ->whereNotIn('posts.id', $hidesPosts)
            ->whereDate('posts.created_at', today());
        // Slip In to Random Order
        if (Session::has('viewed_posts')) {
            $viewedPosts = Session::get('viewed_posts');
            $todayPosts->inRandomOrder();
        } else {
            $todayPosts->orderByDesc('created_at');
        }

        $todayPosts = $todayPosts->get();
        
        // Store the IDs of the viewed posts in the session
        $viewedPosts = Session::get('viewed_posts', []);
        foreach ($todayPosts as $post) {
            $viewedPosts[] = $post->id;
        }
        Session::put('viewed_posts', $viewedPosts);    

        // Get Popular Post if todayPosts
        $popularPosts = Popularpost::
        with(['post'=>function($query) use ($hidesPosts){
            $query->select('posts.*')->
            withCount('comments','views','shares')->
            with(['likes','user'=>function($query){
                $query->select('id','username','image','name')
                    ->withCount(['followers']);
            }]);
        }])->whereNotIn('post_id', $hidesPosts)->take(2)->inRandomOrder()->get();

        // Load Scroll Posts -------->
        $posts_ = Post::withCount(['views', 'likes', 'shares','comments'])->
                        with(['likes','user'=>function($query){
                            $query->select('id','username','image','name')
                                    ->withCount(['followers']);
                        }])
                        ->whereNotIn('posts.id', $hidesPosts)
                        ->orderByDesc('created_at')
                        ->paginate(10, ['*'], 'page', 1);
        
        return view('site.suspend_home',[
            'followers_posts' => $todayPosts,
            'posts' => $popularPosts,
            'logged_user' => $auth_user,
            'posts_' => $posts_
        ]);
    }

    public function profileSearch()
    {
        return view('site.profile-search',[
            'active' => 'profile-search',
        ]);
    }

    public function about()
    {
        return view('site.about',[
            'active' => 'about',
            'content' => About::select('about')->first()->about
        ]);
    }

    public function directorMessage()
    {
        return view('site.director-message',[
            'active' => 'about',
            'content' => About::select('director_message')->first()->director_message
        ]);
    }

    public function contact()
    {
        return view('site.contact',[
            'active' => 'contact',
            'setting' => Setting::select('mobile', 'whatsapp', 'facebook', 'instagram', 'twitter', 'linkedin','youtube', 'address', 'email')
            ->first(),
        ]);
    }

    public function terms()
    {
        return view('site.terms',[
            'active' => 'term',
            'content' => Policies::select('term')->first()->term
        ]);
    }

    public function policy()
    {
        return view('site.policy',[
            'active' => 'term',            
            'content' => Policies::select('policy')->first()->policy
        ]);
    }

    public function refund()
    {
        return view('site.refund',[
            'active' => 'term',            
            'content' => Policies::select('refund')->first()->refund
        ]);
    }
   

    public function sednMessage(Request $request){
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'mobile' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $message = new Messages();
        $message->name = $request->name;
        $message->email = $request->email;
        $message->mobile = $request->mobile;
        $message->subject = $request->subject;
        $message->message = $request->message;
        $message->save();

        // $data = [
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'mobile' => $request->mobile,
        //     'subject' => $request->subject,
        //     'user_message' => $request->message,
        // ];

        // $this->sendmail($data, 'mail.message');

        return response()->json(['status' => 1, 'message' => 'Your Message has been sent successfull.!'], 200);
    }
    
    public function sendmail($data, $template)
    {
        Mail::send($template, $data, function($message) use($data) {
            $message->to('info@idigitalgroups.com', 'Idigitalgroups');
            $message->subject('New Inquiry - '.$data['subject']);
            $message->from('no-reply@idigitalgroups.com','Idigitalgroups');
            $message->replyTo('info@idigitalgroups.com', 'Idigitalgroups');
        });
    }

    public function LoadPostWithAjax(Request $request){
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
        // Load 100 Post Query ---------->
        // Get Posts
        // $posts = Post::withCount(['views', 'likes', 'shares','comments'])->
        //                 with(['likes','user'=>function($query){
        //                     $query->select('id','username','image','name')
        //                             ->withCount(['followers']);
        //                 }])
        //                 ->whereNotIn('posts.id', $hidesPosts)
        //                 ->orderByDesc('created_at')
        //                 ->offset($request->input('offset'))
        //                 ->limit($request->input('limit'))
        //                 ->get();
        // Load 100 Post Query ---------->

        // Load Scroll Posts -------->
        $posts = Post::withCount(['views', 'likes', 'shares','comments'])->
                        with(['likes','user'=>function($query){
                            $query->select('id','username','image','name')
                                    ->withCount(['followers']);
                        }])
                        ->whereNotIn('posts.id', $hidesPosts)
                        ->orderByDesc('created_at')
                        ->paginate(10, ['*'], 'page', $request->page);
        // Load Scroll Posts -------->

        // return response()->json(['status'=>1,'data'=>$popularPosts], 200);
        return view('partial.single_post',['posts'=>$posts]);
    }

    public function LoadPostWithAjax_2(Request $request){
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
        // Load 100 Post Query ---------->
        // Get Posts
        // $posts = Post::withCount(['views', 'likes', 'shares','comments'])->
        //                 with(['likes','user'=>function($query){
        //                     $query->select('id','username','image','name')
        //                             ->withCount(['followers']);
        //                 }])
        //                 ->whereNotIn('posts.id', $hidesPosts)
        //                 ->orderByDesc('created_at')
        //                 ->offset($request->input('offset'))
        //                 ->limit($request->input('limit'))
        //                 ->get();
        // Load 100 Post Query ---------->

        // Load Scroll Posts -------->
        $posts = Post::withCount(['views', 'likes', 'shares','comments'])->
                        with(['likes','user'=>function($query){
                            $query->select('id','username','image','name')
                                    ->withCount(['followers']);
                        }])
                        ->whereNotIn('posts.id', $hidesPosts)
                        ->orderByDesc('created_at')
                        ->paginate(10, ['*'], 'page', $request->page);
        // Load Scroll Posts -------->
        // return response()->json(['status'=>1,'data'=>$popularPosts], 200);
        return view('partial.single_post_2',['posts'=>$popularPosts]);
    }

    public function AccountHelp(){
        return view('site.user.account-help',[
            'user'=>User::where('id',Auth::user()->id)->select('name','image','id','username','email')->first(),
        ]);
    }
}
