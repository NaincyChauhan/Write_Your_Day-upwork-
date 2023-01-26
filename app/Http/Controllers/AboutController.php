<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    function __construct()
    {
        // set permission
        $this->middleware('permission:update-about', ['only' => ['about', 'aboutUpdate']]);
        $this->middleware('permission:update-director-message', ['only' => ['directorMessage','directorMessageUpdate']]);
    }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function show(About $about)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function edit(About $about)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, About $about)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function destroy(About $about)
    {
        //
    }

    public function about(Request $request)
    {
        return view('admin.about.about', [
            'content' => About::exists() ? About::select('about')->first()->about : ''
        ]);
    }

    public function aboutUpdate(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $about = About::select('id', 'about')->first();
        if($about)
        {
            $about->about = $request->content;
            $about->save();

            return response()->json([
                'status' => 1, 
                'message' => "Success.! about us content has been updated successfully.",            
            ], 200);
        }

        $about = new About();
        $about->about = $request->content;
        $about->save();

        return response()->json([
            'status' => 1, 
            'message' => "Success.! about us content has been updated successfully.",            
        ], 200);
    }

    public function directorMessage(Request $request)
    {
        return view('admin.about.director-message', [
            'content' => About::exists() ? About::select('director_message')->first()->director_message : ''
        ]);
    }

    public function directorMessageUpdate(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $directorMessage = About::select('id', 'director_message')->first();
        if($directorMessage)
        {
            $directorMessage->director_message = $request->content;
            $directorMessage->save();

            return response()->json([
                'status' => 1, 
                'message' => "Success.! Director Message content has been updated successfully.",            
            ], 200);
        }

        $directorMessage = new About();
        $directorMessage->director_message = $request->content;
        $directorMessage->save();

        return response()->json([
            'status' => 1, 
            'message' => "Success.! Director Message content has been updated successfully.",            
        ], 200);
    }
}
