<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    /** @use HasFactory<\Database\Factories\JadwalFactory> */
    use HasFactory;

        protected $fillable = [
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'id_dosen',
        'id_matkul',
        'semester',
        'kelas',
    ];

    public function dosen()
{
    return $this->belongsTo(Dosen::class, 'nip', 'nip');
}

public function mataKuliah()
{
    return $this->belongsTo(MataKuliah::class, 'id_matkul', 'id_matkul');
}
}
