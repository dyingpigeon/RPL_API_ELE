<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TugasResource extends JsonResource
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
            'jadwalId' => $this->jadwal_id,
            'dosenId' => $this->dosen_id,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi ?? null,
            'fileUrl' => $this->file_url ?? null,
            'deadline' => $this->deadline ?? null,
            'createdAt' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updatedAt' => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
        ];
    }
}
