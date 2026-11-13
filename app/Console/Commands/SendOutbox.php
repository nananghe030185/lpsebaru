<?php

namespace App\Console\Commands;

use App\Helpers\Helpers;
use App\Helpers\TelegramHelper;
use App\Models\ErrorLog;
use App\Models\Inbox;
use App\Models\Outbox;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:send-outbox')]
#[Description('Command description')]
class SendOutbox extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->terima();
        $this->kirim();
    }

    public function terima()
    {
        $updates = TelegramHelper::getUpdates();
        
        // masukan pesan ke inbox
        foreach ($updates as $update) {
            if (isset($update['message'])) {
                $message = $update['message'];
                $sender = $message['from']['id'];
                $text = $message['text'] ?? '';
                // simpan ke tabel inbox
                if($text == '/start'){
                    // langsung kirim pesan di outbox
                    Outbox::create([
                        'status' => 0, // artinya pesan belum terkirim
                        'recipient' => $sender,
                        'message' => 'Selamat datang! Terima kasih telah memulai percakapan dengan bot LPSE Indonesia. Kami siap membantu Anda. 
Silakan ketikkan sesuai menu yang tersedia atau gunakan perintah /help untuk melihat daftar perintah yang dapat Anda gunakan.',
                        'channel' => 'telegram'
                    ]);
                }elseif($text == '/help'){
                    // langsung kirim pesan di outbox
                    Outbox::create([
                        'status' => 0, // artinya pesan belum terkirim
                        'recipient' => $sender,
                        'message' => 'Berikut adalah beberapa perintah yang dapat Anda gunakan:
1. /start - Memulai percakapan dengan bot.
2. /help - Menampilkan daftar perintah yang tersedia.
3. /token - Mendapatkan token unik Anda untuk mengakses layanan bot.
4. /masaberlaku - Menampilkan informasi tentang masa berlaku keanggotaan Anda.',
                        'channel' => 'telegram'
                    ]);
                }elseif($text == '/token'){
                    //langsung kirim pesan di outbox
                    Outbox::create([
                        'status' => 0, // artinya pesan belum terkirim
                        'recipient' => $sender,
                        'message' => 'Token Anda adalah: ' . $sender,
                        'channel' => 'telegram'
                    ]);
                }else{
                    // diproses di inbox jika membutuhkan auto respon
                    Inbox::create([
                        'sender' => $sender,
                        'message' => $text,
                        'channel' => 'telegram',
                        'status' => true, // artinya pesan belum diproses
                    ]);
                }
            }
        }

        return $updates;
    }

    public function kirim()
    {
        // kirim pesan chanel telegram
        $outboxTele = Outbox::where('channel','telegram')->where('status', 0)->whereNotNull('recipient')->first();

        if(!$outboxTele) {
            return;
        }
        $outboxTele->message = preg_replace('/<span[^>]*>.*?<\/span>/is', '', $outboxTele->message);
        // $message = strip_tags($outboxTele->message, '<b><i><u><a><code><pre>'); // remove html tags except for <b>, <i>, <u>, <a>, <code>, and <pre>
dump($outboxTele->message);
        $responTele = TelegramHelper::sendMessage($outboxTele->recipient, $outboxTele->message);

        // update status to 1 if message sent successfully
        if (isset($responTele['message_id'])) {
            $outboxTele->status = 1;
            $outboxTele->save();
        } else {
            // update status 2 jika gagal
            Helpers::createErrorLog($responTele['error'],'');
            $outboxTele->status = 2;
            $outboxTele->save();
        }
    }
}
