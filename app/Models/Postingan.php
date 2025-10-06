<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postingan extends Model
{
    /** @use HasFactory<\Database\Factories\PostinganFactory> */
    use HasFactory;

    protected $fillable = [
        'dosen_id',
        'jadwal_id',
        'caption',
        'image_url',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip', 'nip');
    }
    public function jadwal()
    {
            return $this->belongsTo(Jadwal::class, 'id', 'id');
    }
}
