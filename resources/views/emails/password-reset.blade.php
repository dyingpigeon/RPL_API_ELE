<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Halo {{ $name ?? 'Pengguna' }},</h2>
    
    <p>Kami menerima permintaan reset password untuk akun Anda.</p>
    
    <p>Berikut adalah kode verifikasi Anda:</p>
    
    <div style="background: #f4f4f4; padding: 15px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 5px; border-radius: 5px;">
        {{ $token }}
    </div>
    
    <p>Kode ini akan kedaluwarsa dalam 1 jam.</p>
    
    <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
    
    <br>
    <p>Terima kasih,<br>Tim {{ config('app.name') }}</p>
</body>
</html>