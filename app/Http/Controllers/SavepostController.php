<?php

namespace App\Http\Controllers;

use App\Models\Savepost;
use App\Models\Post;
use Illuminate\Http\Request;
use Auth;

class SavepostController extends Controller
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
        $post = Post::where('id', $request->post_id)->exists();
        if (!$post) { return response()->json(['status' => 0,'message' => 'Something went wrong',], 404); }
        // Remove Post From Save
        $save = Savepost::where('user_id', $user_id)->where('post_id', $request->post_id)->select('id')->first();
        if ($save) {
            $save->delete();            
            return response()->json(['status' => 1,'message' => 'Remove save ','type' => 0], 200);
        }
        
        // Save Post      
        $save = new Savepost();
        $save->user_id = $user_id;
        $save->post_id = $request->post_id;
        $save->save();
        return response()->json(['status' => 1,'message' => 'Post Saved','type' => 1], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Savepost  $Savepost
     * @return \Illuminate\Http\Response
     */
    public function show(Savepost $savepost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Savepost  $Savepost
     * @return \Illuminate\Http\Response
     */
    public function edit(Savepost $savepost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Savepost  $Savepost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Savepost $savepost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Savepost  $savepost
     * @return \Illuminate\Http\Response
     */
    public function destroy(Savepost $savepost)
    {
        $user_id = Auth::user()->id;        
        $post = Post::where('id', $request->post_id)->exists();
        if (!$post) { return response()->json(['status' => 0,'message' => 'Something went wrong',], 404); }
        // Remove Post From Save
        $save = Savepost::where('user_id', $user_id)->where('post_id', $request->post_id)->select('id')->first();
        if ($save) {
            $save->delete();            
            return response()->json(['status' => 1,'message' => 'Remove save ','type' => 0], 200);
        }
    }
}
