<?php
// database/factories/UserFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['admin', 'mahasiswa', 'dosen']),
            'photo' => $this->faker->optional(0.3)->passthrough('users/' . Str::random(10) . '.jpg'), // 30% chance punya foto
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    // State untuk user dengan foto
    public function withPhoto(): static
    {
        return $this->state(fn (array $attributes) => [
            'photo' => 'users/' . Str::random(10) . '.jpg',
        ]);
    }
}