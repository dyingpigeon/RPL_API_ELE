<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Submisi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V2\StoreSubmisiRequest;
use App\Http\Requests\V2\UpdateSubmisiRequest;
use App\Http\Resources\V2\SubmisiResource;
use Illuminate\Support\Facades\Storage;


class SubmisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Submisi::query();

        // filter berdasarkan mahasiswa_id
        if ($request->has('mahasiswaId')) {
            $query->where('mahasiswa_id', $request->mahasiswa_id);
        }

        // filter berdasarkan tugas_id
        if ($request->has('tugasId')) {
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
    // Di Controller untuk store method
    public function store(UpdateSubmisiRequest $request) // atau buat Request khusus untuk store
    {
        $data = $request->validated();

        if ($request->hasFile('fileUrl')) {
            $file = $request->file('fileUrl');
            $extension = $file->getClientOriginalExtension();
            $timestamp = time();

            $fileName = 'T' . $data['tugas_id'] . '_M' . $data['mahasiswa_id'] . '_' . $timestamp . '.' . $extension;

            $path = $file->storeAs('submissions', $fileName, 'public');
            $data['file_url'] = $path;

            unset($data['fileUrl']);
        }

        $submisi = Submisi::create($data);

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
    // public function update(UpdateSubmisiRequest $request, Submisi $submisi)
    // {
    //     $submisi->update($request->validated());
    //     return new SubmisiResource($submisi);
    // }

    // public function update(UpdateSubmisiRequest $request, Submisi $submisi)
    // {
    //     $data = $request->validated();

    //     if ($request->hasFile('submission')) {
    //         // Hapus file lama jika ada
    //         if ($submisi->file_url && Storage::disk('public')->exists($submisi->file_url)) {
    //             Storage::disk('public')->delete($submisi->file_url);
    //         }

    //         $extension = $request->file('submission')->getClientOriginalExtension();
    //         $timestamp = time();

    //         // Format: T{tugas_id}_M{mahasiswa_id}_{timestamp}.{ext}
    //         $fileName = 'T' . $submisi->tugas_id . '_M' . $submisi->mahasiswa_id . '_' . $timestamp . '.' . $extension;

    //         $path = $request->file('submission')->storeAs('submissions', $fileName, 'public');
    //         $data['file_url'] = $path;
    //     }

    //     $submisi->update($data);

    //     return new SubmisiResource($submisi);
    // }

    // public function update(UpdateSubmisiRequest $request, Submisi $submisi)
    // {
    //     $data = $request->validated();

    //     if ($request->hasFile('submission')) {
    //         // Hapus file lama jika ada
    //         if ($submisi->file_url && Storage::disk('public')->exists($submisi->file_url)) {
    //             Storage::disk('public')->delete($submisi->file_url);
    //         }

    //         $file = $request->file('submission');
    //         $extension = $file->getClientOriginalExtension();
    //         $timestamp = time();

    //         // Format: T{tugas_id}_M{mahasiswa_id}_{timestamp}.{ext}
    //         $fileName = 'T' . $submisi->tugas_id . '_M' . $submisi->mahasiswa_id . '_' . $timestamp . '.' . $extension;

    //         $path = $file->storeAs('submissions', $fileName, 'public');
    //         $data['file_url'] = $path; // Simpan path ke kolom file_url
    //     }

    //     $submisi->update($data);

    //     return new SubmisiResource($submisi);
    // }

    public function update(UpdateSubmisiRequest $request, Submisi $submisi)
    {
        $data = $request->validated();

        if ($request->hasFile('fileUrl')) {
            // Hapus file lama jika ada
            if ($submisi->file_url && Storage::disk('public')->exists($submisi->file_url)) {
                Storage::disk('public')->delete($submisi->file_url);
            }

            $extension = $request->file('fileUrl')->getClientOriginalExtension();
            $timestamp = time();

            // Format: T{tugas_id}_M{mahasiswa_id}_{timestamp}.{ext}
            $fileName = 'T' . $submisi->tugas_id . '_M' . $submisi->mahasiswa_id . '_' . $timestamp . '.' . $extension;

            $path = $request->file('fileUrl')->storeAs('submissions', $fileName, 'public');
            $data['file_url'] = $path;
        }

        $submisi->update($data);

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
