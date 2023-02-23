<?php

namespace App\Http\Controllers;

use App\Models\Likecomment;
use App\Models\Comment;
use Illuminate\Http\Request;
use Auth;

class LikecommentController extends Controller
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
        $user_id = $user->id;
        $comment = Comment::where('id', $request->comment_id)->exists();
        if (!$comment) { return response()->json(['status' => 0,'message' => 'Something went wrong',], 404); }
        // UnLike Comment
        $existing_like = Likecomment::where('user_id', $user_id)->where('comment_id', $request->comment_id)->select('id')->first();
        if ($existing_like) {
            $existing_like->delete();            
            return response()->json(['status' => 1,'message' => 'Comment Unliked! ','type' => 0], 200);
        }
        // Like Comment        
        $like = new Likecomment();
        $like->user_id = $user_id;
        $like->comment_id = $request->comment_id;
        $like->save();
        return response()->json(['status' => 1,'message' => 'Comment Liked! ','type' => 1], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Likecomment  $likecomment
     * @return \Illuminate\Http\Response
     */
    public function show(Likecomment $likecomment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Likecomment  $likecomment
     * @return \Illuminate\Http\Response
     */
    public function edit(Likecomment $likecomment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Likecomment  $likecomment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Likecomment $likecomment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Likecomment  $likecomment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Likecomment $likecomment)
    {
        //
    }
}
