<!DOCTYPE html>
<html>
<head>
    <title>Kode Verifikasi</title>
</head>
<body>
    <h2>Halo {{ $name ?? 'Pengguna' }},</h2>
    
    <p>Berikut adalah kode verifikasi Anda:</p>
    
    <div style="background: #f4f4f4; padding: 10px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 5px;">
        {{ $code }}
    </div>
    
    <p>Kode ini akan kedaluwarsa dalam 10 menit.</p>
    
    <p>Jika Anda tidak meminta kode ini, abaikan email ini.</p>
    
    <br>
    <p>Terima kasih,<br>Tim {{ config('app.name') }}</p>
</body>
</html>