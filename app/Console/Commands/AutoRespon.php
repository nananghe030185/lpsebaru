<?php

namespace App\Console\Commands;

use App\Models\AutoRespon as ModelsAutoRespon;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AutoRespon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-respon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah untuk mengirimkan balasan otomatis berdasarkan pesan masuk tertentu.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $inbox = \App\Models\Inbox::where('status', false)->first();
        if($inbox){
            if($response = $this->response($inbox)){
                $outbox = new \App\Models\Outbox();
                $outbox->recipient = $inbox->sender;
                $outbox->message = $this->replaceparams($inbox->sender, $response);
                $outbox->channel = $inbox->channel;
                $outbox->status = false;
                $outbox->save();

                $inbox->status = true;
                $inbox->save();
            }else{
                //jika tidak ada keyword
                $inbox->status = true;
                $inbox->save();
            }
        }
    }

    /**
     * Get response based on keyword
     */
    public function response($inbox)
    {
        $arrs = Str::of($inbox->message)->explode('#');

        // Jika inbox merupakan pesan whatsapp
        if($inbox->channel == 'whatsapp'){
            $msgrespon = ModelsAutoRespon::where('keyword', 'like', '%' . Str::lower($arrs[0]) . '%')->where('whatsapp',true)->first();
            if ($msgrespon) {
                return $msgrespon->response;
            } else {
                return false;
            }
        }
        
        // Jika inbox merupakan pesan telegram
        if($inbox->channel == 'telegram'){
            $msgrespon = ModelsAutoRespon::where('keyword', 'like', '%' . Str::lower($arrs[0]) . '%')->where('telegram',true)->first();
            if ($msgrespon) {
                return $msgrespon->response;
            } else {
                return false;
            }
        }
        return false;
    }
    /**
     * Replace parameters in the message
     */
    public function replaceparams($sender, $message)
    {
        // replace setiap parameter messege
        $user = User::where('whatsapp', $sender)->orWhere('telegram',$sender)->first();
        $message = Str::replace('{{site_name}}', config('app.name'), $message);
        $message = Str::replace('{{masaberlaku}}', Carbon::parse($user->masa_berlaku)->format('d F Y'), $message);

        return $message;
    }
}
