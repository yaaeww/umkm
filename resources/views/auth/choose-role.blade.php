<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Peran - Lanjutkan dengan Google</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Tema Gelap Elegan dengan Animasi (Aksen Biru) */
        :root {
            --dark-bg: #121212; /* Latar belakang sangat gelap */
            --card-bg: #1e1e1e; /* Warna card gelap */
            --text-light: #e0e0e0; /* Teks terang */
            --text-muted-dark: #a0a0a0; /* Teks redup */
            --accent-color: #1a73e8; /* Akses warna Biru Google */
            --accent-light: #4285f4; /* Biru Google yang sedikit lebih terang */
            --shadow-glow: #4285f4; /* Shadow glow biru */
            --google-border: #363636; /* Border gelap */
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, var(--dark-bg) 0%, #000000 100%);
            color: var(--text-light);
        }
        
        /* ------------------------------------------- */
        /* 1. CONTAINER & MAIN LAYOUT */
        /* ------------------------------------------- */
        .auth-wrapper {
            min-height: 100vh;
            background-color: transparent;
        }

        .auth-card {
            width: 100%;
            max-width: 450px;
            border: 1px solid var(--google-border);
            border-radius: 20px;
            background-color: var(--card-bg);
            padding: 40px !important;
            /* Box Shadow Glow (Animasi) */
            box-shadow: 0 0 15px rgba(26, 115, 232, 0.4); /* Biru */
            transition: all 0.5s ease-in-out; 
        }

        .auth-card:hover {
            box-shadow: 0 0 25px rgba(26, 115, 232, 0.6), 0 0 5px rgba(66, 133, 244, 0.2); /* Biru */
            transform: scale(1.01);
        }

        /* ------------------------------------------- */
        /* 2. HEADER & LOGO */
        /* ------------------------------------------- */
        .logo-container img {
            width: 70px;
            margin-bottom: 24px;
            filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.3));
        }

        .main-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .welcome-message {
            font-size: 0.95rem;
            color: var(--text-muted-dark);
            margin-bottom: 24px;
        }
        .welcome-message strong {
            color: var(--accent-light);
        }


        /* ------------------------------------------- */
        /* 3. ROLE SELECTION BUTTONS */
        /* ------------------------------------------- */
        .role-btn {
            border-radius: 12px;
            padding: 16px 8px;
            font-size: 1rem;
            font-weight: 500;
            text-align: center;
            background-color: var(--card-bg);
            border: 1px solid var(--google-border);
            color: var(--text-light);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94); 
        }

        .role-btn img {
            height: 50px;
            margin-bottom: 10px;
            border-radius: 8px;
            object-fit: cover;
            filter: brightness(0.9); 
        }

        .role-btn.active {
            border: 2px solid var(--accent-light); /* Biru */
            background-color: rgba(26, 115, 232, 0.2); /* Biru transparan */
            color: var(--accent-light);
            box-shadow: 0 0 10px rgba(26, 115, 232, 0.6); /* Biru */
            transform: scale(1.05);
        }

        .role-btn:hover:not(.active) {
            background-color: #2a2a2a; 
            border-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        /* ------------------------------------------- */
        /* 4. SUBMIT BUTTON & FOOTER */
        /* ------------------------------------------- */
        .btn-primary {
            background: linear-gradient(90deg, var(--accent-color) 0%, var(--accent-light) 100%) !important;
            border: none !important;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
            color: white;
        }

        .btn-primary:hover:not(:disabled) {
            background: linear-gradient(90deg, var(--accent-light) 0%, var(--accent-color) 100%) !important;
            box-shadow: 0 0 15px rgba(26, 115, 232, 0.8); /* Biru */
            transform: translateY(-1px);
        }

        .btn-primary:disabled {
            background-color: #3d3d3d !important;
            border-color: #3d3d3d !important;
            color: #888;
            cursor: not-allowed;
            opacity: 0.8;
        }
        
        /* ------------------------------------------- */
        /* PERUBAHAN WARNA TEKS FOOTER */
        /* ------------------------------------------- */

        /* Warna teks biasa di footer menjadi putih */
        .text-light-override {
            color: var(--text-light) !important;
        }

        /* Warna tautan Keluar menjadi Biru */
        .footer-link {
            color: var(--accent-light) !important; /* Warna Biru */
            font-weight: 500;
            transition: color 0.2s;
        }
        .footer-link:hover {
            color: var(--accent-color) !important; /* Biru yang sedikit lebih gelap untuk hover */
        }
    </style>
</head>

<body>
    <div class="d-flex align-items-center justify-content-center auth-wrapper">
        <div class="auth-card shadow-lg p-5">
            <div class="text-center mb-4 logo-container">
                <img src="{{ asset('aset/google.png') }}" alt="Google Logo">
                <h1 class="main-title">Pilih Peran</h1>
                <p class="welcome-message">
                    Lanjutkan sebagai <strong>{{ data_get(session('google_user'), 'name', 'Pengguna') }}</strong>
                    ({{ data_get(session('google_user'), 'email', 'email@contoh.com') }}).
                    <br>Tentukan peran kamu untuk mengakses fitur yang sesuai.
                </p>
            </div>

            <form method="POST" action="{{ route('auth.google.saveRole') }}">
                @csrf

                <div class="d-flex justify-content-between mb-4 gap-3">
                    <button type="button" class="role-btn flex-fill me-2" data-role="penjual">
                        <img src="{{ asset('aset/iconpenjual.png') }}" alt="Ikon Penjual">
                        Penjual
                    </button>
                    <button type="button" class="role-btn flex-fill ms-2" data-role="pembeli">
                        <img src="{{ asset('aset/iconpembeli.jpg') }}" alt="Ikon Pembeli">
                        Pembeli
                    </button>
                </div>

                <input type="hidden" name="role" id="roleInput" value="">

                <button type="submit" class="btn btn-primary w-100 py-2 mt-3" disabled
                    id="continueBtn">Lanjutkan</button>
            </form>

            <p class="text-center mt-4 small text-light-override">
                Bukan kamu?
                <a href="{{ route('logout') }}" class="text-decoration-none footer-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Keluar dan login dengan akun lain
                </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            </p>

        </div>
    </div>

    <script>
        const roleButtons = document.querySelectorAll('.role-btn');
        const roleInput = document.getElementById('roleInput');
        const continueBtn = document.getElementById('continueBtn');

        // Tombol Lanjutkan dinonaktifkan secara default
        continueBtn.disabled = true;

        roleButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                // Hapus active dari semua
                roleButtons.forEach(b => b.classList.remove('active'));

                // Set active di button yang diklik
                this.classList.add('active');

                // Set value input hidden
                roleInput.value = this.dataset.role;

                // Aktifkan tombol Lanjutkan
                continueBtn.disabled = false;
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>