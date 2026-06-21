<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:30'],
            'description' => ['nullable'],
            'photo' => ['nullable', 'image'],
            'handler' => ['required', Rule::unique('users')->ignoreModel($this->user())],
        ];
    }
}
