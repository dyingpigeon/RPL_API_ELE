<?php
// app/Http/Controllers/Api/V1/VerificationController.php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /**
     * Kirim kode verifikasi ke email user
     */
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Cek apakah user exists
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        // Cek apakah email sudah terverifikasi
        if ($user->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah terverifikasi'
            ], 400);
        }

        // Generate kode 6 digit
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Simpan kode di cache selama 10 menit
        $cacheKey = 'verification_code_' . $request->email;
        Cache::put($cacheKey, $code, 600); // 10 menit

        try {
            // Kirim email
            Mail::to($request->email)->send(
                new VerificationCodeMail($code, $user->name)
            );

            return response()->json([
                'success' => true,
                'message' => 'Kode verifikasi telah dikirim ke email Anda',
                'data' => [
                    'email' => $request->email,
                    'expires_in' => 10 // menit
                ]
            ], 200);

        } catch (\Exception $e) {
            // Hapus kode dari cache jika gagal kirim email
            Cache::forget($cacheKey);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim kode verifikasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verifikasi kode dan update user
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6'
        ]);

        $cacheKey = 'verification_code_' . $request->email;
        $cachedCode = Cache::get($cacheKey);

        if (!$cachedCode) {
            return response()->json([
                'success' => false,
                'message' => 'Kode verifikasi tidak ditemukan atau telah kedaluwarsa'
            ], 400);
        }

        if ($cachedCode !== $request->code) {
            return response()->json([
                'success' => false,
                'message' => 'Kode verifikasi tidak valid'
            ], 400);
        }

        // Update user - set email_verified_at
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $user->update([
            'email_verified_at' => now()
        ]);

        // Hapus kode dari cache setelah berhasil verifikasi
        Cache::forget($cacheKey);

        return response()->json([
            'success' => true,
            'message' => 'Email berhasil diverifikasi',
            'data' => [
                'email' => $user->email,
                'email_verified' => true,
                'verified_at' => $user->email_verified_at
            ]
        ]);
    }

    /**
     * Kirim ulang kode verifikasi
     */
    public function resendVerificationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        return $this->sendVerificationCode($request);
    }
}