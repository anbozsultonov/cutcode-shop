<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class SignInFromRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guest();
    }

    #[ArrayShape([
        'email' => "string",
        'password' => "string"
    ])]
    public function rules(): array
    {
        return [
            'email' => 'required|email:dns',
            'password' => 'required'
        ];
    }
}
