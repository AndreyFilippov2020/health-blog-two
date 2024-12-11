<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReplyToCommentNotification extends Notification
{
    use Queueable;


    protected $replyComment;
    protected $parentComment;
    /**
     * Create a new notification instance.
     */
    public function __construct($replyComment, $parentComment)
    {
        $this->replyComment = $replyComment;
        $this->parentComment = $parentComment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $post = Post::find($this->replyComment->post_id);

        return (new MailMessage)
            ->subject('Новый ответ на ваш комментарий')
            ->greeting('Здравствуйте ' . $notifiable->name . ',')
            ->line('Админ ответил на ваш комментарий:')
            ->line('Ваш комментарий: ' . $this->parentComment->comment)
            ->line('Ответ: ' . $this->replyComment->comment)
            ->line('Статья: ' . $post->title)
            ->action('Посмотреть комментарий', url('/post/' . $post->slug . '#comment-' . $this->replyComment->id))
            ->line('Спасибо за участие в обсуждении!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'reply_comment_id' => $this->replyComment->id,
            'parent_comment_id' => $this->parentComment->id,
            'post_id' => $this->replyComment->post_id,
        ];
    }
}
