<?php

namespace App\Listeners;

use App\Events\NewCommentAdded;
use App\Models\User;
use App\Notifications\NewCommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminOfNewComment
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
    public function handle(NewCommentAdded $event): void
    {
        $admin = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin2');
        })->first();

        if ($admin) {
            $admin->notify(new NewCommentNotification($event->comment));
        }
    }
}
