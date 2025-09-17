<?php

use App\Http\Controllers\Api\V1\DosenController;
use App\Http\Controllers\Api\V1\JadwalController;
use App\Http\Controllers\Api\V1\KrsController;
use App\Http\Controllers\Api\V1\MahasiswaController;
use App\Http\Controllers\Api\V1\MataKuliahController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AdminController;
use Phiki\Grammar\Injections\Prefix;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function() {
    Route::apiResource('admin', AdminController::class);
    Route::apiResource('dosen', DosenController::class);
    Route::apiResource('jadwal', JadwalController::class);
    Route::apiResource('krs', KrsController::class);
    Route::apiResource('mahasiswa', MahasiswaController::class);
    Route::apiResource('matakuliah', MataKuliahController::class);
});