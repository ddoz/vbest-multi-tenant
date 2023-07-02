<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Berhasil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        
        h1 {
            color: #333;
        }
        
        p {
            margin-bottom: 10px;
        }
        
        a {
            color: #337ab7;
            text-decoration: none;
        }
        
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registrasi Berhasil</h1>
        <p>Selamat, pendaftaran Anda telah berhasil!</p>
        <p>Proses pembuatan akun selesai dan domain Anda telah aktif.</p>
        <p>Silakan klik tautan berikut untuk verifikasi akun Anda:</p>
        <p><a href="{{ $data['verificationUrl'] }}">Verifikasi Akun</a></p>
        <p>Terima kasih atas registrasi Anda.</p>
    </div>
</body>
</html>
