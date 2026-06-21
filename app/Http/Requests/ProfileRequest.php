<?php

namespace App\Http\Requests;

use App\Rules\CheckHandler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->handler) {
            $this->merge([
                'handler' => strtolower(ltrim($this->handler, '@')),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:30'],
            'description' => ['nullable'],
            'photo' => ['nullable', 'image'],
            'handler' => ['required', 'min:3', 'max:30', Rule::unique('users')->ignoreModel($this->user()), new CheckHandler],
        ];
    }
}
