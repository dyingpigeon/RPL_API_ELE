<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DosenResource;
use App\Http\Resources\V1\MahasiswaResource;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Register user baru
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:20|confirmed',
            'role' => 'required|in:admin,mahasiswa,dosen',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'email_verified_at' => now(),
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'remember_token' => Str::random(10),
        ]);

        // Buat data tambahan berdasarkan role
        switch ($user->role) {
            case 'mahasiswa':
                \App\Models\Mahasiswa::create([
                    'user_id' => $user->id,
                    'nama' => $user->name,
                ]);
                break;

            case 'dosen':
                \App\Models\Dosen::create([
                    'user_id' => $user->id,
                    'nama' => $user->name,
                ]);
                break;
        }

        return response()->json([
            'message' => 'User registered successfully',
            'user' => new UserResource($user),
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
                'message' => 'Invalid credentials'
            ], 401);
        }

        // // Untuk API biasanya bikin token (contoh pakai sanctum)
        // $token = $user->createToken('auth_token')->plainTextToken;

        // return response()->json([
        //     'message' => 'Login success',
        //     'user' => new UserResource($user),
        //     'token' => $token,
        // ]);

        // ambil relasi data tambahan
        $extraData = null;
        if ($user->role === 'mahasiswa' && $user->mahasiswa) {
            $extraData = new MahasiswaResource($user->mahasiswa);
        } elseif ($user->role === 'dosen' && $user->dosen) {
            $extraData = new DosenResource($user->dosen);
        }

        return response()->json([
            'message' => 'Login success',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            $user->role => $extraData, // kunci JSON otomatis "mahasiswa" / "dosen"
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);

    }
}
