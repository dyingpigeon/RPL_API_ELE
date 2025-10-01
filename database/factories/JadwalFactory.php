<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Jadwal;
use App\Models\Dosen;
use App\Models\MataKuliah;

class JadwalFactory extends Factory
{
    protected $model = Jadwal::class;

    public function definition(): array
    {
        $dosen = Dosen::inRandomOrder()->first() ?? Dosen::factory()->create();
        $matkul = MataKuliah::inRandomOrder()->first() ?? MataKuliah::factory()->create();

        return [
            'hari' => fake()->randomElement(['senin','selasa','rabu','kamis','jumat']),
            'jam_mulai' => fake()->time('H:i', '08:00'),
            'jam_selesai' => fake()->time('H:i', '10:00'),
            'ruangan' => fake()->bothify('R-###'),
            'id_dosen' => $dosen->id,
            'id_matkul' => $matkul->id,
            'semester' => fake()->numberBetween(1, 8),
            'kelas' => fake()->randomElement(['A','B','C','D','E']),
        ];
    }
}
