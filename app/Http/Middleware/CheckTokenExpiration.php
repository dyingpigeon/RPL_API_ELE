<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiration
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Jika tidak ada user, lanjutkan (biarkan auth:sanctum handle)
        if (!$user) {
            return $next($request);
        }

        $token = $user->currentAccessToken();
        
        // Cek jika token expired
        if ($token->expires_at && $token->expires_at->isPast()) {
            $token->delete();
            return response()->json([
                'success' => false,
                'message' => 'Token expired'
            ], 401);
        }

        // Auto refresh jika hampir expired (kurang dari 30 menit)
        if ($token->expires_at && $token->expires_at->diffInMinutes(Carbon::now()) < 30) {
            // Buat token baru
            $newToken = $user->createToken(
                'auth_token',
                ['*'],
                Carbon::now()->addHours(3)
            )->plainTextToken;

            // Hapus token lama
            $token->delete();

            // Tambahkan header token baru
            $response = $next($request);
            $response->headers->set('X-New-Token', $newToken);
            $response->headers->set('X-Token-Expires-At', Carbon::now()->addHours(3)->toDateTimeString());
            
            return $response;
        }

        return $next($request);
    }
}