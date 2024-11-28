<?php

namespace App\Listeners;

use App\Events\NewCommentAdded;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\NewCommentNotification;
use App\Notifications\ReplyToCommentNotification;
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

        $parentCommentID = $event->comment->parent_id;

        if ($parentCommentID) {
         $comment = Comment::query()->where('id', '=', $parentCommentID)->first();
         $author = User::query()->where('id', '=', $comment->user_id)->first();

            if ($author && $author->id !== $event->comment->user_id) {
                $author->notify(new ReplyToCommentNotification($event->comment, $comment));
            }
        }

        if ($admin && !$parentCommentID) {
            $admin->notify(new NewCommentNotification($event->comment));
        }
    }
}
