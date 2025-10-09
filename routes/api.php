<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// V2 Routes
Route::group(['prefix' => 'v2', 'namespace' => 'App\Http\Controllers\Api\V2'], function () {
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