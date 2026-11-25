<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendTender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notifikasi-tender';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim pesan Notifikasi Tender';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('masa_berlaku', '>=', Carbon::now())
            ->where('status', true)
            ->where('notif_telegram_tender', true)
            ->whereNotNull('telegram')
            ->get();
        // dd($users);

        $users->each(function ($user) {
            $user->notify(new \App\Notifications\TenderNotification());
        });
    }
}
