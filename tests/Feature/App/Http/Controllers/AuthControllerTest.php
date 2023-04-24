<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpFromRequest;
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
    public function it_store_success(): void
    {
        Notification::fake();
        Event::fake();

        $request = SignUpFromRequest::factory()->create([
            'email' => 'sultonovanboz@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => $request['email'],
        ]);

        $response = $this->post(
            action([AuthController::class, 'store']),
            $request
        );

        $this->assertDatabaseHas('users', [
            'email' => $request['email'],
        ]);

        $response->assertValid()
            ->assertRedirect(route('home'));
    }
}
