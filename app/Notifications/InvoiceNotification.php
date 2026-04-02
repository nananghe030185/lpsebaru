<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class InvoiceNotification extends Notification
{
    use Queueable;
    
    /**
     * Create a new notification instance.
     */
    public function __construct(private $invoice)
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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->view('admin.invoice.invoice', [
            'invoice' => $this->invoice,
        ])
            ->subject('Pembayaran Invoice #' . $this->invoice->nomer)
            ->line('Pembayaran Invoice #' . $this->invoice->nomer . ' telah diterima.')
            // ->action('View Invoice', url('/invoices/' . $this->invoice->id))
            ->line('Terima kasih telah menggunakan layanan kami!');
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
        if (!$notifiable->telegram) {
            return;
        }
        return TelegramMessage::create()
            ->to($notifiable->telegram) // pastikan user punya field ini
            ->content("Pembayaran sebesar {$this->invoice->total} telah di terima untuk invoice #{$this->invoice->nomer}. Masa berlaku akun anda telah di perpanjang selama {$this->invoice->durasi} hari.");
    }
}
