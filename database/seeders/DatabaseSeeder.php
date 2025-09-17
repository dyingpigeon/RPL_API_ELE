<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

            \App\Models\User::factory(18)->create();
            \App\Models\Admin::factory(3)->create();
            \App\Models\Mahasiswa::factory(10)->create();
            \App\Models\Dosen::factory(5)->create();
            \App\Models\MataKuliah::factory(10)->create();
            \App\Models\Jadwal::factory(20)->create();
    }
}
