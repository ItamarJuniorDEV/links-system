<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_dono_consegue_editar_o_proprio_link(): void
    {
        $user = User::factory()->create();
        $link = Link::factory()->for($user)->create();

        $this->actingAs($user)
            ->get(route('links.edit', $link))
            ->assertOk();
    }

    public function test_dono_consegue_excluir_o_proprio_link(): void
    {
        $user = User::factory()->create();
        $link = Link::factory()->for($user)->create();

        $this->actingAs($user)
            ->delete(route('links.destroy', $link))
            ->assertRedirect(route('dashboard'));

        $this->assertSoftDeleted($link);
    }

    public function test_nao_dono_nao_pode_editar_link_alheio(): void
    {
        $link = Link::factory()->for(User::factory())->create();

        $this->actingAs(User::factory()->create())
            ->get(route('links.edit', $link))
            ->assertForbidden();
    }

    public function test_nao_dono_nao_pode_excluir_link_alheio(): void
    {
        $link = Link::factory()->for(User::factory())->create();

        $this->actingAs(User::factory()->create())
            ->delete(route('links.destroy', $link))
            ->assertForbidden();

        $this->assertModelExists($link);
    }

    public function test_nao_dono_nao_pode_reordenar_link_alheio(): void
    {
        $link = Link::factory()->for(User::factory())->create(['sort' => 1]);

        $this->actingAs(User::factory()->create())
            ->patch(route('links.up', $link))
            ->assertForbidden();
    }

    public function test_visitante_e_redirecionado_para_login(): void
    {
        $link = Link::factory()->for(User::factory())->create();

        $this->get(route('links.edit', $link))
            ->assertRedirect(route('login'));
    }
}
