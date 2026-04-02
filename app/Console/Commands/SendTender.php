<?php

namespace App\Console\Commands;

use App\Helpers\Helpers;
use App\Helpers\TableHelper;
use App\Helpers\TelegramHelper;
use App\Models\ErrorLog;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

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

        $users->each(function ($user) {
            $user->notify(new \App\Notifications\TenderNotification());
        });
    }
}
