<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_cria_um_link(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('links.create'), [
                'name' => 'Portfolio',
                'link' => 'https://github.com',
            ])
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('links', [
            'user_id' => $user->id,
            'name' => 'Portfolio',
            'link' => 'https://github.com',
        ]);
    }

    public function test_novo_link_recebe_o_proximo_sort(): void
    {
        $user = User::factory()->create();
        Link::factory()->for($user)->create(['sort' => 1]);
        Link::factory()->for($user)->create(['sort' => 2]);

        $this->actingAs($user)
            ->post(route('links.create'), [
                'name' => 'Mais um',
                'link' => 'https://exemplo.dev',
            ]);

        $this->assertDatabaseHas('links', [
            'name' => 'Mais um',
            'sort' => 3,
        ]);
    }

    public function test_link_invalido_nao_e_salvo(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('links.create'), [
                'name' => 'ab',
                'link' => 'isso-nao-e-url',
            ])
            ->assertSessionHasErrors(['name', 'link']);

        $this->assertDatabaseCount('links', 0);
    }

    public function test_usuario_atualiza_o_proprio_link(): void
    {
        $user = User::factory()->create();
        $link = Link::factory()->for($user)->create();

        $this->actingAs($user)
            ->put(route('links.edit', $link), [
                'name' => 'Novo nome',
                'link' => 'https://novo.dev',
            ])
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('links', [
            'id' => $link->id,
            'name' => 'Novo nome',
            'link' => 'https://novo.dev',
        ]);
    }

    public function test_usuario_exclui_o_proprio_link(): void
    {
        $user = User::factory()->create();
        $link = Link::factory()->for($user)->create();

        $this->actingAs($user)
            ->delete(route('links.destroy', $link));

        $this->assertSoftDeleted($link);
    }
}
