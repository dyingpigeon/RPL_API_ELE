<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PostinganResource;
use App\Http\Requests\V1\StorePostinganRequest;
use App\Http\Requests\V1\UpdatePostinganRequest;
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

        // filter berdasarkan dosen_id
        if ($request->has('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        // filter berdasarkan caption (misalnya cari kata dalam caption)
        if ($request->has('caption')) {
            $query->where('caption', 'like', '%' . $request->caption . '%');
        }

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
