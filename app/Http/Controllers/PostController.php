<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    function __construct()
    {
        // set permission
        // $this->middleware('permission:read-post', ['only' => ['index','show']]);
        // $this->middleware('permission:create-post', ['only' => ['create','store']]);
        // $this->middleware('permission:update-post', ['only' => ['edit','update']]);
        // $this->middleware('permission:delete-post', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.posts.index', [
            'active' => 'post',
            'posts' => Post::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.add', [
            'active' => 'post',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100',
            'slug_url' => 'required|unique:posts|max:100',
            'desc' => 'required',
            'seo_title' => 'required|max:100',
            'meta_desc' => 'required|max:2500',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->user_id = Auth::user()->id;
        $post->type = $request->type;
        $post->slug_url = $request->slug_url;
        $post->desc = $request->desc;
        $post->seo_title = $request->seo_title;
        $post->meta_desc = $request->meta_desc;
        $post->save();

        return response()->json([
            'status' => 1, 
            'message' => "Success.! Post has been added successfully.",            
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', [
            'active' => 'post',
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:100',
            'slug_url' => 'required|max:100|unique:posts,slug_url,'.$post->id,
            'desc' => 'required',
            'seo_title' => 'required|max:100',
            'meta_desc' => 'required|max:2500',
        ]);

        $post->title = $request->title;
        $post->slug_url = $request->slug_url;
        $post->desc = $request->desc;
        $post->seo_title = $request->seo_title;
        $post->meta_desc = $request->meta_desc;
        $post->save();

        return response()->json([
            'status' => 1, 
            'message' => "Success.! Post has been updated successfully.",                   
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'status' => 1, 
            'message' => "Success.! Post has been deleted successfully.",
        ], 200);
    }

    public function loadTable()
    {
        return view('admin.posts.table', [
            'posts' => Post::latest()->get(),
        ]);
    }
}
