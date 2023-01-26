<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Userapplication;
use App\Models\Messages;
use Illuminate\Http\Request;
use Carbon\Carbon, Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->hasRole('superadmin'))
        {
            return "everything working fine";
            return view('admin.dashboard', [
                'active' => 'dashboard',            
                'users' => User::count(),            
                'applications' => Userapplication::count(),            
                'income' => Userapplication::sum('amount'),            
                'messages' => Messages::latest()->take(20)->get(),            
            ]);
        }
        else
        {
            return view('admin.dashboard', [
                'active' => 'dashboard',            
                'today' => Userapplication::where('staff_id', Auth::user()->staff()->first()->id)
                ->whereDate('assign_date', Carbon::now())->count(),            
                'pending' => Userapplication::where('staff_id', Auth::user()->staff()->first()->id)
                ->whereDate('assign_date', Carbon::now())
                ->where('status', '!=', 1)
                ->count(),            
                'complete' => Userapplication::where('staff_id', Auth::user()->staff()->first()->id)
                ->whereDate('assign_date', Carbon::now())
                ->where('status', 1)
                ->count(),            
                'applications' => Userapplication::where('staff_id', $user->staff()->first()->id)
                ->latest()->take(10)->get(),           
            ]);
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
