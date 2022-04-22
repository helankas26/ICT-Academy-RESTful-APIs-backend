<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Http\Requests\StoreParentsRequest;
use App\Http\Requests\UpdateParentsRequest;

class ParentsController extends Controller
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
     * @param  \App\Http\Requests\StoreParentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreParentsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function show(Parents $parents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateParentsRequest  $request
     * @param  \App\Models\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateParentsRequest $request, Parents $parents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parents $parents)
    {
        //
    }
}
