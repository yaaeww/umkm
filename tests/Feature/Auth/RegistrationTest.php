<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test halaman registrasi dapat diakses.
     */
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Register'); // Sesuaikan dengan isi halaman
    }

    /**
     * Test user baru dapat melakukan registrasi dengan data valid.
     */
    public function test_new_users_can_register(): void
    {
        // Pastikan belum ada user dengan email tersebut
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);

        // Pastikan user belum login saat mulai registrasi
        $this->assertGuest();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password', // password plaintext, akan di-hash otomatis oleh Laravel
            'password_confirmation' => 'password',
        ]);

        // Pastikan tidak ada error validasi
        $response->assertSessionHasNoErrors();

        // Pastikan user baru berhasil dibuat di database
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);

        // Pastikan user sudah ter-autentikasi
        $this->assertAuthenticated();

        // Pastikan redirect ke home/dashboard setelah registrasi
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
