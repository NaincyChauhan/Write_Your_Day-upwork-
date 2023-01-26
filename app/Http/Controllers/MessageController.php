<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use Illuminate\Http\Request;
use Mail;

class MessageController extends Controller
{
    function __construct()
    {
        // set permission
        $this->middleware('permission:read-Enquiry', ['only' => ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.messages.index', [
            'active' => 'message',
            'messages' => Messages::orderBy('id', 'DESC')->get()
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
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $message = new Messages();
        $message->name = $request->name;
        $message->email = $request->email;
        $message->mobile = $request->mobile;
        $message->subject = $request->subject;
        $message->message = $request->message;
        $message->save();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'subject' => $request->subject,
            'user_message' => $request->message,
        ];
        $this->sendmail($data,'mail.message');

        return back()->with('success', 'Success.! Message has been sent successfull.!');
    }

    public function sendmail($data, $template)
    {
        Mail::send($template, $data, function($message) use($data) {
            $message->to($data['email'], 'Hhanswak');
            $message->subject('New Inquiry - '.$data['subject']);
            $message->from('no-reply@nicsdedu.com','Hhanswak');
            $message->replyTo('nicsdedu@gmail.com', 'Hhanswak');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = Messages::where('id',$id)->first();
        $message->delete();
        return response()->json([
            'status' => 1, 
            'message' => "Success.! Blog has been deleted successfully.!", 
        ], 200);
    }

    public function multiDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required',
        ]);
        Messages::whereIn('id',explode(",",$request->ids))->delete();
        
        return response()->json([
            'status' => 1, 
            'message' => "Success.! Messages has been deleted successfully.",
        ], 200);
    }

    public function loadTable()
    {
        return view('admin.messages.table', [
            'messages' => Messages::orderBy('id', 'DESC')->get()
        ]);
    }
}
