<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submisi extends Model
{
    /** @use HasFactory<\Database\Factories\SubmisiFactory> */
    use HasFactory;


    protected $fillable = [
        'tugas_id',
        'mahasiswa_id',
        'file_url',
        'komentar',
        'selesai',
        'nilai',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

}
