<?php

namespace App\Http\Controllers\Api;

use App\Models\Pilihan;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePilihanRequest;
use App\Http\Requests\UpdatePilihanRequest;

class PilihanController extends Controller
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
     * @param  \App\Http\Requests\StorePilihanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePilihanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pilihan  $pilihan
     * @return \Illuminate\Http\Response
     */
    public function show(Pilihan $pilihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pilihan  $pilihan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pilihan $pilihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePilihanRequest  $request
     * @param  \App\Models\Pilihan  $pilihan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePilihanRequest $request, Pilihan $pilihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pilihan  $pilihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pilihan $pilihan)
    {
        //
    }
}
