<?php

namespace Domain\Auth\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\AuthController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class AuthRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::controller(SignInController::class)->group(function () {
                Route::middleware('guest')->group(function () {
                    Route::get('/login', 'page')
                        ->name('login');
                    Route::post('/sign-in', 'handle')
                        ->middleware('throttle:auth')
                        ->name('signIn');
                });

                Route::middleware(['auth'])->group(function () {
                    Route::delete('/logout', 'logOut')
                        ->name('logOut');
                });
            });

            Route::controller(SignUpController::class)->group(function () {
                Route::get('/sign-up', 'page')
                    ->name('signUp');
                Route::post('/sign-up', 'handle')
                    ->middleware('throttle:auth')
                    ->name('storeUser');
            });

            Route::controller(ForgotPasswordController::class)->group(function () {
                Route::get('/forgot-password', 'page')
                    ->name('forgotPassword');

                Route::post('/forgot-password', 'handle')
                    ->name('password.forgot');
            });

            Route::controller(ResetPasswordController::class)->group(function () {
                Route::get('/reset-password/{token}', 'page')
                    ->name('password.reset');
                Route::post('/reset-password', 'handle')
                    ->name('password.update');
            });

            Route::controller(SocialAuthController::class)->group(function () {
                Route::middleware('guest')
                    ->group(function () {
                        Route::get('/auth/socialite/{driver}', 'page')
                            ->name('socialite');
                        Route::get('/auth/socialite/{driver}/callback', 'handle')
                            ->name('socialite.callback');
                    });
            });
        });
    }
}
