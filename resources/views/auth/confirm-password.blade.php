<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Password - Belanjain</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f0f1e 0%, #1a1a2e 50%, #16213e 100%);
        }

        .bg-cover {
            min-height: 100vh;
            position: relative;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .animated-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .animated-bg::before,
        .animated-bg::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: float 20s infinite ease-in-out;
        }

        .animated-bg::before {
            background: linear-gradient(45deg, #ff5c8a, #a855f7);
            top: -10%;
            left: -10%;
            animation-delay: 0s;
        }

        .animated-bg::after {
            background: linear-gradient(45deg, #3b82f6, #06b6d4);
            bottom: -10%;
            right: -10%;
            animation-delay: 5s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -30px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .confirm-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
        }

        .confirm-form {
            background: rgba(30, 30, 46, 0.7);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .icon-wrapper {
            width: 64px;
            height: 64px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, rgba(255, 92, 138, 0.2), rgba(255, 51, 102, 0.2));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 92, 138, 0.3);
        }

        .icon-wrapper svg {
            width: 32px;
            height: 32px;
            color: #ff5c8a;
        }

        .logo-container h5 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #fff 0%, #e5e5e5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .info-text {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.95rem;
            line-height: 1.6;
            text-align: center;
            margin-bottom: 2rem;
            padding: 1rem;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 12px;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .form-label {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.9rem;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 0.875rem 1.25rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.08);
            border-color: #ff5c8a;
            box-shadow: 0 0 0 3px rgba(255, 92, 138, 0.15);
            color: white;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .btn-confirm {
            background: linear-gradient(135deg, #ff5c8a 0%, #ff3366 100%);
            border: none;
            padding: 0.875rem 2rem;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-size: 1rem;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(255, 92, 138, 0.3);
            min-width: 140px;
        }

        .btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 92, 138, 0.4);
            background: linear-gradient(135deg, #ff3366 0%, #ff5c8a 100%);
        }

        .text-danger {
            color: #fca5a5 !important;
            font-size: 0.875rem;
            display: block;
            margin-top: 0.5rem;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }

        @media (max-width: 576px) {
            .confirm-form {
                padding: 2rem 1.5rem;
            }

            .btn-confirm {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="bg-cover">
        <div class="animated-bg"></div>

        <!-- Confirm Password Container -->
        <div class="confirm-container">
            <div class="confirm-form">
                <div class="logo-container">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h5>Area Aman</h5>
                </div>

                <div class="info-text">
                    Ini adalah area aman dari aplikasi. Silakan konfirmasi password Anda sebelum melanjutkan.
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" class="form-control" type="password" name="password"
                            placeholder="Masukkan password Anda" required autocomplete="current-password" autofocus>

                        @if($errors->get('password'))
                            @foreach($errors->get('password') as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        @endif
                    </div>

                    <div class="button-container">
                        <button type="submit" class="btn btn-confirm text-white">
                            Konfirmasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>