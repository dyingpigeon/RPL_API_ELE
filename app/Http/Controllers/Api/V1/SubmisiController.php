<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Submisi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreSubmisiRequest;
use App\Http\Requests\V1\UpdateSubmisiRequest;
use App\Http\Resources\V1\SubmisiResource;

class SubmisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Submisi::query();

        // filter berdasarkan mahasiswa_id
        if ($request->has('mahasiswa_id')) {
            $query->where('mahasiswa_id', $request->mahasiswa_id);
        }

        // filter berdasarkan tugas_id
        if ($request->has('tugas_id')) {
            $query->where('tugas_id', $request->tugas_id);
        }

        // filter berdasarkan nilai (misalnya >= nilai tertentu)
        if ($request->has('min_nilai')) {
            $query->where('nilai', '>=', $request->min_nilai);
        }

        if ($request->has('max_nilai')) {
            $query->where('nilai', '<=', $request->max_nilai);
        }

        // filter berdasarkan tanggal submit
        if ($request->has('submitted_after')) {
            $query->where('submitted_at', '>=', $request->submitted_after);
        }

        if ($request->has('submitted_before')) {
            $query->where('submitted_at', '<=', $request->submitted_before);
        }

        return SubmisiResource::collection($query->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubmisiRequest $request)
    {
        $submisi = Submisi::create($request->validated());
        return new SubmisiResource($submisi);
    }

    /**
     * Display the specified resource.
     */
    public function show(Submisi $submisi)
    {
        return new SubmisiResource($submisi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubmisiRequest $request, Submisi $submisi)
    {
        $submisi->update($request->validated());
        return new SubmisiResource($submisi);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $submisi = Submisi::findOrFail($id);
        $submisi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Submisi berhasil dihapus',
        ], 200);
    }
}
