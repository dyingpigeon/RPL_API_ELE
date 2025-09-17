<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Mahasiswa;

class MahasiswaFactory extends Factory
{
    protected $model = Mahasiswa::class;

    public function definition(): array
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);

        return [
            'user_id' => $user->id,
            'nim' => fake()->unique()->numerify('##########'), // 10 digit
            'nama' => $user->name,
            'prodi' => fake()->randomElement(['TI', 'SI', 'DKV', 'Manajemen']),
        ];
    }
}
