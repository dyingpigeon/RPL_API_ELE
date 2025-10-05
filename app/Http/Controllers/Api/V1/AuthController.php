<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DosenResource;
use App\Http\Resources\V1\MahasiswaResource;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Register user baru TANPA verifikasi email dan TANPA token
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:20|confirmed',
            'role' => 'required|in:admin,mahasiswa,dosen',
        ]);

        // Buat user baru dengan email_verified_at = null
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'email_verified_at' => null, // ← Belum terverifikasi
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'remember_token' => Str::random(10),
        ]);

        // Buat data tambahan berdasarkan role
        switch ($user->role) {
            case 'mahasiswa':
                Mahasiswa::create([
                    'user_id' => $user->id,
                    'nama' => $user->name,
                ]);
                break;

            case 'dosen':
                Dosen::create([
                    'user_id' => $user->id,
                    'nama' => $user->name,
                ]);
                break;
        }

        // Ambil data tambahan berdasarkan role (jika perlu di response)
        // $extraData = null;
        // if ($user->role === 'mahasiswa' && $user->mahasiswa) {
        //     $extraData = new MahasiswaResource($user->mahasiswa);
        // } elseif ($user->role === 'dosen' && $user->dosen) {
        //     $extraData = new DosenResource($user->dosen);
        // }

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil. Silakan login dan verifikasi email Anda.',
            // 'data' => [
            //     'user' => [
            //         'id' => $user->id,
            //         'name' => $user->name,
            //         'email' => $user->email,
            //         'role' => $user->role,
            //         'email_verified' => false,
            //     ],
            //     $user->role => $extraData,
            // ]
        ], 201);
    }

    /**
     * Login user 
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Cek user
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        // Ambil relasi data tambahan
        $extraData = null;
        if ($user->role === 'mahasiswa' && $user->mahasiswa) {
            $extraData = new MahasiswaResource($user->mahasiswa);
        } elseif ($user->role === 'dosen' && $user->dosen) {
            $extraData = new DosenResource($user->dosen);
        }

        // Tentukan status verifikasi
        $isVerified = !is_null($user->email_verified_at);

        // GENERATE TOKEN 
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => $isVerified ? 'Login berhasil' : 'Login berhasil. Silakan verifikasi email Anda.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'email_verified' => $isVerified,
                ],
                $user->role => $extraData,
                'token' => $token, 
            ]
        ]);
    }
}