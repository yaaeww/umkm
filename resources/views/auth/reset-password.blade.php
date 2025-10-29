<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Belanjain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .bg-cover {
            background-image: url('{{ asset('aset/belanjain.jpg') }}');
            background-size: cover;
            background-position: center;
            height: 100vh;
            position: relative;
            color: white;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.5);
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

        .form-control.is-invalid {
            border: 1px solid #dc3545;
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
    </style>
</head>

<body>
    <div class="bg-cover">
        <div class="overlay d-flex align-items-center justify-content-center flex-column">

            <!-- Top Nav -->
            <div class="top-nav">
                <a href="/">Beranda</a>
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Daftar</a>
            </div>

            <!-- Reset Password Form -->
            <div class="login-form text-start" style="width: 100%; max-width: 400px;">
                <div class="text-center mb-3">
                    <img src="{{ asset('aset/finalisasi logo.png') }}" alt="Logo" style="width: 80px;">
                    <h5 class="mt-2">Reset Password</h5>
                </div>

                @if (session('status'))
                    <div class="alert alert-success text-white bg-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mt-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ request()->route('token') }}">

                    <!-- Email -->
                    <div class="mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email', request('email')) }}" placeholder="Masukkan Email" required
                            autofocus>
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" placeholder="Password Baru" required>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-3">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" placeholder="Konfirmasi Password" required>
                    </div>

                    <button type="submit" class="btn btn-login text-white">RESET PASSWORD</button>

                    <div class="d-flex justify-content-between mt-3 bottom-links">
                        <a href="{{ route('login') }}" class="text-white text-decoration-none">Kembali ke Login</a>
                    </div>
                </form>


            </div>
        </div>
    </div>
</body>

</html>