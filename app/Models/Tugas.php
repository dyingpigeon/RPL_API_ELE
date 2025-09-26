<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_id',
        'jadwal_id',
        'judul',
        'deskripsi',
        'file_url',
        'deadline',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
    public function submisi()
    {
        return $this->hasMany(Submisi::class);
    }
}
