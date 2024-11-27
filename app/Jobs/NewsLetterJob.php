<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\PostPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;

class NewsLetterJob implements ShouldQueue
{
    use Queueable;

    protected $post;

    /**
     * Create a new job instance.
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {


        $subscribers = User::where('is_subscribed', 1)->get();


        if (!$this->post->notified) {
            foreach ($subscribers as $subscriber) {
                    $subscriber->notify((new PostPublishedNotification($this->post)));
            }
            $this->post->update(['notified' => 1]);
        }
    }
}
