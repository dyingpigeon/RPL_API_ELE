<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Tugas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTugasRequest;
use App\Http\Requests\V1\UpdateTugasRequest;
use App\Http\Resources\V1\TugasResource;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tugas::query();

        // filter berdasarkan dosen
        if ($request->has('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        // filter berdasarkan jadwal
        if ($request->has('jadwal_id')) {
            $query->where('jadwal_id', $request->jadwal_id);
        }

        // filter berdasarkan judul (cari sebagian kata)
        if ($request->has('judul')) {
            $query->where('judul', 'like', '%' . $request->judul . '%');
        }

        // filter berdasarkan deadline sebelum/sesudah
        if ($request->has('deadline_before')) {
            $query->where('deadline', '<=', $request->deadline_before);
        }

        if ($request->has('deadline_after')) {
            $query->where('deadline', '>=', $request->deadline_after);
        }

        return TugasResource::collection($query->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTugasRequest $request)
    {
        $tugas = Tugas::create($request->validated());
        return new TugasResource($tugas);
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
