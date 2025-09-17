<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MataKuliah;

class MataKuliahFactory extends Factory
{
    protected $model = MataKuliah::class;

    public function definition(): array
    {
        return [
            'mata_kuliah' => fake()->words(3, true),
            'sks' => fake()->numberBetween(2, 4),
        ];
    }
}
