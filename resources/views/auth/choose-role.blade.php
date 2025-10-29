@extends('layouts.app')

@section('title', 'Pilih Peran - Google Login')

@section('content')
    <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; background: #f7f9fb;">
        <div class="card shadow-sm border-0 p-4" style="width: 100%; max-width: 420px; border-radius: 12px;">
            <div class="text-center mb-4">
                <img src="{{ asset('aset/google-logo.png') }}" alt="Google Logo" style="width: 50px; margin-bottom: 10px;">
                <h5 class="mb-1">Lanjutkan dengan Google</h5>
                <p class="text-muted small mb-2">
                    Halo, <strong>{{ data_get(session('google_user'), 'name', 'Pengguna') }}</strong>!
                </p>
                <p class="text-muted small">Pilih peran kamu untuk melanjutkan.</p>
            </div>

            <form method="POST" action="{{ route('auth.google.saveRole') }}">
                @csrf

                <!-- Pilihan Role -->
                <div class="d-flex justify-content-between mb-4">
                    <button type="button" class="btn btn-outline-primary flex-fill me-2 role-btn" data-role="penjual">
                        <img src="{{ asset('aset/iconpenjual.png') }}" alt="Penjual" style="height:40px;"><br>
                        Penjual
                    </button>
                    <button type="button" class="btn btn-outline-primary flex-fill ms-2 role-btn" data-role="pembeli">
                        <img src="{{ asset('aset/iconpembeli.jpg') }}" alt="Pembeli" style="height:40px;"><br>
                        Pembeli
                    </button>
                </div>

                <input type="hidden" name="role" id="roleInput" value="">

                <!-- Submit -->
                <button type="submit" class="btn btn-primary w-100 py-2">Lanjutkan</button>
            </form>

            <p class="text-center mt-3 small text-muted">
                Atau <a href="{{ route('login') }}" class="text-decoration-none">login dengan akun lain</a>
            </p>
        </div>
    </div>

    <!-- JS untuk interaksi role -->
    <script>
        const roleButtons = document.querySelectorAll('.role-btn');
        const roleInput = document.getElementById('roleInput');

        roleButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                // Hapus active dari semua
                roleButtons.forEach(b => b.classList.remove('active'));
                // Set active di button yang diklik
                this.classList.add('active');
                // Set value input hidden
                roleInput.value = this.dataset.role;
            });
        });
    </script>

    <style>
        .role-btn {
            border-radius: 8px;
            padding: 12px 0;
            font-size: 14px;
            text-align: center;
            transition: all 0.2s ease-in-out;
            background-color: #fff;
            border: 1px solid #dcdcdc;
            color: #333;
        }

        .role-btn.active,
        .role-btn:hover {
            border-color: #0d6efd;
            background-color: #e7f1ff;
            color: #0d6efd;
        }
    </style>
@endsection