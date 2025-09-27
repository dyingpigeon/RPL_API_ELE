<?php

namespace App\Http\Resources\V1;

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
            'fileUrl' => $this->file_url,
            'komentar' => $this->komentar ?? null,
            'selesai' => (bool) $this->selesai, // pastikan keluar boolean
            'nilai' => $this->nilai ?? null,
        ];
    }
}
