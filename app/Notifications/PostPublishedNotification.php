<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostPublishedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $post;
    /**
     * Create a new notification instance.
     */
    public function __construct($post)
    {
        $this->post = $post;
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
        return (new MailMessage)
            ->subject('Опубликована новая статья: ' . $this->post->title)
            ->greeting('Зравствуйте!')
            ->line('Опубликована новая статья:')
            ->line($this->post->title)
            ->action('Прочесть статью', url('/post/' . $this->post->slug))
            ->line('Если вы больше не хотите получать эти уведомления, вы можете отказаться от подписки ниже..')
            ->action('Отписаться', url('/unsubscribe/' . $notifiable->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
