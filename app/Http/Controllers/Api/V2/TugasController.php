<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Tugas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V2\StoreTugasRequest;
use App\Http\Requests\V2\UpdateTugasRequest;
use App\Http\Resources\V2\TugasResource;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tugas::query();

        // Join dengan jadwal untuk filter
        if ($request->has('kelas') || $request->has('prodi') || $request->has('semester')) {
            $query->join('jadwals', 'tugas.jadwal_id', '=', 'jadwals.id');
        }

        // Filter berdasarkan jadwal (EXACT MATCH)
        if ($request->has('kelas')) {
            $query->where('jadwals.kelas', $request->kelas);
        }

        if ($request->has('prodi')) {
            $query->where('jadwals.prodi', $request->prodi);
        }

        if ($request->has('semester')) {
            $query->where('jadwals.semester', $request->semester);
        }

        // Filter lainnya (LIKE untuk pencarian)
        if ($request->has('judul')) {
            $query->where('tugas.judul', 'like', '%' . $request->judul . '%');
        }

        if ($request->has('dosen')) {
            $query->where('tugas.dosen_id', $request->dosen); // Exact match
        }

        // Filter by jadwalId jika ada
        if ($request->has('jadwalId')) {
            $query->where('tugas.jadwal_id', $request->jadwalId);
        }

        // Select specific columns to avoid ambiguity
        $query->select('tugas.*');

        // Debug query (optional)
        \Log::info('Tugas Query: ' . $query->toSql());
        \Log::info('Tugas Parameters: ' . json_encode($query->getBindings()));

        return TugasResource::collection($query->paginate(10));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTugasRequest $request)
    {
        return new TugasResource(Tugas::create($request->all()));
        // Tugas::create($request->validated());
        // return new PostinganResource(Postingan::create($request->all()));

        // return new TugasResource($tugas);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tugas $tugas)
    {
        return new TugasResource($tugas);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTugasRequest $request, Tugas $tugas)
    {
        $tugas->update($request->validated());
        return new TugasResource($tugas);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);
        $tugas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus',
        ], 200);
    }
}
