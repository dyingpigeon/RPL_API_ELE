<?php

use App\Http\Controllers\Api\V2\SubmisiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V2\UserController; // TAMBAHKAN INI

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// V1 Routes
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
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

    Route::post('/registrasi', 'AuthController@register');
    Route::post('/login', 'AuthController@login');

    Route::post('/forgot-password', 'PasswordResetController@forgot');
    Route::post('/reset-password', 'PasswordResetController@reset');

    Route::post('/send-verification', 'VerificationController@sendVerificationCode');
    Route::post('/verify-code', 'VerificationController@verifyCode');
});

// V2 Routes - GUNAKAN SYNTAX MODERN
Route::prefix('v2')->group(function () {
    Route::apiResource('user', UserController::class);
    Route::post('user/{user}', [UserController::class, 'update']);
    // Route::delete('user/{user}/photo', [UserController::class, 'deletePhoto']);

    // Route lainnya tetap pakai namespace string
    Route::apiResource('admin', \App\Http\Controllers\Api\V2\AdminController::class);
    Route::apiResource('dosen', \App\Http\Controllers\Api\V2\DosenController::class);
    Route::apiResource('jadwal', \App\Http\Controllers\Api\V2\JadwalController::class);
    Route::apiResource('krs', \App\Http\Controllers\Api\V2\KrsController::class);
    Route::apiResource('mahasiswa', \App\Http\Controllers\Api\V2\MahasiswaController::class);
    Route::apiResource('mata-kuliah', \App\Http\Controllers\Api\V2\MataKuliahController::class);
    Route::apiResource('postingan', \App\Http\Controllers\Api\V2\PostinganController::class);
    Route::apiResource('tugas', \App\Http\Controllers\Api\V2\TugasController::class);
    Route::apiResource('submisi', SubmisiController::class);
    // Route::post('submisi/{submisi}', [SubmisiController::class, 'update']);

    Route::post('/registrasi', [\App\Http\Controllers\Api\V2\AuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\Api\V2\AuthController::class, 'login']);

    Route::post('/forgot-password', [\App\Http\Controllers\Api\V2\PasswordResetController::class, 'forgot']);
    Route::post('/reset-password', [\App\Http\Controllers\Api\V2\PasswordResetController::class, 'reset']);

    Route::post('/send-verification', [\App\Http\Controllers\Api\V2\VerificationController::class, 'sendVerificationCode']);
    Route::post('/verify-code', [\App\Http\Controllers\Api\V2\VerificationController::class, 'verifyCode']);
});

// TEST ROUTE - tambahkan di luar group manapun
// Route::patch('/test-user-update/{id}', [UserController::class, 'testUpdate']);