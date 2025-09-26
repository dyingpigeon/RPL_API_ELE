<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Postingan;
use App\Models\Dosen;

class PostinganFactory extends Factory
{
    protected $model = Postingan::class;

    public function definition(): array
    {
        $dosen = Dosen::inRandomOrder()->first() ?? Dosen::factory()->create();

        return [
            'dosen_id' => $dosen->id,
            'caption' => fake()->sentence(10),
            'image_url' => fake()->optional()->imageUrl(640, 480, 'education', true),
        ];
    }
}
