<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreMataKuliahRequest;
use App\Http\Resources\V1\MataKuliahResource;
use App\Http\Requests\UpdateMataKuliahRequest;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MataKuliah::query();

        // filter berdasarkan nama
        if ($request->has('matkul')) {
            $query->where('mata_kuliah', 'like', '%' . $request->matkul . '%');
        }

        return MataKuliahResource::collection($query->paginate(10));// return semua hasil
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
    public function store(StoreMataKuliahRequest $request)
    {
        return new MataKuliahResource(MataKuliah::created($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(MataKuliah $matakuliah)
    {
        return new MataKuliahResource($matakuliah);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MataKuliah $mataKuliah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMataKuliahRequest $request, MataKuliah $mataKuliah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataKuliah $mataKuliah)
    {
        //
    }
}
