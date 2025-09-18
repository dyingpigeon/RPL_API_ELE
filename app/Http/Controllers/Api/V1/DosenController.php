<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Dosen;
use App\Http\Requests\StoreDosenRequest;
use App\Http\Requests\UpdateDosenRequest;
use App\Http\Controllers\Controller;
use PhpParser\Node\Stmt\Return_;


class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Dosen::all();
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
    public function store(StoreDosenRequest $request)
    {
        $dosen = Dosen::create($request->validated());
        return response()->json($dosen, 201);
    }

    /**
     * Display the specified resource.
     */
public function show(Dosen $dosen)
{
    return response()->json($dosen);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dosen $dosen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
public function update(UpdateDosenRequest $request, Dosen $dosen)
{
    $dosen->update($request->validated());
    return response()->json($dosen);
}
    /**
     * Remove the specified resource from storage.
     */
public function destroy(Dosen $dosen)
{
    $dosen->delete();
    return response()->json(null, 204);
}
}
