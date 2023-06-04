<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Auth\Models\User;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function page(string $driver): RedirectResponse
    {
        try {
            return Socialite::driver($driver)->redirect();
        } catch (\Throwable $e) {
            throw new \DomainException('Произашло ошибкаб или драйвер не поддерживается');
        }
    }

    public function handle(string $driver): RedirectResponse
    {
        if ($driver !== config('auth.socialite_drivers.github')) {
            throw new \DomainException('Драйвер не поддерживается');
        }

        $githubUser = Socialite::driver($driver)->user();

        $user = User::query()
            ->updateOrCreate([
                $driver . '_id' => $githubUser->id,
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
