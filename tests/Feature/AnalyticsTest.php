<?php

namespace Tests\Feature;

use App\Models\Click;
use App\Models\Link;
use App\Models\ProfileView;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_painel_mostra_os_numeros_do_usuario(): void
    {
        $user = User::factory()->createOne();
        $link = Link::factory()->for($user)->create();
        Click::factory()->count(3)->for($link)->create();
        ProfileView::factory()->count(2)->for($user)->create();

        $this->actingAs($user)
            ->get(route('analytics'))
            ->assertOk()
            ->assertViewHas('stats', fn (array $stats) => $stats['clicks'] === 3 && $stats['views'] === 2);
    }

    public function test_estatisticas_sao_apenas_do_proprio_usuario(): void
    {
        $user = User::factory()->create();
        $alheio = Link::factory()->for(User::factory())->create();
        Click::factory()->for($alheio)->create();

        $this->actingAs($user)
            ->get(route('analytics'))
            ->assertViewHas('stats', fn (array $stats) => $stats['clicks'] === 0);
    }

    public function test_visitante_nao_acessa_as_estatisticas(): void
    {
        $this->get(route('analytics'))->assertRedirect(route('login'));
    }
}
