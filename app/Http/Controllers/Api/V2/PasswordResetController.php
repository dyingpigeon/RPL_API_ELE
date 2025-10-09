<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function forgot(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan'
            ], 404);
        }

        // Buat token random 6 digit
        $token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan ke tabel password_resets
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        try {
            // Kirim token ke email
            Mail::to($request->email)->send(
                new PasswordResetMail($token, $user->name)
            );

            return response()->json([
                'success' => true,
                'message' => 'Kode verifikasi telah dikirim ke email Anda',
                'data' => [
                    'email' => $request->email,
                    'expires_in' => 60 // menit
                ]
            ], 200);

        } catch (\Exception $e) {
            // Hapus token jika gagal kirim email
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim kode verifikasi ke email',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string|size:6',
            'password' => 'required|min:6|confirmed',
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return response()->json([
                'success' => false,
                'message' => 'Kode verifikasi tidak valid atau telah kedaluwarsa'
            ], 400);
        }

        // Cek apakah token sudah expired (1 jam)
        $tokenCreatedAt = Carbon::parse($reset->created_at);
        if ($tokenCreatedAt->diffInMinutes(Carbon::now()) > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            
            return response()->json([
                'success' => false,
                'message' => 'Kode verifikasi telah kedaluwarsa'
            ], 400);
        }

        // Update password user
        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        // Hapus token setelah digunakan
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil direset'
        ], 200);
    }

    /**
     * Resend password reset token (opsional)
     */
    public function resendToken(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        return $this->forgot($request);
    }
}