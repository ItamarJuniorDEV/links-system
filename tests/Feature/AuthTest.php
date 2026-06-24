<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitante_na_raiz_e_levado_para_o_login(): void
    {
        $this->get('/')->assertRedirect(route('login'));
    }

    public function test_cadastro_cria_usuario_e_autentica(): void
    {
        Notification::fake();
        $email = fake()->unique()->safeEmail();

        $this->post(route('register'), [
            'name' => fake()->name(),
            'email' => $email,
            'email_confirmation' => $email,
            'password' => 'segredo-forte-123',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => $email]);
    }

    public function test_cadastro_envia_verificacao_de_email(): void
    {
        Notification::fake();
        $email = fake()->unique()->safeEmail();

        $this->post(route('register'), [
            'name' => fake()->name(),
            'email' => $email,
            'email_confirmation' => $email,
            'password' => 'segredo-forte-123',
        ]);

        Notification::assertSentTo(User::where('email', $email)->first(), VerifyEmail::class);
    }

    public function test_cadastro_exige_confirmacao_do_email(): void
    {
        $this->post(route('register'), [
            'name' => fake()->name(),
            'email' => 'um@email.test',
            'email_confirmation' => 'outro@email.test',
            'password' => 'segredo-forte-123',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_autentica_com_credenciais_corretas(): void
    {
        $user = User::factory()->create();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_com_senha_errada_volta_com_erro(): void
    {
        $user = User::factory()->create();

        $this->from(route('login'))
            ->post(route('login'), ['email' => $user->email, 'password' => 'errada'])
            ->assertRedirect(route('login'))
            ->assertSessionHas('error');

        $this->assertGuest();
    }

    public function test_logout_encerra_a_sessao(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_login_limita_tentativas(): void
    {
        $email = fake()->unique()->safeEmail();

        foreach (range(1, 5) as $tentativa) {
            $this->post(route('login'), ['email' => $email, 'password' => 'errada']);
        }

        $this->post(route('login'), ['email' => $email, 'password' => 'errada'])
            ->assertStatus(429);
    }
}
