<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Commerce</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
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
            cursor: pointer; /* agar bisa diklik */
        }
        .btn-login {
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
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0px 7px 18px rgba(150,0,50,0.30);
        }
        .bottom-links {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 14px;
        }
        .bottom-links a {
            color: #6b2b38;
            text-decoration: none;
            font-weight: 500;
        }
        .bottom-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body class="flex justify-center items-center">
    <div class="card">
        <h2 class="text-3xl font-bold text-center mb-8 text-[#6b2b38]">Login</h2>

        @if(session('status'))
            <p class="text-green-800 mb-3 text-center">{{ session('status') }}</p>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- EMAIL -->
            <div class="input-wrapper">
                <input type="email" name="email" placeholder="Email" required>
                <i class="fas fa-envelope"></i>
            </div>

            <!-- PASSWORD -->
            <div class="input-wrapper">
                <input type="password" name="password" placeholder="Password" id="password" required>
                <i class="fas fa-eye" id="togglePassword"></i>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn-login">
                Login
            </button>
        </form>

        <!-- LINKS -->
        <div class="bottom-links">
            <a href="{{ route('register') }}">Create an account</a>
            <a href="{{ route('password.request') }}">Forgot password</a>
        </div>
    </div>

    <!-- SCRIPT SHOW/HIDE PASSWORD -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            // toggle type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // toggle icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
