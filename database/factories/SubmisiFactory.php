<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Submisi;
use App\Models\Mahasiswa;
use App\Models\Tugas;

class SubmisiFactory extends Factory
{
    protected $model = Submisi::class;

    public function definition(): array
    {
        $mahasiswa = Mahasiswa::inRandomOrder()->first() ?? Mahasiswa::factory()->create();
        $tugas = Tugas::inRandomOrder()->first() ?? Tugas::factory()->create();

        return [
            'tugas_id' => $tugas->id,
            'mahasiswa_id' => $mahasiswa->id,
            'file_url' => $this->faker->filePath(), // file tugas (bisa juga pakai ->url() kalau remote)
            'komentar' => $this->faker->optional()->sentence(),
            'selesai' => $this->faker->boolean(70), // 70% sudah selesai
            'nilai' => $this->faker->optional()->numberBetween(60, 100),
        ];
    }
}
