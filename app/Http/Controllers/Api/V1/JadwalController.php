<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreJadwalRequest;
use App\Http\Resources\V1\JadwalResource;
use App\Http\Requests\V1\UpdateJadwalRequest;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Jadwal::query();

        // Filter untuk pencarian (gunakan LIKE)
        if ($request->has('hari')) {
            $query->where('hari', 'like', '%' . $request->hari . '%');
        }

        if ($request->has('jamMulai')) {
            $query->where('jam_mulai', 'like', '%' . $request->jamMulai . '%');
        }

        if ($request->has('jamSelesai')) {
            $query->where('jam_selesai', 'like', '%' . $request->jamSelesai . '%');
        }

        if ($request->has('ruangan')) {
            $query->where('ruangan', 'like', '%' . $request->ruangan . '%');
        }

        // Filter untuk exact match (gunakan = bukan LIKE)
        if ($request->has('dosen')) {
            $query->where('id_dosen', $request->dosen);  // Exact match
        }

        if ($request->has('matkul')) {
            $query->where('id_matkul', $request->matkul);  // Exact match
        }

        if ($request->has('semester')) {
            $query->where('semester', $request->semester);  // Exact match
        }

        if ($request->has('kelas')) {
            $query->where('kelas', $request->kelas);  // Exact match
        }

        if ($request->has('prodi')) {
            $query->where('prodi', $request->prodi);  // Exact match
        }

        // filter berdasarkan nim
        if ($request->has('nim')) {
            $query->where('nim', $request->nim);
        }

        return JadwalResource::collection($query->paginate(10));
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
    public function store(StoreJadwalRequest $request)
    {
        return new JadwalResource(Jadwal::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        return new JadwalResource($jadwal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJadwalRequest $request, Jadwal $jadwal)
    {
        $jadwal->update($request->all());
        return new JadwalResource($jadwal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dihapus',
        ], 200);
    }
}
