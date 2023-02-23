<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class CommentController extends Controller
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
        $auth_user =User::where('id',Auth::user()->id)->
                    select('name','id','image')->latest()->first();
        $request->validate([
            'content' => 'required|min:5|max:500',
            'post_id' => 'required',
        ]);

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->post_id = $request->post_id;
        $comment->post_type = $request->post_type;
        $comment->user_id = $auth_user->id;
        if (isset($request->parent_id)) {
            $comment->parent_id = $request->parent_id;
        }
        $comment->save();

        return view('partial.comment_',[
            'auth_user' => $auth_user,
            'comment' => $comment,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }

    public function loadComments(Request $request)
    {
        $postId = $request->input('post_id');
        $postType = $request->input('post_type');
        $parentId = $request->input('parent_id');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $parentId = isset($parentId) ? $parentId : null;

        // retrieve the comments and replies based on the input parameters
        $comments = Comment::where('post_id', $request->input('post_id'))
            ->where('post_type', $request->input('post_type'))
            ->where('parent_id',$parentId)
            ->with(['likes','replies'=>function($query){
                $query->paginate(5);}])
            ->offset($request->input('offset'))
            ->limit($request->input('limit'))
            ->get();

        // return response()->json(['status'=>1,'comments'=>$comments]);
        return view('partial.comment',[
            'comments' => $comments,
        ]);
    }
}
