<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API JDM - {{ $version }}</title>
</head>
<body bgcolor="black" text="white">
    <h1>API JDM {{ $version }}</h1>
    
    <h2>Endpoint yang tersedia:</h2>
    
    @if($version == 'v1')
    <h3>Public Routes (Tidak butuh auth):</h3>
    <ul>
        <li><strong>POST</strong> /api/v1/registrasi</li>
        <li><strong>POST</strong> /api/v1/login</li>
        <li><strong>POST</strong> /api/v1/forgot-password</li>
        <li><strong>POST</strong> /api/v1/reset-password</li>
        <li><strong>POST</strong> /api/v1/send-verification</li>
        <li><strong>POST</strong> /api/v1/verify-code</li>
        <li><strong>GET</strong> /api/v1/test-time</li>
    </ul>

    <h3>Protected Routes (Butuh auth dengan token):</h3>
    <ul>
        <li><strong>POST</strong> /api/v1/logout</li>
        <li><strong>POST</strong> /api/v1/refresh-token</li>
        <li><strong>GET</strong> /api/v1/check-token</li>
        <li><strong>Resource</strong> /api/v1/admin</li>
        <li><strong>Resource</strong> /api/v1/dosen</li>
        <li><strong>Resource</strong> /api/v1/jadwal</li>
        <li><strong>Resource</strong> /api/v1/krs</li>
        <li><strong>Resource</strong> /api/v1/mahasiswa</li>
        <li><strong>Resource</strong> /api/v1/mata-kuliah</li>
        <li><strong>Resource</strong> /api/v1/postingan</li>
        <li><strong>Resource</strong> /api/v1/tugas</li>
        <li><strong>Resource</strong> /api/v1/submisi</li>
        <li><strong>Resource</strong> /api/v1/user</li>
    </ul>

    @elseif($version == 'v2')
    <h3>Public Routes (Tidak butuh auth):</h3>
    <ul>
        <li><strong>POST</strong> /api/v2/registrasi</li>
        <li><strong>POST</strong> /api/v2/login</li>
        <li><strong>POST</strong> /api/v2/logout</li>
        <li><strong>POST</strong> /api/v2/refresh-token</li>
        <li><strong>GET</strong> /api/v2/check-token</li>
        <li><strong>POST</strong> /api/v2/forgot-password</li>
        <li><strong>POST</strong> /api/v2/reset-password</li>
        <li><strong>POST</strong> /api/v2/send-verification</li>
        <li><strong>POST</strong> /api/v2/verify-code</li>
        <li><strong>GET</strong> /api/v2/test-time</li>
    </ul>

    <h3>Resource Routes:</h3>
    <ul>
        <li><strong>Resource</strong> /api/v2/user</li>
        <li><strong>POST</strong> /api/v2/user/{user} (Custom update)</li>
        <li><strong>Resource</strong> /api/v2/submisi</li>
        <li><strong>Resource</strong> /api/v2/admin</li>
        <li><strong>Resource</strong> /api/v2/dosen</li>
        <li><strong>Resource</strong> /api/v2/jadwal</li>
        <li><strong>Resource</strong> /api/v2/krs</li>
        <li><strong>Resource</strong> /api/v2/mahasiswa</li>
        <li><strong>Resource</strong> /api/v2/mata-kuliah</li>
        <li><strong>Resource</strong> /api/v2/postingan</li>
        <li><strong>Resource</strong> /api/v2/tugas</li>
    </ul>
    @endif

    <br>
    {{-- <a href="/"><button>Kembali ke Home</button></a> --}}
</body>
</html>