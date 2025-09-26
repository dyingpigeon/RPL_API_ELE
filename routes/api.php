<?php

use App\Http\Controllers\Api\V1\DosenController;
use App\Http\Controllers\Api\V1\JadwalController;
use App\Http\Controllers\Api\V1\KrsController;
use App\Http\Controllers\Api\V1\MahasiswaController;
use App\Http\Controllers\Api\V1\MataKuliahController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PostinganController;
use App\Http\Controllers\Api\V1\SubmisiController;
use App\Http\Controllers\Api\V1\TugasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AdminController;
use App\Http\Controllers\Api\V1\PasswordResetController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::apiResource('admin', AdminController::class);
    Route::apiResource('dosen', DosenController::class);
    Route::apiResource('jadwal', JadwalController::class);
    Route::apiResource('krs', KrsController::class);
    Route::apiResource('mahasiswa', MahasiswaController::class);
    Route::apiResource('matakuliah', MataKuliahController::class);
    Route::apiResource('postingan', PostinganController::class);
    Route::apiResource('tugas', TugasController::class);
    Route::apiResource('submisi', SubmisiController::class);
    Route::post('/registrasi', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/forgotPassword', [PasswordResetController::class, 'forgot']);
    Route::post('/resetPassword', [PasswordResetController::class, 'reset']);
    // Route::get('/resetPassword/{token}', function (Request $request, $token) {
    //     // Redirect ke frontend dengan token (misalnya ke http://localhost:3000/reset?token=xxx&email=...)
    //     return redirect("http://localhost:3000/reset-password?token=$token&email={$request->email}");
    // })->name('password.reset');
});