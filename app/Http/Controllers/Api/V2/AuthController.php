<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\DosenResource;
use App\Http\Resources\V2\MahasiswaResource;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Carbon\Carbon;
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
    // public function login(Request $request)
    // {
    //     // Validasi input
    //     $credentials = $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);

    //     // Cek user
    //     $user = User::where('email', $credentials['email'])->first();

    //     if (!$user || !Hash::check($credentials['password'], $user->password)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Email atau password salah'
    //         ], 401);
    //     }

    //     // Ambil relasi data tambahan
    //     $extraData = null;
    //     if ($user->role === 'mahasiswa' && $user->mahasiswa) {
    //         $extraData = new MahasiswaResource($user->mahasiswa);
    //     } elseif ($user->role === 'dosen' && $user->dosen) {
    //         $extraData = new DosenResource($user->dosen);
    //     }

    //     // Tentukan status verifikasi
    //     $isVerified = !is_null($user->email_verified_at);

    //     // GENERATE TOKEN 
    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'success' => true,
    //         'message' => $isVerified ? 'Login berhasil' : 'Login berhasil. Silakan verifikasi email Anda.',
    //         'data' => [
    //             'user' => [
    //                 'id' => $user->id,
    //                 'name' => $user->name,
    //                 'email' => $user->email,
    //                 'role' => $user->role,
    //                 'email_verified' => $isVerified,
    //             ],
    //             $user->role => $extraData,
    //             'token' => $token, 
    //         ]
    //     ]);
    // }

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

        // GENERATE TOKEN dengan expiration 3 jam
        $token = $user->createToken(
            'auth_token',
            ['*'], // abilities
            Carbon::now()->addHours(3) // expires_at
        )->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => $isVerified ? 'Login berhasil' : 'Login berhasil. Silakan verifikasi email Anda.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'photoUrl' => $user->photo,
                    'email_verified' => $isVerified,
                ],
                $user->role => $extraData,
                'token' => $token,
                'token_expires_at' => Carbon::now()->addHours(3)->toDateTimeString(), // informasi kapan token expired
            ]
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    public function refresh(Request $request)
    {
        // Hapus token lama
        $request->user()->currentAccessToken()->delete();

        // Buat token baru
        $token = $request->user()->createToken(
            'auth_token',
            ['*'],
            Carbon::now()->addHours(3)
        )->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Token refreshed',
            'data' => [
                'token' => $token,
                'token_expires_at' => Carbon::now()->addHours(3)->toDateTimeString(),
            ]
        ]);
    }

    public function checkToken(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid'
            ], 401);
        }

        $token = $user->currentAccessToken();

        // Cek apakah token expired
        $isExpired = $token->expires_at && $token->expires_at->isPast();

        if ($isExpired) {
            $token->delete();
            return response()->json([
                'success' => false,
                'message' => 'Token telah expired'
            ], 401);
        }

        // Ambil relasi data tambahan
        $extraData = null;
        if ($user->role === 'mahasiswa' && $user->mahasiswa) {
            $extraData = new MahasiswaResource($user->mahasiswa);
        } elseif ($user->role === 'dosen' && $user->dosen) {
            $extraData = new DosenResource($user->dosen);
        }

        $isVerified = !is_null($user->email_verified_at);

        // Cek jika ada token baru di header (dari middleware)
        $newToken = $request->headers->get('X-New-Token');
        $newTokenExpires = $request->headers->get('X-Token-Expires-At');

        $responseData = [
            'success' => true,
            'message' => 'Token valid - Auto login berhasil',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'photoUrl' => $user->photo_url,
                    'email_verified' => $isVerified,
                ],
                $user->role => $extraData,
                'token' => $newToken ?: $request->bearerToken(), // Prioritaskan token baru
                'token_expires_at' => $newTokenExpires ?: $token->expires_at?->toDateTimeString(),
            ]
        ];

        // Jika ada token baru, tambahkan pesan
        if ($newToken) {
            $responseData['message'] = 'Token valid - Auto login berhasil (token refreshed)';
        }

        return response()->json($responseData);
    }
}