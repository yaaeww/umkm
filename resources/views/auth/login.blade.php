<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Belanjain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .bg-cover {
            background-image: url('{{ asset('aset/bckk.png') }}');
            background-size: cover;
            background-position: center;
            height: 100vh;
            position: relative;
            color: white;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.5);
            /* semi-transparent dark overlay */
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .login-form {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            color: white;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }

        .form-control::placeholder {
            color: #ddd;
        }

        .btn-login {
            background-color: #ff5c8a;
            border: none;
            padding: 0.75rem;
            width: 100%;
            font-weight: bold;
        }

        .top-nav {
            position: absolute;
            top: 20px;
            right: 30px;
        }

        .top-nav a {
            color: #fff;
            margin-left: 20px;
            text-decoration: none;
            font-size: 14px;
        }

        .bottom-links {
            font-size: 13px;
        }

        .login-icon {
            width: 50px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="bg-cover">
        <div class="overlay d-flex align-items-center justify-content-center flex-column">

            <!-- Top Nav -->
            <div class="top-nav">
                <a href="#">Login</a>
                <a href="/">Home</a>
                <a href="{{route('register')}}">Register</a>
                
            </div>

            <!-- Login Form -->
            <div class="login-form text-center" style="width: 100%; max-width: 400px;">
                <!-- Ganti bagian <img> logo di dalam .login-form -->
<img src="{{ asset('aset/finalisasi logo.png') }}" alt="Logo"  style="width: 80px;">

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3 text-start">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>
                    <div class="mb-3 text-start">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-login text-white">GET STARTED</button>

                    <div class="d-flex justify-content-between mt-2 bottom-links">
                        <div>
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Keep Logged In</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-white text-decoration-none">Forgot
                            Password?</a>
                    </div>

                    <div class="d-flex justify-content-between mt-3 bottom-links">
                        <a href="{{ route('register') }}" class="text-white text-decoration-none">CREATE ACCOUNT</a>
                    
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>