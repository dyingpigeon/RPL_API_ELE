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
        // Ambil user dengan role mahasiswa, kalau belum ada maka buat baru
        $user = User::inRandomOrder()->where('role', 'mahasiswa')->first()
            ?? User::factory()->create(['role' => 'mahasiswa']);

        // Pilih prodi
        $prodi = $this->faker->randomElement(['TRSE', 'TI', 'TL']);

        // Mapping nomor prodi
        $nomorProdiMap = [
            'TRSE' => '35',
            'TI' => '16',
            'TL' => '03',
        ];
        $nomorProdi = $nomorProdiMap[$prodi];

        // Tentukan diploma
        $diploma = ($prodi === 'TRSE') ? '4' : '3'; // D4 untuk TRSE, D3 untuk TI/TL

        // Tahun masuk (2021 sampai sekarang)
        $tahunMasuk = $this->faker->numberBetween(2021, (int) date('Y'));

        // 3 digit random
        $random3 = str_pad($this->faker->numberBetween(0, 999), 3, '0', STR_PAD_LEFT);

        // Bentuk NIM: diploma + tahun masuk + nomor prodi + random
        $nim = $diploma . $tahunMasuk . $nomorProdi . $random3;

        return [
            'user_id' => $user->id,
            'nama' => $user->name,
            'prodi' => $prodi,
            'diploma' => 'D' . $diploma,
            'tahun_masuk' => $tahunMasuk,
            'nomor_prodi' => (int) $nomorProdi,
            'nim' => $nim,
            'kelas' => fake()->randomElement(['A','B','C','D','E']),
        ];
    }
}
