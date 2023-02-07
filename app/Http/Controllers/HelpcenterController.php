<?php

namespace App\Http\Controllers;

use App\Models\Helpcenter;
use Illuminate\Http\Request;
use Auth,Mail;
use App\Mail\UserMail;

class HelpcenterController extends Controller
{
    function __construct()
    {
        // set permission
        // $this->middleware('permission:read-help-messages', ['only' => ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.help-request.index', [
            'active' => 'help-message',
            'messages' => Helpcenter::orderBy('id', 'DESC')->get()
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
        $helpcenter = new Helpcenter();
        $helpcenter->user_id = Auth::user()->id;
        $helpcenter->name = $request->name;
        $helpcenter->email = $request->email;
        $helpcenter->phone = $request->phone;
        $helpcenter->message = $request->message;
        $helpcenter->save();

        $mailData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_message' => $request->message,
            'subject' => "Help Request",
            'template' => 'mail.help',
        ];
        Mail::to(env('MAIL_USERNAME'))->send(new UserMail($mailData));

        return response()->json([
            'status' => 1,
            'message' => 'Success! Your Request Has been send successfully. We will contact you soon.',
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Helpcenter  $helpcenter
     * @return \Illuminate\Http\Response
     */
    public function show(Helpcenter $helpcenter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Helpcenter  $helpcenter
     * @return \Illuminate\Http\Response
     */
    public function edit(Helpcenter $helpcenter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Helpcenter  $helpcenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Helpcenter $helpcenter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Helpcenter  $helpcenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Helpcenter $helpcenter)
    {
        $helpcenter->delete();
        return response()->json([
            'status' => 1, 
            'message' => "Success.! Help Request has been deleted successfully.!", 
        ], 200);
    }

    public function multiDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required',
        ]);
        Helpcenter::whereIn('id',explode(",",$request->ids))->delete();
        
        return response()->json([
            'status' => 1, 
            'message' => "Success.! Help Request has been deleted successfully.",
        ], 200);
    }

    public function loadTable()
    {
        return view('admin.help-request.table', [
            'messages' => Helpcenter::orderBy('id', 'DESC')->get()
        ]);
    }
}
