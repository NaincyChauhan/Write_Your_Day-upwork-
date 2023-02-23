<?php

namespace App\Http\Controllers;

use App\Models\Blockuser;
use Illuminate\Http\Request;
use Auth;

class BlockuserController extends Controller
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
        $user_id = Auth::user()->id;
        // UnLike Comment
        $existing_blocked = Blockuser::where('block_by_user_id', $user_id)->where('blocked_user_id', $request->user_id)->select('id')->first();
        if ($existing_blocked) {
            $existing_blocked->delete();            
            return response()->json(['status' => 1,'message' => 'Block ','type' => 0], 200);
        }
        // Like Comment        
        $blockuser = new Blockuser();
        $blockuser->block_by_user_id = $user_id;
        $blockuser->blocked_user_id = $request->user_id;
        $blockuser->save();
        return response()->json(['status' => 1,'message' => 'Unblock','type' => 1], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blockuser  $blockuser
     * @return \Illuminate\Http\Response
     */
    public function show(Blockuser $blockuser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blockuser  $blockuser
     * @return \Illuminate\Http\Response
     */
    public function edit(Blockuser $blockuser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blockuser  $blockuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blockuser $blockuser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blockuser  $blockuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blockuser $blockuser)
    {
        //
    }
}
