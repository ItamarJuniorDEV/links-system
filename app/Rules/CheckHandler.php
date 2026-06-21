<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckHandler implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^[a-z][a-z0-9_.-]*$/', $value)) {
            $fail('O nome de usuário deve começar com uma letra e conter apenas letras minúsculas, números, ponto, hífen e underline.');
        }
    }
}
