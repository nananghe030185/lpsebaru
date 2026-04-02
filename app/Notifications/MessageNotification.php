<?php

namespace App\Notifications;

use App\Mail\MessageMail;
use App\Models\ErrorLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class MessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Private $messages)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','telegram'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): Mailable
    {
        return (new MessageMail)
            ->to('abah.daaim@gmail.com')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->view('mail.message-mail', [
                'messages' => $this->messages
            ]);
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

    /**
     * Kirim notifikasi ke Telegram.
     */
    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->telegram) // pastikan user punya field ini
            ->content($this->messages)
            ->parseMode('HTML')
            ->onError(function ($data){
                ErrorLog::create([
                    'message' => 'Failed to send Telegram notification Chat ID : ' . $data['to'] .' ' . $data['exception']->getMessage()
                ]);
            });
    }
}
