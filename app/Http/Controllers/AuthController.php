<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordFromRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\SignInFromRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function index(): View
    {
        return view('auth.index');
    }

    public function signUp(): View
    {
        return view('auth.sign-up');
    }

    public function forgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function resetPassword(string $token): View
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function signIn(SignInFromRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'User not found',
            ])->onlyInput('email');
        }

        $request->session()
            ->regenerate();

        return redirect()
            ->intended(route('home'));
    }

    public function store(SignInFromRequest $request): RedirectResponse
    {
        $user = User::query()
            ->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);

        event(new Registered($user));

        auth()->login($user);

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

    public function forgot(ForgotPasswordFromRequest $request): RedirectResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['message' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function reset(ResetPasswordFormRequest $request): RedirectResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmed', 'token'),
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(str()->random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')
                ->with('message', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
