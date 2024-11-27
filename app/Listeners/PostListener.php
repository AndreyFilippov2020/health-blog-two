<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Models\User;
use App\Notifications\PostPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;

class PostListener implements ShouldQueue
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
    public function handle(PostCreated $event): void
    {
        $post = $event->post;

        $subscribers = User::where('is_subscribed', 1)->get();


        if(!$post->notified) {
            foreach ($subscribers as $subscriber) {
                if (Carbon::parse($post->published_at) ->greaterThan(Carbon::now())) {
                    $delay = Carbon::now()->diffInSeconds(Carbon::parse($post->published_at));
                    $subscriber->notify((new PostPublishedNotification($post))->delay($delay));
                } else {
                    $subscriber->notify(new PostPublishedNotification($post));
                }
            }
            $post->update(['notified' => 1]);
        }
    }
}
