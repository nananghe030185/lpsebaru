<?php

namespace App\Console\Commands;

use App\Helpers\AppHelper;
use App\Helpers\Helpers;
use App\Helpers\TelegramHelper;
use App\Models\ErrorLog;
use App\Models\Inbox;
use App\Models\Outbox;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Client;
use TelegramBot\Api\Exception;
use TelegramBot\Api\Types\Update;

#[Signature('app:send-outbox')]
#[Description('Command description')]
class SendOutbox extends Command
{
    protected BotApi $botTele;
    protected Client $client;
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->initBot();
        $this->terima();
        $this->kirim();
    }

    public function initBot()
    {
        // $this->botTele = new BotApi(AppHelper::getTokenTelegram());
        $this->client = new Client(AppHelper::getTokenTelegram());
    }

    public function terima()
    {
        try{
            $bot = $this->client;
            $bot->command('ping', function($message) use ($bot){
                $bot->sendMessage($message->getChat()->getId(), 'pong');
            });

            $bot->on(function (Update $update) use ($bot){
                $message = $update->getMessage();
                $id = $message->getChat()->getId();
                // send message respon

                if($message == '/start'){
                    // langsung kirim pesan di outbox
                    Outbox::create([
                        'status' => 0, // artinya pesan belum terkirim
                        'recipient' => $id,
                        'message' => 'Selamat datang! Terima kasih telah memulai percakapan dengan bot LPSE Indonesia. Kami siap membantu Anda. 
Silakan ketikkan sesuai menu yang tersedia atau gunakan perintah /help untuk melihat daftar perintah yang dapat Anda gunakan.',
                        'channel' => 'telegram'
                    ]);
                }elseif($message == '/help'){
                    // langsung kirim pesan di outbox
                    Outbox::create([
                        'status' => 0, // artinya pesan belum terkirim
                        'recipient' => $id,
                        'message' => 'Berikut adalah beberapa perintah yang dapat Anda gunakan:
1. /start - Memulai percakapan dengan bot.
2. /help - Menampilkan daftar perintah yang tersedia.
3. /token - Mendapatkan token unik Anda untuk mengakses layanan bot.
4. /masaberlaku - Menampilkan informasi tentang masa berlaku keanggotaan Anda.',
                        'channel' => 'telegram'
                    ]);
                }elseif($message == '/token'){
                    //langsung kirim pesan di outbox
                    Outbox::create([
                        'status' => 0, // artinya pesan belum terkirim
                        'recipient' => $id,
                        'message' => 'Token Anda adalah: ' . $id,
                        'channel' => 'telegram'
                    ]);
                }else{
                    // diproses di inbox jika membutuhkan auto respon
                    Inbox::create([
                        'sender' => $id,
                        'message' => $message,
                        'channel' => 'telegram',
                        'status' => false, // artinya pesan belum diproses
                    ]);
                }
            }, function(){
                return true;
            });
             $bot->run();
        } catch(Exception $e){
            $e->getMessage();
        }

        // $updates = TelegramHelper::getUpdates();
        
        // masukan pesan ke inbox
//         foreach ($updates as $update) {
//             if (isset($update['message'])) {
//                 $message = $update['message'];
//                 $sender = $message['from']['id'];
//                 $text = $message['text'] ?? '';
//                 // simpan ke tabel inbox
//                 if($text == '/start'){
//                     // langsung kirim pesan di outbox
//                     Outbox::create([
//                         'status' => 0, // artinya pesan belum terkirim
//                         'recipient' => $sender,
//                         'message' => 'Selamat datang! Terima kasih telah memulai percakapan dengan bot LPSE Indonesia. Kami siap membantu Anda. 
// Silakan ketikkan sesuai menu yang tersedia atau gunakan perintah /help untuk melihat daftar perintah yang dapat Anda gunakan.',
//                         'channel' => 'telegram'
//                     ]);
//                 }elseif($text == '/help'){
//                     // langsung kirim pesan di outbox
//                     Outbox::create([
//                         'status' => 0, // artinya pesan belum terkirim
//                         'recipient' => $sender,
//                         'message' => 'Berikut adalah beberapa perintah yang dapat Anda gunakan:
// 1. /start - Memulai percakapan dengan bot.
// 2. /help - Menampilkan daftar perintah yang tersedia.
// 3. /token - Mendapatkan token unik Anda untuk mengakses layanan bot.
// 4. /masaberlaku - Menampilkan informasi tentang masa berlaku keanggotaan Anda.',
//                         'channel' => 'telegram'
//                     ]);
//                 }elseif($text == '/token'){
//                     //langsung kirim pesan di outbox
//                     Outbox::create([
//                         'status' => 0, // artinya pesan belum terkirim
//                         'recipient' => $sender,
//                         'message' => 'Token Anda adalah: ' . $sender,
//                         'channel' => 'telegram'
//                     ]);
//                 }else{
//                     // diproses di inbox jika membutuhkan auto respon
//                     Inbox::create([
//                         'sender' => $sender,
//                         'message' => $text,
//                         'channel' => 'telegram',
//                         'status' => false, // artinya pesan belum diproses
//                     ]);
//                 }
//             }
//         }

        // return $updates;
    }

    public function kirim()
    {
        // kirim pesan chanel telegram
        $outboxTele = Outbox::where('channel','telegram')->where('status', 0)->whereNotNull('recipient')->first();

        if(!$outboxTele) {
            return;
        }
        $outboxTele->message = preg_replace('/<span[^>]*>.*?<\/span>/is', '', $outboxTele->message);

        $this->client->sendMessage($outboxTele->recipient, $outboxTele->message);

        $outboxTele->status = 1;
        $outboxTele->save();
    }
}
