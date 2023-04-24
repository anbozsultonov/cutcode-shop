<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class)->name('home');

Route::controller(AuthController::class)
    ->group(function () {
        Route::middleware('guest')
            ->group(function () {
                Route::get('/login', 'index')
                    ->name('login');
                Route::get('/sign-up', 'signUp')
                    ->name('signUp');
                Route::get('/forgot-password', 'forgotPassword')
                    ->name('forgotPassword');
                Route::get('/reset-password/{token}', 'resetPassword')
                    ->name('password.reset');

                Route::post('/sign-in', 'signIn')
                    ->middleware('throttle:auth')
                    ->name('signIn');
                Route::post('/sign-up', 'store')
                    ->middleware('throttle:auth')
                    ->name('storeUser');
                Route::post('/forgot-password', 'forgot')
                    ->name('password.forgot');
                Route::post('/reset-password', 'reset')
                    ->name('password.update');


                Route::get('/auth/socialite/github', 'github')
                    ->name('socialite.github');

                Route::get('/auth/socialite/github/callback', 'githubCallback')
                    ->name('socialite.github.callback');
            });

        Route::middleware(['auth'])
            ->group(function () {
                Route::delete('/logout', 'logOut')
                    ->name('logOut');
            });
    });





