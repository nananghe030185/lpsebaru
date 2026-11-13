<?php

namespace App\Console\Commands;

use App\Models\AutoRespon as ModelsAutoRespon;
use App\Models\Inbox;
use App\Models\Outbox;
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
            $user = User::where('whatsapp', $inbox->sender)->orWhere('telegram',$inbox->sender)->first();

            // jika user ada
            if($user)
            {
                $response = $this->response($inbox);
                if($response){
                    Outbox::create([
                        'status' => 0, // artinya pesan belum terkirim
                        'recipient' => $inbox->sender,
                        'message' => $this->replaceparams($user, $response),
                        'channel' => $inbox->channel
                    ]);

                    $inbox->status = true;
                    $inbox->save();
                }else{
                    //jika tidak ada keyword
                    $inbox->status = true;
                    $inbox->save();
                }
            }else{
                // ubah status inbox jadi dibaca
                $inbox->status = true;
                $inbox->save();
            }
            
        }
    }

    /**
     * Get response based on keyword
     */
    public function response(Inbox $inbox)
    {
        $arrs = Str::of($inbox->message)->explode('#');
        $keyword = Str::lower(Str::replace('/', '', $arrs[0]));
        // Jika inbox merupakan pesan whatsapp
        if($inbox->channel == 'whatsapp'){
            $msgrespon = ModelsAutoRespon::where('keyword', 'ilike', '%' . $keyword . '%')->where('whatsapp',true)->first();
            if ($msgrespon) {
                return $msgrespon->response;
            } else {
                return false;
            }
        }
        
        // Jika inbox merupakan pesan telegram
        if($inbox->channel == 'telegram'){
            $msgrespon = ModelsAutoRespon::where('keyword', 'ilike', '%' . $keyword . '%')->where('telegram',true)->first();
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
    public function replaceparams(User $user,string $message)
    {
        // replace setiap parameter messege
        $message = Str::replace('{{site_name}}', config('app.name'), $message);
        $message = Str::replace('{{masaberlaku}}', Carbon::parse($user->masa_berlaku)->format('d F Y'), $message);

        return $message;
    }
}
