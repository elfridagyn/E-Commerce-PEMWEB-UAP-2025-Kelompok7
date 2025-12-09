<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - E-Commerce</title>

    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f3b8c8, #e38fa2, #d86e82);
            height: 100vh;
        }

        .card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(12px);
            border-radius: 30px;
            padding: 40px;
            width: 380px;
            box-shadow: 0px 15px 40px rgba(0,0,0,0.15);
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 25px;
        }

        .input-wrapper input {
            width: 100%;
            border: none;
            border-bottom: 2px solid #b25c6a;
            padding: 10px 35px 10px 0;
            font-size: 15px;
            background: transparent;
            color: #6b2b38;
            outline: none;
        }

        .input-wrapper i {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            color: #8d3949;
        }

        .btn-reset {
            width: 100%;
            background: linear-gradient(145deg, #f1b1c2, #c96a7f);
            padding: 13px;
            border-radius: 25px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0px 5px 15px rgba(150,0,50,0.25);
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0px 7px 18px rgba(150,0,50,0.30);
        }

        .back-link {
            margin-top: 20px;
            text-align: center;
        }

        .back-link a {
            color: #6b2b38;
            font-weight: 500;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body class="flex justify-center items-center">

    <div class="card">

        <h2 class="text-3xl font-bold text-center mb-6 text-[#6b2b38]">
            Lupa Password
        </h2>

        <p class="text-center text-[#6b2b38] mb-4 text-sm">
            Masukkan email kamu untuk mendapatkan link reset password.
        </p>

        @if (session('status'))
            <div class="text-green-800 text-center mb-3 font-semibold">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="input-wrapper">
                <input type="email" name="email" placeholder="Email" required autofocus>
                <i class="fas fa-envelope"></i>
            </div>

            <button type="submit" class="btn-reset">
                Kirim Link Reset Password
            </button>

        </form>

        <div class="back-link">
            <a href="{{ route('login') }}">Kembali ke login</a>
        </div>

    </div>

</body>
</html>
