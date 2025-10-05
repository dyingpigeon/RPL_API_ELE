<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function() {
    try {
        Mail::to('the.farhanad123@gmail.com')
            ->send(new VerificationCodeMail('123456', 'Farhan')); // ← Hapus "App\Mail\"
        
        return 'Email dengan template berhasil dikirim!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});