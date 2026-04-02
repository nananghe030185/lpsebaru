<?php

namespace App\Notifications;

use App\Helpers\TableHelper;
use App\Mail\TenderMail;
use App\Models\ErrorLog;
use App\Models\Notification as ModelsNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\View;
use NotificationChannels\Telegram\TelegramMessage;

class TenderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
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
        $tenders = ModelsNotification::where('user_id', $notifiable->id)
                    ->where('channel', 'email')
                    ->where('status', 'unread')
                    ->limit(5)->get();

        return (new TenderMail($tenders))
                
                ->view('admin.template.email-tender',[
                    'datas' => $tenders
                ])
                // ->from(config('mail.from.address'), config('mail.from.name'))
                ->to('abah.daaim@gmail.com');
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

        $telegrams = ModelsNotification::where('user_id', $notifiable->id)->where('channel', 'telegram')->where('status', 'unread')->limit(5)->get();
        $messages = 'Berikut paket tender LPSE yang tayang hari ini '. "\n" . Carbon::now()->format('d-m-Y') . ":\n\n";

        foreach ($telegrams as $n => $tele) {
            $id[] = $tele->id;
            $messages .= View::make('admin.template.telegram', [
                            'no' => $n + 1,
                            'redirect' => route('redirect.tender', ['tender' => $tele->tender]),
                            'nama_paket' => $tele->tender->nama_paket,
                            'link' => $tele->tender->lpse->link,
                            'tender_id' => $tele->tender->tender_id,
                            'hps' => TableHelper::nominal_simple($tele->tender->hps),
                            'nama_lpse' => $tele->tender->lpse->nama_lpse,
                        ])->render() . "\n";
        }

        // ModelsNotification::destroy($id);

        if(!$telegrams->count()){
            return;
        }
        return TelegramMessage::create()
            ->to($notifiable->telegram) // pastikan user punya field ini
            ->content($messages)
            ->parseMode('HTML')
            ->onError(function ($data){
                ErrorLog::create([
                    'message' => 'Failed to send Telegram notification Chat ID : ' . $data['to'] .' ' . $data['exception']->getMessage()
                ]);
            });
    }
}
