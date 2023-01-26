<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Policies;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    function __construct()
    {
        // set permission
        $this->middleware('permission:update-setting');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function terms()
    {
        return view('admin.policies.terms', [
            'active' => 'terms',
            'terms' => Policies::get()->first()->term,
        ]);
    }

    public function termsUpdate(Request $request, Policies $policy)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $setting = Policies::get()->first();
        $setting->term = $request->content;
        $setting->save();

        return response()->json([
            'status' => 1, 
            'message' => "Success.! Terms & Conditions has been updated successfully.",                   
        ], 200);
    }

    public function policy()
    {
        return view('admin.policies.policy', [
            'active' => 'policy',
            'policy' => Policies::get()->first()->policy,
        ]);
    }

    public function policyUpdate(Request $request, Policies $policy)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $setting = Policies::get()->first();
        $setting->policy = $request->content;
        $setting->save();

        return response()->json([
            'status' => 1, 
            'message' => "Success.! Privacy Policy has been updated successfully.",                   
        ], 200);
    }

    public function refund()
    {
        return view('admin.policies.refund', [
            'active' => 'policy',
            'refund' => Policies::get()->first()->refund,
        ]);
    }

    public function refundUpdate(Request $request, Policies $policy)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $setting = Policies::get()->first();
        $setting->refund = $request->content;
        $setting->save();

        return response()->json([
            'status' => 1, 
            'message' => "Success.! Refund Policy has been updated successfully.",                   
        ], 200);
    }

    public function about()
    {
        return view('admin.about.index', [
            'active' => 'about',
            'setting' => Setting::get()->first(),
        ]);
    }

    public function aboutUpdate(Request $request, Setting $setting)
    {
        $request->validate([
            'about' => 'required',
        ]);

        $setting = Setting::get()->first();
        $setting->about = $request->about;
        $setting->save();

        return response()->json([
            'status' => 1, 
            'message' => "Success.! About has been updated successfully.",                   
        ], 200);
    }

    public function setting()
    {
        return view('admin.settings.index', [
            'active' => 'setting',
            'setting' => Setting::get()->first(),
        ]);
    }

    public function settingUpdate(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|mimetypes:image/jpg,image/png,image/jpeg,image/webp|max:350',
            'favicon' => 'nullable|mimetypes:image/jpg,image/ico,image/png,image/jpeg,image/webp|max:100',
        ]);

        $setting = Setting::get()->first();
        
        //Uploading Dark Logo
        if($request->hasFIle('dark_logo'))
        {
            if(is_file(public_path('/'.$setting->dark_logo)))
            {
                unlink(public_path('/'.$setting->dark_logo));
            }
            $file_name = '';
            $file = $request->file('dark_logo');
            $file_name = (string) Str::of(config('app.name'))->slug('_').'_dark_logo.'. $file->getClientOriginalExtension();
            if($file->move(public_path("/"), $file_name)){
                $setting->dark_logo = $file_name;
            }
        }

        //Uploading Light Logo
        if($request->hasFIle('light_logo'))
        {
            if(is_file(public_path('/'.$setting->light_logo)))
            {
                unlink(public_path('/'.$setting->light_logo));
            }
            $file_name = '';
            $file = $request->file('light_logo');
            $file_name = (string) Str::of(config('app.name'))->slug('_').'_light_logo.'. $file->getClientOriginalExtension();
            if($file->move(public_path("/"), $file_name)){
                $setting->light_logo = $file_name;
            }
        }
        

        //Uploading Light Logo
        if($request->hasFIle('company_profile'))
        {
            if(is_file(public_path('/'.$setting->company_profile)))
            {
                unlink(public_path('/'.$setting->company_profile));
            }
            $file_name = '';
            $file = $request->file('company_profile');
            $file_name = 'Company-Profile.'. $file->getClientOriginalExtension();
            if($file->move(public_path("/"), $file_name)){
                $setting->company_profile = $file_name;
            }
        }

        //Uploading favicon
        if($request->hasFIle('favicon'))
        {
            if(is_file(public_path('/'.$setting->favicon)))
            {
                unlink(public_path('/'.$setting->favicon));
            }
            $file_name = '';
            $file = $request->file('favicon');
            $file_name = (string) Str::of(config('app.name'))->slug('_').'_favicon.'. $file-> getClientOriginalExtension();
            if($file->move(public_path("/"), $file_name)){
                $setting->favicon = $file_name;
            }
        }
        $setting->email = $request->email;
        $setting->mobile = $request->mobile;
        $setting->address = $request->address;
        $setting->whatsapp = $request->whatsapp;
        $setting->facebook = $request->facebook;
        $setting->instagram = $request->instagram;
        $setting->linkedin = $request->linkedin;
        $setting->youtube = $request->youtube;
        $setting->twitter = $request->twitter;
        $setting->title = $request->title;
        $setting->keywords = $request->keywords;
        $setting->description = $request->description;
        $setting->save();

        return response()->json([
            'status' => 1, 
            'message' => "Success.! Setting has been Updated successfully.",                   
        ], 200);
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
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
