<?php

namespace App\Console\Commands;

use App\Helpers\TelegramHelper;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class Admin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // User::create([
        //     'name' => 'Admin',
        //     'usermame' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('admin123'),
        //     'status' => true,
        //     'group_id' => 1, // Assuming group_id 1 exists
        //     'system_reserve' => 1
        // ]);
        $user = User::find(1);
        $data = ['satu', 'dua', 'tiga', 'empat', 'lima'];
        if ($user->notif_telegram_tender){
            foreach ($data as $item) {
                TelegramHelper::sendMessage($user->telegram, 'Tender' . ' ' . $item);
            }
        }

        if ($user->notif_telegram_lelang){
            foreach ($data as $item) {
                TelegramHelper::sendMessage($user->telegram, 'Lelang' . ' ' . $item);
            }
        }
        

    }
}
