<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Akun Pengguna | <?= $data_website ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
        }

        p {
            color: #555;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #999;
        }

        @media only screen and (max-width: 500px) {
            .container {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Pemulihan Password Pengguna | <?= $data_website ?></h1>
        <p>Hallo <?= $user_nama ?>,</p>
        <p>Terima kasih telah menjadi bagian dari <?= $data_website ?>. Untuk memulihkan password akun Anda, klik tombol di bawah ini:
        </p>
        <p><a class="btn" href="<?= base_url($url_aktifasi)?>">Reset Password</a></p>
        <p>Jika Anda tidak merasa melakukan proses pemulihan password, abaikan email ini.</p>
        <div class="footer">
            <p>Regards, Tim <?= $data_website ?></p>
        </div>
    </div>
</body>

</html>