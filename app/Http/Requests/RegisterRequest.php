<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'confirmed', 'unique:users'],
            'password' => ['required', Password::defaults()],
        ];
    }

    public function tryToRegister()
    {
        $user = User::query()->create($this->validated());
        event(new Registered($user));
        Auth::login($user);

        return true;
    }
}
