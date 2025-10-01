<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MahasiswaResource extends JsonResource
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
            // 'userId' => $this->user_id,
            'nim' => $this->nim,
            'nama' => $this->nama,
            'prodi' => $this->prodi,
            'diploma' => $this->diploma ?? null,
            'tahunMasuk' => $this->tahun_masuk ?? null,
            'nomorProdi' => $this->nomor_prodi ?? null,
            'kelas'=> $this->kelas ?? null,
        ];
    }
}
