<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Krs;
use App\Http\Requests\StoreKrsRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateKrsRequest;

class KrsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Return Krs::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKrsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Krs $krs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Krs $krs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKrsRequest $request, Krs $krs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Krs $krs)
    {
        //
    }
}
