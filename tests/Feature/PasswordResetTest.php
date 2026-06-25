<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_link_de_redefinicao_e_enviado(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertSessionHas('success');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_senha_e_redefinida_com_token_valido(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'nova-senha-forte',
            'password_confirmation' => 'nova-senha-forte',
        ])->assertRedirect(route('login'));

        $this->assertTrue(Hash::check('nova-senha-forte', $user->fresh()->password));
    }

    public function test_token_invalido_nao_redefine_a_senha(): void
    {
        $user = User::factory()->create();

        $this->post(route('password.update'), [
            'token' => 'token-invalido',
            'email' => $user->email,
            'password' => 'nova-senha-forte',
            'password_confirmation' => 'nova-senha-forte',
        ])->assertSessionHas('error');

        $this->assertFalse(Hash::check('nova-senha-forte', $user->fresh()->password));
    }
}
