<?php

use App\Http\Controllers\Api\V2\SubmisiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V2\UserController; // TAMBAHKAN INI

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// V1 Routes
Route::group([
    'prefix' => 'v1',
    'namespace' => 'App\Http\Controllers\Api\V1'
], function () {

    // Public routes (tidak butuh auth)
    Route::post('/registrasi', 'AuthController@register');
    Route::post('/login', 'AuthController@login');
    Route::post('/forgot-password', 'PasswordResetController@forgot');
    Route::post('/reset-password', 'PasswordResetController@reset');
    Route::post('/send-verification', 'VerificationController@sendVerificationCode');
    Route::post('/verify-code', 'VerificationController@verifyCode');
    Route::get('/test-time', function () {
        return response()->json([
            'server_time' => now()->toDateTimeString(),
            'timezone' => config('app.timezone'),
            'message' => 'Waktu server sekarang'
        ]);
    });


    // Protected routes (butuh auth dengan token)
    Route::middleware(['auth:sanctum'])->group(function () {
        // Auth management routes
        Route::post('/logout', 'AuthController@logout');
        Route::post('/refresh-token', 'AuthController@refresh');
        Route::get('/check-token', 'AuthController@checkToken');

        // Resource routes
        Route::apiResource('admin', 'AdminController');
        Route::apiResource('dosen', 'DosenController');
        Route::apiResource('jadwal', 'JadwalController');
        Route::apiResource('krs', 'KrsController');
        Route::apiResource('mahasiswa', 'MahasiswaController');
        Route::apiResource('mata-kuliah', 'MataKuliahController');
        Route::apiResource('postingan', 'PostinganController');
        Route::apiResource('tugas', 'TugasController');
        Route::apiResource('submisi', 'SubmisiController');
        Route::apiResource('user', 'UserController');
    });

});

// V2 Routes - GUNAKAN SYNTAX MODERN
Route::group([
    'prefix' => 'v2',
    'namespace' => 'App\Http\Controllers\Api\V2'
], function () {

    // Public routes (tidak butuh auth)
    Route::post('/registrasi', 'AuthController@register');
    Route::post('/login', 'AuthController@login');
    Route::post('/forgot-password', 'PasswordResetController@forgot');
    Route::post('/reset-password', 'PasswordResetController@reset');
    Route::post('/send-verification', 'VerificationController@sendVerificationCode');
    Route::post('/verify-code', 'VerificationController@verifyCode');
    Route::get('/test-time', function () {
        return response()->json([
            'server_time' => now()->toDateTimeString(),
            'timezone' => config('app.timezone'),
            'message' => 'Waktu server sekarang'
        ]);
    });

    // Protected routes (butuh auth dengan token)
    Route::middleware(['auth:sanctum'])->group(function () {
        // Auth management routes
        Route::post('/logout', 'AuthController@logout');
        Route::post('/refresh-token', 'AuthController@refresh');
        Route::get('/check-token', 'AuthController@checkToken');

        // Resource routes dengan controller class (jika ada custom method)
        Route::apiResource('user', UserController::class);
        Route::post('user/{user}', [UserController::class, 'update']); // Custom update method
        // Route::delete('user/{user}/photo', [UserController::class, 'deletePhoto']);

        Route::apiResource('submisi', SubmisiController::class);
        // Route::post('submisi/{submisi}', [SubmisiController::class, 'update']); // Custom update method

        // Resource routes dengan namespace string
        Route::apiResource('admin', 'AdminController');
        Route::apiResource('dosen', 'DosenController');
        Route::apiResource('jadwal', 'JadwalController');
        Route::apiResource('krs', 'KrsController');
        Route::apiResource('mahasiswa', 'MahasiswaController');
        Route::apiResource('mata-kuliah', 'MataKuliahController');
        Route::apiResource('postingan', 'PostinganController');
        Route::apiResource('tugas', 'TugasController');

    });

});

Route::get('/test-time', function () {
    return response()->json([
        'server_time' => now()->toDateTimeString(),
        'timezone' => config('app.timezone'),
        'message' => 'Waktu server sekarang'
    ]);
});