<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $admin = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin2');
        })->first();

        if ($admin) {
            $admin->notify(new NewUserNotification($event->user));
        }
    }
}
