<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SignInController extends Controller
{
    public function page(): View
    {
        return view('auth.login');
    }

    public function handle(SignInFormRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors([
                    'email' => 'User not found',
                ])->onlyInput('email');
        }

        $request->session()
            ->regenerate();

        return redirect()
            ->intended(route('home'));
    }

    public function logOut(): RedirectResponse
    {
        auth()
            ->logout();

        request()
            ?->session()
            ->invalidate();

        request()
            ?->session()
            ->regenerateToken();

        return redirect()
            ->route('home');
    }
}
