<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Register'); // sesuaikan jika kata di halaman berbeda
    }

    public function test_new_users_can_register(): void
    {
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
        $this->assertGuest();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'pembeli',
            'password' => Hash::make('password'),
            'password_confirmation' => Hash::make('password'),
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
