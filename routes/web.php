<?php

use Illuminate\Support\Facades\Route;

// Route untuk halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Route untuk info API v1
Route::get('/api/v1', function () {
    return view('api-info', ['version' => 'v1']);
});

// Route untuk info API v2
Route::get('/api/v2', function () {
    return view('api-info', ['version' => 'v2']);
});