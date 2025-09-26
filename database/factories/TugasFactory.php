<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tugas;
use App\Models\Dosen;
use App\Models\Jadwal;

class TugasFactory extends Factory
{
    protected $model = Tugas::class;

    public function definition(): array
    {
        // ambil dosen dan jadwal yg sudah ada
        $dosen = Dosen::inRandomOrder()->first() ?? Dosen::factory()->create();
        $jadwal = Jadwal::inRandomOrder()->first() ?? Jadwal::factory()->create();

        return [
            'dosen_id' => $dosen->id,
            'jadwal_id' => $jadwal->id,
            'judul' => fake()->sentence(5),
            'deskripsi' => fake()->paragraph(3),
            'file_url' => fake()->optional()->url(),
            'deadline' => fake()->dateTimeBetween('now', '+2 weeks'),
        ];
    }
}
