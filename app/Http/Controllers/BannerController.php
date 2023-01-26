<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    function __construct()
    {
        // set permission
        $this->middleware('permission:read-banner', ['only' => ['index','show']]);
        $this->middleware('permission:create-banner', ['only' => ['create','store']]);
        $this->middleware('permission:update-banner', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-banner', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.banners.index', [
            'active' => 'banner',
            'banners' => Banner::orderBy('id', 'DESC')->get()
        ]);
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
        $request->validate([
            'image' => 'required|mimetypes:image/jpg,image/png,image/jpeg,image/webp|max:1024|min:100',
        ]);

        //Uploading Image
        if($request->hasFIle('image'))
        {
            $file_name = '';
            $file = $request->file('image');
            $file_name = 'banner'.rand(00000, 99999).'.'. $file-> getClientOriginalExtension();
            if(!$file->move(public_path("storage/banners"), $file_name)){
                return back()->with('error', 'OOPS.! Something went wrong.');
            }
        }


        //storing data
        $banner = new Banner();
        $banner->title = $request->title;
        $banner->sub_title = $request->sub_title;
        $banner->desc = $request->desc;
        $banner->btn_name = $request->btn_name;
        $banner->url = $request->url;
        $banner->image = $file_name;
        $banner->save();
        $img = $banner->image == null ? '' : "<img class='rounded' src='". asset('storage/banners/'.$banner->image)."' style='width: 50px'/>";
        return response()->json([
            'status' => 1, 
            'message' => "Success.! Banner has been added successfully.",
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', ['banner' => $banner]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image' => 'nullable|mimetypes:image/jpg,image/png,image/jpeg,image/webp|max:1024|min:100',
        ]);

        //Uploading Image
        if($request->hasFIle('image'))
        {
            $file_name = '';
            $file = $request->file('image');
            $file_name = 'banner'.rand(00000, 99999).'.'. $file-> getClientOriginalExtension();
            if($file->move(public_path("storage/banners"), $file_name)){
                if(is_file(public_path('storage/banners/'.$banner->image))){
                    unlink(public_path('storage/banners/'.$banner->image));
                }             
                $banner->image = $file_name;
            }
        }

        //storing data
        $banner->title = $request->title;
        $banner->sub_title = $request->sub_title;
        $banner->desc = $request->desc;
        $banner->btn_name = $request->btn_name;
        $banner->url = $request->url;
        $banner->save();
        // return back()->with('success', 'Banner has been updated successfully.!');
        $img = $banner->image == null ? '' : "<img class='rounded' src='". asset('storage/banners/'.$banner->image)."' style='width: 50px'/>";
        return response()->json([
            'status' => 1, 
            'message' => "Success.! Banner has been Updated successfully.",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        if(is_file(public_path('storage/banners/'.$banner->image)))
        {
            unlink(public_path('storage/banners/'.$banner->image));
        }
        $banner->delete();
        return response()->json([
            'status' => 1, 
            'message' => "Success.! Banner has been deleted successfully.",
        ], 200);
    }

    public function loadTable(){
        return view('admin.banners.table', [
            'banners' => Banner::orderBy('id', 'DESC')->get()
        ]);
    }
}
