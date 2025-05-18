<!-- HEAD Section Tambahan -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Inter', sans-serif;
        background: url('{{ asset('aset/bckk.png') }}') no-repeat center center fixed;
        background-size: cover;
        min-height: 100vh;
    }

    .form-control::placeholder {
        font-size: 14px;
        color: #ccc;
    }

    .role-option {
        transition: all 0.3s ease;
    }

    .role-option img {
        height: 50px;
    }

    .role-option:hover {
        background-color: #f0f8ff;
    }

    .role-option.active {
        border: 2px solid #0d6efd;
        background-color: #e7f1ff;
    }

    .card {
        border-radius: 20px;
        background-color: rgba(255, 255, 255, 0.95); /* semi transparan */
        backdrop-filter: blur(5px);
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
    }
</style>

<!-- BODY Section -->
<div class="login-page d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card shadow p-4 border-0" style="width: 100%; max-width: 420px;">
        <div class="text-center mb-4">
            <h5 class="mb-1">Pilih Tipe Akun</h5>
            <p class="text-muted small">Silakan isi formulir di bawah untuk mendaftar</p>
        </div>

        <!-- Pilih Role -->
        <div class="d-flex justify-content-between mb-4">
            <div class="role-option text-center flex-fill me-2 p-3 border rounded {{ old('role') == 'penjual' ? 'active' : '' }}" style="cursor: pointer;" onclick="selectRole('penjual')">
                <img src="{{ asset('aset/iconpenjual.png') }}" alt="Penjual">
                <p class="mt-2 mb-0 fw-semibold">Penjual</p>
            </div>
            <div class="role-option text-center flex-fill ms-2 p-3 border rounded {{ old('role') == 'pembeli' ? 'active' : '' }}" style="cursor: pointer;" onclick="selectRole('pembeli')">
                <img src="{{ asset('aset/iconpembeli.jpg') }}" alt="Pembeli">
                <p class="mt-2 mb-0 fw-semibold">Pembeli</p>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="hidden" name="role" id="roleInput" value="{{ old('role') }}">

            <div class="mb-3">
                <input id="name" class="form-control" type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="text-danger small mt-1" />
            </div>

            <div class="mb-3">
                <input id="email" class="form-control" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
            </div>

            <div class="mb-3">
                <input id="password" class="form-control" type="password" name="password" placeholder="Password" required />
                <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
            </div>

            <div class="mb-3">
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="Konfirmasi Password" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger small mt-1" />
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Daftar
            </button>

            <p class="text-center mt-3 small">Sudah punya akun?
                <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
            </p>
        </form>
    </div>
</div>

<!-- JS Bootstrap + Interaksi Role -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function selectRole(role) {
        document.getElementById('roleInput').value = role;

        document.querySelectorAll('.role-option').forEach(el => {
            el.classList.remove('active');
        });

        if (role === 'penjual') {
            document.querySelectorAll('.role-option')[0].classList.add('active');
        } else {
            document.querySelectorAll('.role-option')[1].classList.add('active');
        }
    }
</script>
