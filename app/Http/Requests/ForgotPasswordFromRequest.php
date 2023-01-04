<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class ForgotPasswordFromRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guest();
    }

    #[ArrayShape([
        'email' => "string",
    ])]
    public function rules(): array
    {
        return [
            'email' => 'required|email:dns',
        ];
    }
}
