<?php

namespace App\Models;
// adding small changes

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    /** @use HasFactory<\Database\Factories\AdminFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
