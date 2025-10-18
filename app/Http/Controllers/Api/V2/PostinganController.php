<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\PostinganResource;
use App\Http\Requests\V2\StorePostinganRequest;
use App\Http\Requests\V2\UpdatePostinganRequest;
use App\Models\Postingan;
use Illuminate\Http\Request;

class PostinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Postingan::query();

        // Filter untuk exact match
        if ($request->has('dosenId')) {
            $query->where('dosen_id', $request->dosenId);
        }

        if ($request->has('jadwalId')) {
            $query->where('jadwal_id', $request->jadwalId);
        }

        if ($request->has('id')) {
            $query->where('id', $request->id);  // Exact match untuk ID postingan
        }

        // Filter untuk pencarian (gunakan LIKE)
        if ($request->has('caption')) {
            $query->where('caption', 'like', '%' . $request->caption . '%');
        }

        // Filter untuk imageUrl (bisa exact match atau null check)
        if ($request->has('imageUrl')) {
            if ($request->imageUrl === 'null' || $request->imageUrl === '') {
                $query->whereNull('image_url');
            } else {
                $query->where('image_url', 'like', '%' . $request->imageUrl . '%');
            }
        }

        // Filter berdasarkan ada/tidaknya gambar
        if ($request->has('hasImage')) {
            if ($request->hasImage === 'true') {
                $query->whereNotNull('image_url');
            } elseif ($request->hasImage === 'false') {
                $query->whereNull('image_url');
            }
        }

        // Filter berdasarkan tanggal created_at
        if ($request->has('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->has('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        // Default sorting by latest
        $query->orderBy('created_at', 'desc');

        return PostinganResource::collection($query->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostinganRequest $request)
    {
        return new PostinganResource(Postingan::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Postingan $postingan)
    {
        return new PostinganResource($postingan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostinganRequest $request, Postingan $postingan)
    {
        $postingan->update($request->all());
        return new PostinganResource($postingan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $postingan = Postingan::findOrFail($id);
        $postingan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Postingan berhasil dihapus',
        ], 200);
    }
}