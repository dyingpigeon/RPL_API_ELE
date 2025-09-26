<?php

namespace App\Http\Resources\V1;

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
            'dosenId' => $this->dosen_id,  // foreign key ke dosen
            'caption' => $this->caption ?? null,
            'imageUrl' => $this->image_url ?? null,
        ];
    }
}
