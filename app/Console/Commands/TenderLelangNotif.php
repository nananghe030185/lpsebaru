<?php

namespace App\Console\Commands;

use App\Helpers\Helpers;
use App\Helpers\TableHelper;
use App\Models\Notification;
use App\Models\NotificationLelang;
use App\Models\Outbox;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:tender-lelang-notif')]
#[Description('Perintah untuk mengenerate 5 pesan tender dan lelang untuk dikirim di outbox')]
class TenderLelangNotif extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        // ================= Tender LPSE Notif ===========
        $this->tenderNotif();
        // ================= Tender LPSE Notif ===========
        $this->lelangNotif();
    }

    public function tenderNotif()
    {
        // dapatkan user iD unik
        $usersNotif = Notification::select('user_id')->distinct()->get();
        
        foreach($usersNotif as $i => $user){
            
            $user = User::find($user->user_id);

            $notifTeles = Notification::where('status', 'unread')->where('channel', 'telegram')->where('user_id', $user->id)->take(5)->get();

            if(count($notifTeles) > 0)
                {
                    $message = "Berikut adalah data LPSE yang tayang pada hari ini " . now()->format('d/m/Y') . ':

';
                    foreach($notifTeles as $j => $notifTele){
$message .= $j+1 . '. ' . Helpers::link(url('/r/tender\/') . $notifTele->tender->slug, $notifTele->tender->nama_paket) .'
Kode Tender   :  ' . $notifTele->tender->tender_id.'
HPS                  :  '. TableHelper::nominal_simple($notifTele->tender->hps) . '
Nama LPSE    :  ' . Helpers::link($notifTele->tender->lpse->link, $notifTele->tender->lpse->nama_lpse) . '
Tahap Tender :  ' . $notifTele->tender->tahap_tender . '

';
                        // update notif jadi di baca
                        $notifTele->status = 'read';
                        $notifTele->save();
                    }
                    $message .= 'Salam
' . Helpers::link(url('/'), 'LPSE Indonesia');
                    // masukan ke outbox untuk dikiirm
                    Outbox::create([
                        'recipient' => $user->telegram,
                        'message' => $message,
                        'channel' => 'telegram',
                        'status' => 0
                    ]);
                }
        }
    }

    public function lelangNotif()
    {
        // dapatkan user iD unik
        $usersNotif = NotificationLelang::select('user_id')->distinct()->get();
        
        foreach($usersNotif as $i => $user){
            
            $user = User::find($user->user_id);

            $notifTeles = NotificationLelang::where('status', 'unread')->where('channel', 'telegram')->where('user_id', $user->id)->take(5)->get();

            if(count($notifTeles) > 0)
                {
                    $message = "Berikut adalah data lelang SIRUP yang bisa anda siapkan mulai " . now()->format('d/m/Y') . ':

';
                    foreach($notifTeles as $j => $notifTele){
                        $message .= $j+1 . '. ' . Helpers::link(url('/r/lelang\/') . $notifTele->lelang->slug, $notifTele->lelang->nama_paket) .'
Kode RUP      : ' . $notifTele->lelang->kode_rup.'
Pagu           : '. TableHelper::nominal_simple($notifTele->lelang->pagu). '
Nama KLPDI  : ' . $notifTele->lelang->klpdi . '
Jenis Pengadaan : '. $notifTele->lelang->jenis_pengadaan .'
Metode    : '. $notifTele->lelang->metode .'
Lokasi           : '. $notifTele->lelang->lokasi .'

';

                        // update notif jadi di baca
                        $notifTele->status = 'read';
                        $notifTele->save();
                    }

                    $message .= 'Salam
' . Helpers::link(url('/'),'LPSE Indonesia');
                    // masukan ke outbox untuk dikiirm
                    Outbox::create([
                        'recipient' => $user->telegram,
                        'message' => $message,
                        'channel' => 'telegram',
                        'status' => 0
                    ]);
                }
        }
    }
}
