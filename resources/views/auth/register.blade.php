
    <div class="login-page d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: #f7f7f7;">
        <div class="card shadow p-4" style="width: 100%; max-width: 420px;">
            <div class="text-center mb-4">
                <h4 class="mb-1">Daftar ke Belanjain</h4>
                <p class="text-muted small">Masukkan data Anda untuk mendaftar</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Role -->
                <div class="mb-3">
                    <label for="role" class="form-label">Daftar Sebagai</label>
                    <select id="role" name="role" required class="form-control">
                        <option value="pembeli" {{ old('role') == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                        <option value="penjual" {{ old('role') == 'penjual' ? 'selected' : '' }}>Penjual</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="text-danger small mt-1" />
                </div>

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="text-danger small mt-1" />
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger small mt-1" />
                </div>

                <!-- Submit & Login -->
                <div class="d-flex justify-content-between align-items-center">
                    <a class="text-decoration-none small" href="{{ route('login') }}">
                        Sudah punya akun?
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tambahkan Bootstrap jika belum -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

