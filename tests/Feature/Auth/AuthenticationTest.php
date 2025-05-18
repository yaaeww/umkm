<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test bahwa halaman login dapat diakses.
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login'); // Pastikan ada teks login (sesuaikan jika perlu)
    }

    /**
     * Test bahwa user dapat login dengan kredensial yang valid.
     */
    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'), // Pastikan password sesuai dengan yang di-post
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/pembeli/dashboard'); // Sesuaikan jika redirect berbeda berdasarkan role
    }

    /**
     * Test bahwa user tidak bisa login dengan password yang salah.
     */
    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email'); // Laravel biasanya mengembalikan error di field email
    }

    /**
     * Test bahwa user dapat logout dan menjadi guest.
     */
    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
