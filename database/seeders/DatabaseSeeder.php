<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
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
            'name' => 'farhan',
            'email' => 'the.farhanad123@gmail.com',
            'role' => 'mahasiswa',
            'password' => 'jdmjdmjdm', // tambahkan password
        ]);
        User::factory()->create([
            'name' => 'farhan dosen',
            'email' => 'daheknigg@gmail.com',
            'role' => 'dosen',
            'password' => 'jdmjdmjdm', // tambahkan password
        ]);
        User::factory()->create([
            'name' => 'harik',
            'role' => 'mahasiswa',
            'email' => 'levyh.k98@gmail.com',
            'password' => 'mieayam9', // tambahkan password
        ]);
        User::factory()->create([
            'name' => 'tito',
            'role' => 'mahasiswa',
            'email' => 'alexonana619@gmail.com',
            'password' => 'alexxalexx', // tambahkan password
        ]);

        // Tambah user manual lain (tanpa factory)
        // User::create([
        //     'name' => 'admin kedua',
        //     'email' => 'admin2@example.com',
        //     'password' => Hash::make('secret456'),
        // ]);

        User::factory(50)->create();
        \App\Models\Admin::factory(2)->create();
        \App\Models\Mahasiswa::factory(30)->create();
        \App\Models\Dosen::factory(28)->create();
        \App\Models\MataKuliah::factory(20)->create();
        \App\Models\Jadwal::factory(20)->create();
        \App\Models\Postingan::factory(150)->create();
        \App\Models\Tugas::factory(20)->create();
        \App\Models\Submisi::factory(20)->create();
    }
}
