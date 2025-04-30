
    <div class="login-page d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: #f7f7f7;">
        <div class="card shadow p-4" style="width: 100%; max-width: 420px;">
            <div class="text-center mb-4">
                <h4 class="mb-1">Lupa Password</h4>
                <p class="text-muted small">Masukkan email Anda untuk mengatur ulang password</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
                </div>

                <!-- Submit -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        Kirim Link Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tambahkan Bootstrap jika belum -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

