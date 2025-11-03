<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostinganResource extends JsonResource
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
            'dosenId' => $this->dosen_id,      // foreign key ke dosen
            'jadwalId' => $this->jadwal_id,    // foreign key ke jadwal
            'caption' => $this->caption ?? null,
            'imageUrl' => $this->image_url ?? null,
            'createdAt' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updatedAt' => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
        ];
    }
}
