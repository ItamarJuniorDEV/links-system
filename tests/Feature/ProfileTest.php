<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_atualiza_o_perfil(): void
    {
        $user = User::factory()->create();
        $nome = fake()->name();

        $this->actingAs($user)
            ->from(route('profile'))
            ->put(route('profile'), [
                'name' => $nome,
                'handler' => 'novohandle',
                'description' => fake()->sentence(),
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $nome,
            'handler' => 'novohandle',
        ]);
    }

    public function test_handler_precisa_ser_unico(): void
    {
        User::factory()->create(['handler' => 'ocupado']);
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('profile'))
            ->put(route('profile'), ['name' => fake()->name(), 'handler' => 'ocupado'])
            ->assertSessionHasErrors('handler');
    }

    public function test_usuario_mantem_o_proprio_handler(): void
    {
        $user = User::factory()->create(['handler' => 'meuhandle']);

        $this->actingAs($user)
            ->put(route('profile'), ['name' => fake()->name(), 'handler' => 'meuhandle'])
            ->assertSessionHasNoErrors();
    }

    public function test_handler_e_normalizado(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('profile'), [
            'name' => fake()->name(),
            'handler' => '@MeuPerfil',
        ]);

        $this->assertSame('meuperfil', $user->fresh()->handler);
    }

    public function test_handler_em_formato_invalido_e_rejeitado(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('profile'))
            ->put(route('profile'), ['name' => fake()->name(), 'handler' => '1invalido'])
            ->assertSessionHasErrors('handler');
    }

    public function test_usuario_envia_foto_de_perfil(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('profile'), [
            'name' => fake()->name(),
            'handler' => 'comfoto',
            'photo' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $user->refresh();

        $this->assertNotNull($user->photo);
        Storage::disk('public')->assertExists($user->photo);
    }
}
