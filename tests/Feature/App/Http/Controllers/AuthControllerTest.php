<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailOnUserRegisteredListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     **/
    public function it_login_page_success(): void
    {
        echo "SignInController->page";
        $this->get(action([
            SignInController::class,
            'page'
        ]))->assertOk()
            ->assertViewIs('auth.login');
    }

    /**
     * @test
     * @return void
     **/
    public function it_sign_up_success(): void
    {
        echo "SignUpController->page";
        $this->get(action([
            SignUpController::class,
            'page'
        ]))->assertOk()
            ->assertViewIs('auth.sign-up');
    }

    /**
     * @test
     * @return void
     **/
    public function it_forgot_page_success(): void
    {
        echo "ForgotPasswordController->page";
        $this->get(action([
            ForgotPasswordController::class,
            'page'
        ]))->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    /**
     * @test
     * @return void
     **/
    public function it_store_success(): void
    {
        echo "SignUpController->handle";
        Notification::fake();
        Event::fake();

        $request = SignUpFormRequest::factory()->create([
            'email' => 'sultonovanboz@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => $request['email'],
        ]);

        $response = $this->post(
            action([SignUpController::class, 'handle']),
            $request
        );

        $this->assertDatabaseHas('users', [
            'email' => $request['email'],
        ]);

        $user = User::query()
            ->where('email', '=', $request['email'])
            ->first();

        Event::assertDispatched(Registered::class);

        Event::assertListening(Registered::class, SendEmailOnUserRegisteredListener::class);

        $event = new Registered($user);
        $listener = new SendEmailOnUserRegisteredListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertValid()
            ->assertRedirect(route('home'));
    }

    /**
     * @test
     * @return void
     **/
    public function it_sign_in_success(): void
    {
        echo "SignInController->handle";

        $password = '123456789';

        $user = UserFactory::new()->create([
            'password' => bcrypt($password)
        ]);

        $request = SignInFormRequest::factory()->create([
            'email' => $user->email,
            'password' => $password,
        ]);

        $response = $this->post(action([SignInController::class, 'handle']), $request);

        $response->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }
}
