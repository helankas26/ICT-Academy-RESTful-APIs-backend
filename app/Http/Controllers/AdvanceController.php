<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Http\Requests\StoreAdvanceRequest;
use App\Http\Requests\UpdateAdvanceRequest;

class AdvanceController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdvanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdvanceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advance  $advance
     * @return \Illuminate\Http\Response
     */
    public function show(Advance $advance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdvanceRequest  $request
     * @param  \App\Models\Advance  $advance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdvanceRequest $request, Advance $advance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advance  $advance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advance $advance)
    {
        //
    }
}
