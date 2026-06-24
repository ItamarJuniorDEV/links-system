<?php

namespace Tests\Unit;

use App\Rules\CheckHandler;
use PHPUnit\Framework\TestCase;

class CheckHandlerTest extends TestCase
{
    private function reprova(string $valor): bool
    {
        $reprovou = false;

        (new CheckHandler())->validate('handler', $valor, function () use (&$reprovou) {
            $reprovou = true;
        });

        return $reprovou;
    }

    public function test_aceita_handles_validos(): void
    {
        foreach (['dev_jr', 'studio.23', 'a-b-c'] as $valor) {
            $this->assertFalse($this->reprova($valor), "deveria aceitar: {$valor}");
        }
    }

    public function test_rejeita_handles_invalidos(): void
    {
        foreach (['1abc', 'Abc', 'a b', 'user@', ''] as $valor) {
            $this->assertTrue($this->reprova($valor), "deveria rejeitar: {$valor}");
        }
    }
}
