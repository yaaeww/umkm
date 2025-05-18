<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test bahwa halaman konfirmasi password dapat diakses.
     */
    public function test_confirm_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/confirm-password');

        $response->assertStatus(200);
        $response->assertSee('Confirm Password'); // Sesuaikan dengan teks halaman Anda
    }

    /**
     * Test bahwa password dapat dikonfirmasi dengan password yang benar.
     */
    public function test_password_can_be_confirmed(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'), // Pastikan password terenkripsi benar
        ]);

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertRedirect(); // Biasanya redirect ke halaman sebelumnya
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test bahwa password tidak dikonfirmasi jika password salah.
     */
    public function test_password_is_not_confirmed_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($user)->from('/confirm-password')->post('/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/confirm-password');
        $response->assertSessionHasErrors('password');
    }
}
