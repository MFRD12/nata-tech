<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reset Password</title>
    <style>
        /* Tailwind minimal inline styles agar kompatibel di email client */
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
                "Helvetica Neue", Arial, sans-serif;
            background-color: #f9fafb; /* light gray */
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            padding: 32px 40px;
            box-shadow: 0 10px 15px rgb(0 0 0 / 0.1);
            border: 1px solid #e5e7eb; /* gray-200 */
        }
        .logo-wrapper {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo-wrapper img {
            max-width: 100px;
            height: auto;
            border-radius: 50%; /* rounded full */
            border: 2px solid #3b82f6; /* blue-500 border */
            padding: 4px;
            background-color: #ffffff;
        }
        h1 {
            font-size: 28px;
            font-weight: 700;
            color: #111827; /* gray-900 */
            margin-bottom: 20px;
            text-align: center;
        }
        p {
            color: #4b5563; /* gray-600 */
            font-size: 17px;
            line-height: 1.6;
            margin-bottom: 24px;
            text-align: center;
        }
        a.button {
            background-color: #3b82f6; /* blue-500 */
            color: white !important;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 700;
            display: inline-block;
            margin: 0 auto 30px;
            text-align: center;
            font-size: 16px;
            letter-spacing: 0.03em;
            box-shadow: 0 4px 8px rgb(59 130 246 / 0.4);
            transition: background-color 0.3s ease;
        }
        a.button:hover {
            background-color: #2563eb; /* blue-600 */
        }
        .footer {
            font-size: 14px;
            color: #9ca3af; /* gray-400 */
            text-align: center;
            margin-top: 40px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-wrapper">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo Perusahaan" />
        </div>
        <h1>Halo, {{ $nama }}</h1>
        <p>Kami menerima permintaan untuk mereset kata sandi akun Anda.</p>
        <p>Silakan klik tombol di bawah ini untuk membuat kata sandi baru:</p>
        <div style="text-align:center;">
            <a href="{{ $url }}" class="button" target="_blank" rel="noopener">Reset Password</a>
        </div>
        <p>Jika Anda tidak meminta reset kata sandi ini, abaikan email ini.</p>
        <p>Terima kasih,<br>Tim Naraya Satya Utama Teknologi</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Naraya Satya Utama Teknologi. Semua hak dilindungi.
    </div>
</body>
</html>
