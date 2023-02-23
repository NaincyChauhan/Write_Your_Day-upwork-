<?php

namespace App\Http\Controllers;

use App\Models\Reportuser;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ReportuserController extends Controller
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
        $user = User::where('id',$request->user_id)->select('id','suspend_mode')->first();
        if (isset($user)) {
            $report =  new Reportuser();
            $report->reported_user_id = $user->id;
            $report->report = $request->report;
            $report->report_by_user_id = Auth::user()->id;
            $report->save();

            $user_reports = Reportuser::where('reported_user_id',$user->id)->get();
            if (isset($user_reports) || $user_reports->count() >= 10) {
                $user->suspend_mode == 1;
                $user->save();
            }
            return response()->json(['status'=>1,'message'=>"Reported"], 200);
        }
        return response()->json(['status'=>0,'message'=>"Something Wrong"], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reportuser  $reportuser
     * @return \Illuminate\Http\Response
     */
    public function show(Reportuser $reportuser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reportuser  $reportuser
     * @return \Illuminate\Http\Response
     */
    public function edit(Reportuser $reportuser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reportuser  $reportuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reportuser $reportuser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reportuser  $reportuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reportuser $reportuser)
    {
        //
    }
}
