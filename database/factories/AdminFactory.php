<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Admin;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition(): array
    {
        // Buat user baru dengan role admin
        $user = User::factory()->create(['role' => 'admin']);

        return [
            'user_id' => $user->id,
            'nama' => $user->name,
        ];
    }
}
