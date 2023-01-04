<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use JetBrains\PhpStorm\ArrayShape;

class SignUpFromRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guest();
    }

    #[ArrayShape([
        'email' => "string",
        'name' => "string",
        'password' => "array"
    ])]
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email:dns',
                'unique:users,email',
            ],
            'name' => [
                'required',
                'string', 'min:1'],
            'password' => [
                'required',
                'confirmed',
                Password::default(),
            ]
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => str($this->input('email'))
                ->squish()
                ->lower()
                ->value()
        ]);
    }
}
