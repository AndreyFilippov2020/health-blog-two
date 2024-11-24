<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\User;
use App\Notifications\PostPublishedNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class PublishPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish active posts by date and notify subscribers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        // Найти активные посты, которые должны быть опубликованы
        $posts = Post::where('active', '=', true)
            ->where('published_at', '!=', NULL)
//            ->where('published_at', '<=', $now)
            ->where('notified', '=', false)
            ->get();



        foreach ($posts as $post) {
            // Получить всех подписчиков
            $subscribers = User::where('is_subscribed', true)->get();

            foreach ($subscribers as $subscriber) {
                $subscriber->notify(new PostPublishedNotification($post));
            }

            // Пометить пост как уведомлённый
            $post->update(['notified' => true]);
        }

        $this->info('Notifications sent for published posts.');
    }
}
