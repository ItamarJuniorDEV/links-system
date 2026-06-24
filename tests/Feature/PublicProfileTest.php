<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_pagina_publica_mostra_perfil_e_links(): void
    {
        $user = User::factory()->create(['handler' => 'paginateste']);
        Link::factory()->for($user)->create(['name' => 'Meu site', 'sort' => 1]);
        Link::factory()->for($user)->create(['name' => 'Meu canal', 'sort' => 2]);

        $this->get(route('profiles.show', $user->handler))
            ->assertOk()
            ->assertSee($user->name)
            ->assertSee('Meu site')
            ->assertSee('Meu canal');
    }

    public function test_handler_inexistente_da_404(): void
    {
        $this->get(route('profiles.show', 'naoexiste'))->assertNotFound();
    }
}
