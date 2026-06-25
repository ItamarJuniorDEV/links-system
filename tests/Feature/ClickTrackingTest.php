<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClickTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_clique_registra_e_redireciona_para_o_destino(): void
    {
        $this->withoutDefer();
        $link = Link::factory()->for(User::factory())->create(['link' => 'https://exemplo.dev/pagina']);

        $this->get(route('links.go', $link))
            ->assertRedirect('https://exemplo.dev/pagina');

        $this->assertDatabaseHas('clicks', ['link_id' => $link->id]);
    }

    public function test_visita_ao_perfil_publico_e_registrada(): void
    {
        $this->withoutDefer();
        $user = User::factory()->create(['handler' => 'visitado']);

        $this->get(route('profiles.show', $user->handler))->assertOk();

        $this->assertDatabaseHas('profile_views', ['user_id' => $user->id]);
    }
}
