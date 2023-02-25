<?php

namespace App\Http\Controllers;

use App\Models\Followuser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\UserNotification;
use Auth;

class FollowuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user= Auth::user();
        $user_ = User::where('username',$request->username)->select('username','id','name')->first();
        if (isset($user_)) {
            $user_id = $user->id;
            $exists_follow = Followuser::where('follower_user_id',$user_id)->where('following_user_id',$user_->id)->first();
            // $exists_follow = Followuser::where('following_user_id',$user_id)->where('follower_user_id',$user_->id)->first();
            if (isset($exists_follow)) {
                $exists_follow->delete();
                return response()->json(['status'=>1,'message'=>'Follow'], 200);
            }

            $follow_ = new Followuser();
            $follow_->follower_user_id = $user_id;
            $follow_->following_user_id = $user_->id;
            $follow_->save();
            $data = [
                'user_name' => $user->name,
                'user_image' => $user->image,
                'subject' => 'Start Following You.',
                'desc' => 'Start Following You.',
                'comment_title'=>'',
                'link' => route('search-user-profile',['username'=>$user->username]),
            ];
            $user_->notify(new UserNotification($data));
            return response()->json(['status'=>1,'message'=>'Following'], 200);
        }
        return response()->json(['status'=>0,'message'=>'Something Went Wrong'], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Followuser  $followuser
     * @return \Illuminate\Http\Response
     */
    public function show(Followuser $followuser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Followuser  $followuser
     * @return \Illuminate\Http\Response
     */
    public function edit(Followuser $followuser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Followuser  $followuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Followuser $followuser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Followuser  $followuser
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user= Auth::user();
        $followuser = Followuser::where('id',$id)->first();
        if (isset($followuser)) {
            $followuser->delete();
            return response()->json(['status'=>1,'message'=>'follower Remove'], 200);
        }
        return response()->json(['status'=>0,'message'=>'Something Went Wrong'], 400);
    }
}
