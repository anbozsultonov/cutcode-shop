<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordFromRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\SignInFromRequest;
use App\Http\Requests\SignUpFromRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

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

    public function store(SignUpFromRequest $request): RedirectResponse
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

        if ($status === Password::RESET_LINK_SENT) {
            flash()->info(__($status));

            return back();
        }

        return back()
            ->withErrors(['email' => __($status)]);
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
        if ($status === Password::PASSWORD_RESET) {
            flash()->alert(__($status));

            return redirect()->route('login');
        }

        return back()
            ->withErrors(['email' => [__($status)]]);
    }

    public function github(): RedirectResponse
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback(): RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();

        //TODO
        $user = User::query()
            ->updateOrCreate([
                'github_id' => $githubUser->id,
            ], [
                'name' => $githubUser->nickname,
                'email' => $githubUser->email,
                'password' => bcrypt(str()->random(8))
            ]);

        auth()->login($user);

        return redirect()
            ->intended(route('home'));

    }


}
