<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JadwalResource extends JsonResource
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
            'jamMulai' => $this->jam_mulai,
            'jamSelesai' => $this->jam_selesai,
            'ruangan' => $this->ruangan,
            'dosenId' => $this->id_dosen,
            'matkulId' => $this->id_matkul,
            'semester' => $this->semester,
            'kelas' => $this->kelas,
        ];
    }
}
