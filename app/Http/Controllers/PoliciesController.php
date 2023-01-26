<?php

namespace App\Http\Controllers;

use App\Models\Policies;
use Illuminate\Http\Request;

class PoliciesController extends Controller
{
    function __construct()
    {
        // set permission
        $this->middleware('permission:update-policy');
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
     * @param  \App\Models\Policies  $policies
     * @return \Illuminate\Http\Response
     */
    public function show(Policies $policies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Policies  $policies
     * @return \Illuminate\Http\Response
     */
    public function edit(Policies $policies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Policies  $policies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Policies $policies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Policies  $policies
     * @return \Illuminate\Http\Response
     */
    public function destroy(Policies $policies)
    {
        //
    }
}
