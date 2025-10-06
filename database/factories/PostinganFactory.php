<?php

namespace Database\Factories;

use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Postingan;
use App\Models\Dosen;

class PostinganFactory extends Factory
{
    protected $model = Postingan::class;

    public function definition(): array
    {
        $dosen = Dosen::inRandomOrder()->first() ?? Dosen::factory()->create();
        $jadwal = Jadwal::inRandomOrder()->first() ?? Jadwal::factory()->create();

        return [
            'dosen_id' => $dosen->id,
            'jadwal_id' => $jadwal->id,
            'caption' => fake()->sentence(10),
            'image_url' => fake()->optional()->imageUrl(640, 480, 'education', true),
        ];
    }
}
