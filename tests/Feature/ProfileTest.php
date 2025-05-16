<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test halaman profil dapat ditampilkan.
     */
    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    /**
     * Test pengguna dapat memperbarui informasi profil.
     */
    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/penjual/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/penjual/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    /**
     * Test status verifikasi email tidak berubah jika email tidak diubah.
     */
    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/penjual/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/penjual/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    /**
     * Test pengguna dapat menghapus akun dengan password yang benar.
     */
    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this
            ->actingAs($user)
            ->delete('/penjual/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/penjual/profile');

        $this->assertGuest();

        $this->assertNull(User::find($user->id));
    }

    /**
     * Test pengguna tidak dapat menghapus akun dengan password yang salah.
     */
    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this
            ->actingAs($user)
            ->from('/penjual/profile')
            ->delete('/penjual/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrors('password')
            ->assertRedirect('/penjual/profile');

        $this->assertNotNull(User::find($user->id));
    }
}
