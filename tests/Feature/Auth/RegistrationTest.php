<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    // public function test_new_users_can_register(): void
    // {
    //     // Pastikan tidak ada user dengan email sama sebelumnya
    //     $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);

    //     $response = $this->post('/register', [
    //         'name' => 'Test User',
    //         'email' => 'test@example.com',
    //         'password' => 'password', // default password dari factory
    //         'password_confirmation' => 'password',
    //     ]);

    //     // Pastikan pengguna berhasil dibuat di database
    //     $this->assertDatabaseHas('users', ['email' => 'test@example.com']);

    //     // Pastikan pengguna sudah login
    //     $this->assertAuthenticated();

    //     // Redirect ke halaman yang ditentukan setelah login
    //     $response->assertRedirect(RouteServiceProvider::HOME);
    // }
}
