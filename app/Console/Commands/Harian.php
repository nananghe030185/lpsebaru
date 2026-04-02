<?php

namespace App\Console\Commands;

use App\Helpers\AppHelper;
use App\Models\User;
use App\Notifications\MessageNotification;
use App\Notifications\TenderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Harian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:harian';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah yang di jalankan setiap hari';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->reminder();
    }

    public function reminder()
    {
        $daybefore = AppHelper::getReminderExpired();
        $users = User::all();
        $users->each(function ($user) use ($daybefore){
            // if(now()->diffInDays($user->masa_berlaku) == $daybefore)
            //     {
                    $user->notify(new MessageNotification($this->pesanReminder($daybefore)));
                // }
        });
    }

    public function pesanReminder($daybefore)
    {
        return 'Masa Berlaku Keanggotaan anda akan berakhir dalam ' . $daybefore . ' hari, silahkan lakukan pembayaran untuk tetap menikmati fitur dari ' . config('app.name');
    }
}
