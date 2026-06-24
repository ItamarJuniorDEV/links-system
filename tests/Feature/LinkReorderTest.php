<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkReorderTest extends TestCase
{
    use RefreshDatabase;

    public function test_move_down_troca_a_posicao_com_o_proximo(): void
    {
        $user = User::factory()->create();
        $primeiro = Link::factory()->for($user)->create(['sort' => 1]);
        $segundo = Link::factory()->for($user)->create(['sort' => 2]);

        $primeiro->moveDown();

        $this->assertSame(2, $primeiro->fresh()->sort);
        $this->assertSame(1, $segundo->fresh()->sort);
    }

    public function test_move_up_troca_a_posicao_com_o_anterior(): void
    {
        $user = User::factory()->create();
        $primeiro = Link::factory()->for($user)->create(['sort' => 1]);
        $segundo = Link::factory()->for($user)->create(['sort' => 2]);

        $segundo->moveUp();

        $this->assertSame(1, $segundo->fresh()->sort);
        $this->assertSame(2, $primeiro->fresh()->sort);
    }

    public function test_move_up_no_primeiro_nao_faz_nada(): void
    {
        $user = User::factory()->create();
        $primeiro = Link::factory()->for($user)->create(['sort' => 1]);

        $primeiro->moveUp();

        $this->assertSame(1, $primeiro->fresh()->sort);
    }

    public function test_move_down_no_ultimo_nao_faz_nada(): void
    {
        $user = User::factory()->create();
        $unico = Link::factory()->for($user)->create(['sort' => 1]);

        $unico->moveDown();

        $this->assertSame(1, $unico->fresh()->sort);
    }

    public function test_rota_up_reordena_e_volta(): void
    {
        $user = User::factory()->create();
        $primeiro = Link::factory()->for($user)->create(['sort' => 1]);
        $segundo = Link::factory()->for($user)->create(['sort' => 2]);

        $this->actingAs($user)
            ->patch(route('links.up', $segundo))
            ->assertRedirect();

        $this->assertSame(1, $segundo->fresh()->sort);
        $this->assertSame(2, $primeiro->fresh()->sort);
    }
}
