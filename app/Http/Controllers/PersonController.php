<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;

class PersonController extends Controller
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
     * @param  \App\Http\Requests\StorePersonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePersonRequest  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonRequest $request, Person $person)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        //
    }
}
