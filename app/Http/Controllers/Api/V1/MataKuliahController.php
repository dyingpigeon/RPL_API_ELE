<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreMataKuliahRequest;
use App\Http\Resources\V1\MataKuliahResource;
use App\Http\Requests\V1\UpdateMataKuliahRequest;

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
     * Store a newly created resource in storage.
     */
    public function store(StoreMataKuliahRequest $request)
    {
        return new MataKuliahResource(MataKuliah::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(MataKuliah $matakuliah)
    {
        return new MataKuliahResource($matakuliah);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMataKuliahRequest $request, MataKuliah $matakuliah)
    {
        $matakuliah->update($request->all());
        return new MataKuliahResource($matakuliah);

        // $matakuliah->update($request->all());

        // // Load ulang data fresh dari database
        // return new MataKuliahResource($matakuliah->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataKuliah $mataKuliah)
    {
        //
    }
}
