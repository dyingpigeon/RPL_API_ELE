<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Dosen;

class DosenFactory extends Factory
{
    protected $model = Dosen::class;

    public function definition(): array
    {
        $user = User::factory()->create(['role' => 'dosen']);

        return [
            'user_id' => $user->id,
            'nip' => fake()->unique()->numerify('##########'),
            'nama' => $user->name,
        ];
    }
}
