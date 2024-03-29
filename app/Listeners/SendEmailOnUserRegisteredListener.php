<?php

namespace App\Listeners;

use App\Notifications\NewUserNotification;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailOnUserRegisteredListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(Registered $event): void
    {
        $user = $this->getUser($event);
        $user->notify(new NewUserNotification());
    }

    private function getUser(Registered $event): User
    {
        return $event->user;
    }
}
