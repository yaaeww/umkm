<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test bahwa halaman verifikasi email bisa diakses oleh user yang belum verifikasi.
     */
    public function test_email_verification_screen_can_be_rendered(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $response = $this->actingAs($user)->get('/verify-email');

        $response->assertStatus(200);
        $response->assertSee('Verifikasi Email'); // Sesuaikan dengan isi halaman Anda
    }

    /**
     * Test bahwa email bisa diverifikasi menggunakan URL yang valid.
     */
    public function test_email_can_be_verified(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());

        $response->assertRedirect(RouteServiceProvider::HOME . '?verified=1');
    }

    /**
     * Test bahwa email tidak diverifikasi jika hash salah.
     */
    public function test_email_is_not_verified_with_invalid_hash(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $invalidUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1('wrong-email'),
            ]
        );

        $response = $this->actingAs($user)->get($invalidUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
        $response->assertStatus(403); // Biasanya Laravel akan menolak dengan status ini
    }
}
