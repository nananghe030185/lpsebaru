<?php

namespace App\Console\Commands;

use App\Models\ErrorLog;
use App\Models\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class KirimMailTender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:kirim-mail-tender';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email tender yang belum dibaca';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user_id = 1; // Ganti dengan ID pengguna yang sesuai
        $tenders = Notification::where('user_id', $user_id)
                    ->where('channel', 'email')
                    ->where('status', 'unread')
                    ->limit(5)->get(['*']);

        try {
            $mail = Mail::to('abah.daaim@gmail.com');
            $mail->send(new \App\Mail\TenderMail($tenders));

            // update status notification
            $tenders->each(function ($tender) {
                $tender->update(['status' => 'read']);
            });

            // if (Mail::failures()) {
            //     $this->error('Gagal mengirim email tender.');
            //     return;
            // }
        } catch (\Exception $e) {
            ErrorLog::create([
                'message' => Str::limit('Gagal mengirim email tender: ' . $e->getMessage(), 490),
            ]);

            $tenders->each(function ($tender) {
                $tender->update(['status' => 'error']);
            });

            $this->error('Terjadi kesalahan saat mengambil data tender: ' . $e->getMessage());
            return;
        }
        
    }
}
