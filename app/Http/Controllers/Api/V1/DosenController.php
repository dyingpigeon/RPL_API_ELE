<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Dosen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDosenRequest;
use App\Http\Resources\V1\DosenResource;
use App\Http\Requests\V1\UpdateDosenRequest;


class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Dosen::query();

        // filter berdasarkan nama
        if ($request->has('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        // filter berdasarkan nim
        if ($request->has('nip')) {
            $query->where('nip', $request->nip);
        }

        return DosenResource::collection($query->paginate(10));// return semua hasil
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
        return new DosenResource($dosen);
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
        $dosen->update($request->all());
        return new DosenResource($dosen);
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
