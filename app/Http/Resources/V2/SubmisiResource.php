<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmisiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tugasId' => $this->tugas_id,
            'mahasiswaId' => $this->mahasiswa_id,
            'fileUrl' => $this->file_url, // path file di storage
            'file_url' => $this->file_url ? asset('storage/' . $this->file_url) : null, // full URL seperti photo_url
            'komentar' => $this->komentar ?? null,
            'selesai' => (bool) $this->selesai,
            'nilai' => $this->nilai ?? null,
            'submittedAt' => $this->created_at?->toISOString(),
            'updatedAt' => $this->updated_at?->toISOString(),
        ];
    }
}
