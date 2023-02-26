<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Post;
use App\Models\Privatepost;
use App\Models\Draftpost;
use App\Models\Savepost;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use App\Models\Policies;
use Session, Auth,Hash,Mail;
use App\Mail\UserMail;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    public  function loginuser(Request $request){
        $request->validate([
            'password' => 'required',
            'email' => 'required',
        ]);

        if(is_numeric($request->email)){
            $field = 'phone';
        }
        elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        }else{
            $field = 'username';
        }

        $user = User::where($field, $request->email)->first();
        if (isset($user)) {
            if($user->status == 1){
                if(Hash::check($request->password, $user->password))
                {                
                    Auth::loginUsingId($user->id,$request->remember);
                    return response()->json(['status' => 1, 'message' => 'True'], 200); 
                }
            }else{
                return response()->json(['status' => 0, 'message' => "Your Account is Blocked in this site.If you don't know about this please contact the Support Center"], 200);
            }
        }
        return response()->json(['status' => 0, 'message' => "Credentials Does't not match"], 200);
    }

    // Create User Registertion
    public function registeruser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20','min:3'],
            'email' => ['required', 'string', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'confirmed',Password::min(8)
            ->letters()->numbers()->symbols()],
            'username' => ['required','unique:users','max:20','min:3'],
            // 'phone' => ['required','min:10','max:10'],
            'dob' => 'required',
            'privacypolicy' => 'required',
        ]);
        
        if(Session::has('user_register_otp') && isset($request->otp))
        {
            if(Session::get('user_register_otp') == $request->otp)
            {
                if(Session::has('user_register_email') && isset($request->email))
                {
                    if (Session::get('user_register_email') == $request->email) {
                        $user = new User();
                        $user->name = $request->name;
                        $user->username = $request->username;
                        // $user->phone = $request->phone;
                        $user->email = $request->email;
                        $user->dob = $request->dob;
                        $user->bio = "Lorem Ipsum has been the industry's standard dummy";
                        $user->thought_of_the_day = "Lorem Ipsum has been the industry's standard dummy";
                        $user->password =Hash::make($request->password);
                        $user->save();
        
                        $role = Role::where('slug', 'user')->first();
                        $user->roles()->attach($role);
                        $user->permissions()->attach($role->permissions);
        
                        Auth::loginUsingId($user->id);
                        Session::forget('user_register_otp');
                        Session::forget('user_register_email');
                        return response()->json(['status' => 1, 'message' => 'User registered successfully.', 'type' => 1]);
                    }else
                    {
                        return response()->json(['status' => 0, 'message' => 'Do not try to scam , Email-Id must be same where OTP is sened..', 'type' => 1]);
                    }
                }
            }
            else
            {
                return response()->json(['status' => 0, 'message' => 'Invalid OTP.', 'type' => 1]);
            }
        }


        $otp = rand(100000, 999999);
        $mailData = [ 'name' => $request->name,'otp' => $otp,'template' => 'mail.otp','subject' => 'One Time Password'];
        try {
            Mail::to($request->email)->send(new UserMail($mailData));
        } catch (error) {
            return response()->json(['status' => 0, 'message' => $error, 'type' => 1]);
        }
        Session::put('user_register_otp', $otp);
        Session::put('user_register_email', $request->email);
        return response()->json(['status' => 1, 'message' => 'OTP has been sent In your email('.substr($request->email, 0, 10).'****). if  you missed  please check your spam folder.', 'type' => 0]);        
    }

    // User Change Password View
    public function changePassword(Request $request){
        return view('site.user.change-password',[
            'active' => $request->active,
        ]);
    }

    // User Profile View
    public function viewProfile(){
        $auth = Auth::user();
        return view('site.user.view-profile',[
            'user' => User::where('id',Auth::user()->id)->with('following','followers')->
                      select('name','email','username','image','thought_of_the_day','website','gender','bio','id')->first(),
            'publicposts' =>Post::where('user_id',$auth->id)->
                            with('likes')->
                            withCount('views','shares','comments')->orderByDesc('created_at')->get(),
            'privateposts' => Privatepost::where('user_id',$auth->id)->
                                with('likes','views','shares','comments','user')->orderByDesc('created_at')->get(),
            'draftposts' => Draftpost::where('user_id',$auth->id)->
                            with('likes','views','shares','comments')->orderByDesc('created_at')->get(),
            'saveposts' => Savepost::where('user_id',$auth->id)->
                            with(['post'=>function($query){
                                $query->with('user','likes','views','shares','comments');
                            }])->orderByDesc('created_at')->get(),
        ]);
    }

    // User  Edit Profile View
    public function editProfile(Request $request){
        return view('site.user.profile-edit',[
            'user' => User::where('id',Auth::user()->id)->
                      select('name','email','username','image','thought_of_the_day','website','gender','bio')->first(),
            'privacy' => Policies::get()->first()->policy,
        ]);
    }

    // User  Update Profile 
    public function updateProfile(Request $request){
        $user = User::where('id',Auth::user()->id)->first();

        // Type 1 describe the change and Verify the Email Id
        if(isset($request->type) && $request->type == 1){
            $request->validate([
                'email' => 'required|unique:users,email,'.$user->id,
            ]);

            if(isset($request->otp) && Session::has('change_email_otp')){
                if($request->otp == Session::get('change_email_otp')){
                    if($request->email == Session::get('change_email_id')){
                        $user->email = $request->email;
                        $user->save();
                        Session::forget('change_email_otp');
                        Session::forget('change_email_id');
                        return response()->json([
                            'status' => 1, 
                            'message' => 'Email Id has been Changed', 
                            'type' => 1,
                        ]);  
                    }else{
                        return response()->json([
                            'status' => 0, 
                            'message' => 'Email Id must be same where you send OTP request', 
                        ]);  
                    }
                }else{
                    return response()->json([
                        'status' => 0, 
                        'message' => 'Invalid OTP', 
                    ]);  
                }
            }

            $otp = rand(100000, 999999);
            $mailData = [ 'name' => $user->name,'otp' => $otp,'template' => 'mail.otp','subject' => 'One Time Password'];
            Mail::to($request->email)->send(new UserMail($mailData));
            Session::put('change_email_otp', $otp);
            Session::put('change_email_id', $request->email);
            return response()->json([
                'status' => 1, 
                'message' => 'OTP has been sent In your email('.substr($request->email, 0, 10).'****). if  you missed  please check your spam folder.', 
                'type' => 0
            ]);        
            
        }

        // Type 2 describe the change and Verify the User Phone Number
        if(isset($request->type) && $request->type == 2){
            $request->validate([
                'phone' => 'required|max:10|min:10|unique:users,phone,'.$user->id,
            ]);

            if(isset($request->otp) && Session::has('change_phone_otp')){
                if($request->otp == Session::get('change_phone_otp')){
                    if($request->phone == Session::get('change_phone_number')){
                        $user->phone = $request->phone;
                        $user->phone_verified = 1;
                        $user->save();
                        Session::forget('change_phone_otp');
                        Session::forget('change_phone_number');
                        return response()->json([
                            'status' => 1, 
                            'message' => 'Phone Number has been Changed', 
                            'type' => 1,
                        ]);  
                    }else{
                        return response()->json([
                            'status' => 0, 
                            'message' => 'Phone Number must be same where you send OTP request', 
                        ]);  
                    }
                }else{
                    return response()->json([
                        'status' => 0, 
                        'message' => 'Invalid OTP', 
                    ]);  
                }
            }

            // $otp = rand(100000, 999999);
            // Send Phone OTP
            // $mailData = [ 'name' => $user->name,'otp' => $otp,'template' => 'mail.otp','subject' => 'One Time Password'];
            // Mail::to($request->email)->send(new UserMail($mailData));
            $otp = 123456;
            Session::put('change_phone_otp', $otp);
            Session::put('change_phone_number', $request->phone);
            return response()->json([
                'status' => 1, 
                'message' => 'OTP has been sent In your Phone('.$request->phone.').', 
                'type' => 0
            ]);        
            
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:20','min:3'],
            'username' => 'required|max:20|min:3|unique:users,username,'.$user->id,   
            'thought_of_the_day' => ['max:120',isset($request->thought_of_the_day) ? 'min:10' : ""],
            'gender' => 'required',
            'bio' => ['max:120',isset($request->bio) ? 'min:10' : ""],
        ]);

        //Uploading Image
        if($request->hasFIle('image'))
        {
            $file_name = '';
            $file = $request->file('image');
            $file_name = 'user_'.rand(00000, 99999).'.'. $file-> getClientOriginalExtension();
            if($file->move(public_path("storage/users"), $file_name)){   
                if(is_file(public_path('storage/users/'.$user->image))){
                    unlink(public_path('storage/users/'.$user->image));
                }             
            }
            $user->image = $file_name;
        }
        $user->name = $request->name;
        $user->username = $request->username;
        $user->thought_of_the_day = $request->thought_of_the_day;
        $user->gender = $request->gender;
        $user->bio = nl2br($request->bio);
        $user->website = $request->website;
        $user->save();

        return response()->json([
            'status' => 1, 
            'message' => "Success.! Profile has been updated successfully.",  
            'img' => $user->image != null ? '<img src="'.asset('storage/users/'.$user->image) .'" class="photo img-fluid"  alt="User Profile">' : '',  
            'profileimage' => $user->image != null ? asset('storage/users/'.$user->image) : null,        
        ], 200);
    }

    // User Forget Password View
    public function forgetPasswordView(){
        if (Auth::check() && Auth::user()) {
            return redirect()->route('home');
        }
        return view('auth.forgotpass');
    }


    public function forgetPassword(Request $request)
    {
        $request->validate(['email' => 'required']);        
        if(!User::where('email', $request->email)->exists())
        {
            return response()->json([
                'status' => 0, 
                'message' => 'We could not find your account with '.$request->email.'. ',  
            ], 200);
        }
        $user = User::where('email',$request->email)->first(); 

        if (isset($request->type) && $request->type=='otp') {
            $otp = rand(100000, 99999999);    
            $mailData = [ 'name' =>  $user->name,'otp' => $otp,'template' => 'mail.email','subject' => 'Password Reset OTP'];
            Mail::to($request->email)->send(new UserMail($mailData));
            Session::put('user_forget_password_otp', $otp);
            return response()->json([
                'status' => 1, 
                'message' => 'A OTP has been sent to your registered '.substr($user->email, 0, 10). "***** email. if you missed please check your spam folder.OTP Valid only for 10 mintues",  
            ], 200);
        }elseif(!Session::has('user_forget_password_otp')){
            return response()->json([
                'status' => 0, 
                'message' => 'You did not send request for Email OTP, for change password send otp request!',  
            ], 200);
        }else{
            if(Session::has('user_forget_password_otp') && isset($request->otp))
            {
                if(Session::get('user_forget_password_otp') == $request->otp)
                {
                    $request->validate([
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                    ]);
                                       
                    $user->password =Hash::make($request->password);
                    $user->save();
                    Session::forget('user_forget_password_otp');
                    Auth::loginUsingId($user->id);
                    return response()->json(['status' => 1, 'message' => 'User Password Reset Successfully.', 'type' => 1]);
                }
                else
                {
                    return response()->json(['status' => 0, 'message' => 'Invalid OTP.', 'type' => 0]);
                }
            }
        }
    }

    // Handle User Delete Request
    public function deleteRequest(Request $request)
    {
        $user = User::where('id',Auth::user()->id)->select('id','password')->first();
        if(isset($user)){            
            if(Hash::check($request->password, $user->password)){                
                $user->deleted_at = Carbon::now()->addDays(14);
                $user->save();
                $request->session()->invalidate();
                return response()->json([
                    'status' => 1, 
                    'message' => 'Your account has been deleted temporarily. You can recover it within 14 days else it will be permanetly deleted.',
                ]);
            }else{
                return response()->json([
                    'status' => 0, 
                    'message' => 'Oops.! The Password is wrong.',]
                );
            }
        }else{
            return response()->json(['status' => 0, 'message' => 'Something Went Wrong.Please reload page',]);
        }
    }

    // Handle User Recover Account Request
    public function recoverRequest(Request $request)
    {
        $user = User::where('id',Auth::user()->id)->first();
        if(isset($user)){
            $user->deleted_at = null;
            $user->save();
            
            // Add a success message and redirect the user
            return response()->json([
                'status' => 1,
                'message' => 'Your account has been successfully recovered.',
            ], 200);
        }else{
            return response()->json([
                'status' => 0,
                'message' => 'Something Went Wrong',
            ], 200);
        }
    }

    // User Update Profile View
    public function updateProfileImage(Request $request){
        $request->validate([
            'image' => ['required','mimetypes:image/jpg,image/png,image/jpeg,image/webp','max:5000','min:1'],
        ]);
        $user = User::where('id',Auth::user()->id)->first();
        if($request->hasFIle('image'))
        {
            $file_name = '';
            $file = $request->file('image');
            $file_name = 'user_'.rand(00000, 99999).'.'. $file-> getClientOriginalExtension();
            if($file->move(public_path("storage/users"), $file_name)){   
                if(is_file(public_path('storage/users/'.$user->image))){
                    unlink(public_path('storage/users/'.$user->image));
                }             
            }
            $user->image = $file_name;
            $user->save();
        }
        return response()->json([
            'status' => 1, 
            'message' => "Success.! Profile Image has been updated successfully.",  
            'img' => $user->image != null ? '<img src="'.asset('storage/users/'.$user->image) .'" class="photo img-fluid"  alt="User Profile">' : '',  
            'profileimage' => $user->image != null ? asset('storage/users/'.$user->image) : null,        
        ], 200);
    }

    // Go To User Profile
    public function SearchUserProfile($username){
        $user = User::where('username',$username)->with(['posts','followers','following'])
                ->select('name','username','image','bio','id')->first();
        // dd($user->username);
        if (isset($user)) {
            if ($user->id == Auth::user()->id) {
                return redirect()->route('view-user-profile');
            }
            return view('site.user.search-profile',[
                'user' => $user,
            ]);
        }
    }

    // Set Notification As Read
    public function NotificationmarkAsRead($id)
    {
        $user = auth()->user();
        $notification = $user->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['status'=>1,'message'=>'Success'], 200);
        }
        return response()->json(['status'=>0,'message'=>'Error'], 400);
    }

    // User Notification Count
    public function UserNotificationsCount(){
        $user = auth()->user();
        return response()->json([
            'status'=>1,
            'data'=>$user->unreadNotifications->count()
        ],200);
    }

    // Get All User Notification
    public function UserNotifications(Request $request){
        $user = Auth::user(); //auth()->user()
        $unreadNotifications = $user->unreadNotifications()->get();
        $readNotifications = $user->readNotifications()->get();

        // $notifications = $unreadNotifications->concat($readNotifications)->paginate(10);
        $notifications = $unreadNotifications->concat($readNotifications);
        $currentPage = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 10;
        $notifications = new LengthAwarePaginator(
            $notifications->forPage($currentPage, $perPage),
            $notifications->count(),
            $perPage,
            $currentPage
        );

        // return view('notifications.index', compact('notifications'));
        if (isset($request->page) && $request->page > 1) {
            return view('partial.notifications',['notifications'=>$notifications]);
        }
        return view('site.user.notifications',['notifications'=>$notifications]);
        // dd("dikdflsdfalsdf",$page);
    }

    // Get User ReadNotification
    public function UserReadNotification(Request $request){
        $user = auth()->user();
        $notifications = $user->readNotifications->offset($request->offset)->limit($request->limit);
        return response()->json([
            'status' => 1,
            'message' => 'Success',
            'data' => $notifications,
        ], 200);
    }

    // Get User UnReadNotification
    public function UserUnReadNotification(Request $request){
        $user = auth()->user();
        $notifications = $user->unreadNotifications->offset($request->offset)->limit($request->limit);
        return response()->json([
            'status' => 1,
            'message' => 'Success',
            'data' => $notifications,
            'type' => 1
        ], 200);
    }
}
