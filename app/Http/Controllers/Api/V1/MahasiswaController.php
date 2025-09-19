<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\MahasiswaResource;
use App\Models\Mahasiswa;
use App\Http\Requests\V1\StoreMahasiswaRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMahasiswaRequest;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Mahasiswa::query();

        // filter berdasarkan nama
        if ($request->has('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        if ($request->has('prodi')) {
            $query->where('prodi', 'like', '%' . $request->prodi . '%');
        }

        // filter berdasarkan nim
        if ($request->has('nim')) {
            $query->where('nim', $request->nim);
        }

        return MahasiswaResource::collection($query->paginate(10));// return semua hasil
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
    public function store(StoreMahasiswaRequest $request)
    {
        return new MahasiswaResource(Mahasiswa::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return new MahasiswaResource($mahasiswa);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        //
    }
}
