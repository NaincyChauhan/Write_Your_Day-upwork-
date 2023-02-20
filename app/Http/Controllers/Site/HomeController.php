<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Followuser;
use App\Models\Post;
use Mail,Auth,Session;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $followedUsers = Followuser::where('follower_user_id', $user->id)->pluck('following_user_id');
        $todayPosts = Post::select('posts.*')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->whereIn('users.id', $followedUsers)
            ->whereDate('posts.created_at', today());
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
        // if ($todayPosts->isEmpty() || count($todayPosts) < 10) {
        //     // $popularPosts = Post::inRandomOrder()->limit(10)->get();
        //     $popularPosts = Post::withCount(['views', 'likes', 'shares'])
        //     ->orderByDesc('views_count')
        //     ->orderByDesc('likes_count')
        //     ->orderByDesc('shares_count')
        //     ->limit(10)
        //     ->get();
        //     return view('site.home',[
        //         'followers_posts' => [],
        //         'posts' => $popularPosts,
        //     ]);
        // }
        
        return view('site.home',[
            'followers_posts' => $todayPosts,
            'posts' => [],
        ]);
    }

    public function indexBackup()
    {
        $user_id = Auth::user()->id;
        $following = auth()->user()->following()
                    ->with(['following_user' => function ($query) {
                        $query->select('id', 'name')
                            ->with(['posts' => function ($query) {
                                $query->whereDate('created_at', Carbon::today())
                                        ->orderByDesc('created_at');
                            }]);
                    }])->get();
        $posts =  Post::orderBy('created_at', 'desc')->get();
        return view('site.home',[
            'active' => 'home',
            'follow_user_post' => $following,
            'posts' =>  $posts,
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

    public function imageGallery()
    {
        return view('site.gallery.image',[
            'active' => 'image-gallery',
            'galleries' => Imagegallery::select('image', 'title')->paginate(15)
        ]);
    }

    public function videoGallery()
    {
        return view('site.gallery.video',[
            'active' => 'video-gallery',
            'galleries' => Videogallery::select('video', 'title')->paginate(15)
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
        // Get Popular Post if todayPosts
        $popularPosts = Post::withCount(['views', 'likes', 'shares'])
            // ->orderByDesc('views_count')
            // ->orderByDesc('likes_count')
            // ->orderByDesc('shares_count')
            ->orderByDesc('created_at')
            ->offset($request->input('offset'))
            ->limit($request->input('limit'))
            ->get();
        // return response()->json(['status'=>1,'data'=>$popularPosts], 200);
        return view('partial.single_post',['posts'=>$popularPosts]);
    }
}
