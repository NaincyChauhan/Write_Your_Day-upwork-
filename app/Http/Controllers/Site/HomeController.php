<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Messages;
// use App\Models\Policies;
// use App\Models\About;
// use App\Models\Setting;
// use App\Models\Imagegallery;
// use App\Models\Videogallery;
// use App\Models\Product;
// use App\Models\Service;
// use App\Models\Banner;
// use App\Models\Event;


use Mail;

class HomeController extends Controller
{
    public function index()
    {
        return view('site.home',[
            'active' => 'home',
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
}
