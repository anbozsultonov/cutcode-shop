<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordFromRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    public function page(): View
    {
        return view('auth.forgot-password');
    }

    public function handle(ForgotPasswordFromRequest $request): RedirectResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            flash()->info(__($status));

            return back();
        }

        return back()
            ->withErrors(['email' => __($status)]);
    }
}
