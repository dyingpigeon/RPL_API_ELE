<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    /** @use HasFactory<\Database\Factories\MahasiswaFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nim',
        'nama',
        'prodi',
        'diploma',
        'tahun_masuk',
        'nomor_prodi',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function submisi()
    {
        return $this->hasMany(Submisi::class);
    }


}
