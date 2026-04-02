<?php

namespace App\Console\Commands;

use App\Helpers\AppHelper;
use App\Helpers\Helpers;
use App\Helpers\TenderHelper;
use App\Models\ErrorLog;
use App\Models\Fokus;
use App\Models\Lpse;
use App\Models\Notification;
use App\Models\Pengaturan;
use App\Models\Tender;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Ramsey\Collection\Set;

class TenderLpse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:tender-lpse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah untuk mengambil data Tender di LPSE';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Scrape hanya Bappenas
        $lpses = Lpse::where(['state' => true, 'id' => 690])->get(['id', 'link', 'state', 'scrape', 'jumlah_paket', 'jumlah_pagu', 'kode_lpse']);

        foreach ($lpses as $lpse) {
            try {
                if($lpse->link != null and $lpse->state == true and $lpse->scrape == false){
                    $key = 'Lembaga Kebijakan Pengadaan Barang/Jasa Pemerintah';
                    if(Str::contains(Http::get($lpse->link)->body(), $key) == false){
                        // skip if the lpse link is not valid
                        Helpers::createErrorLog('Link : ' . $lpse->link . ' : ' . 'Link LPSE tidak valid', null);
                        $lpse->state = false;
                        $lpse->save();
                        continue;
                    }

                    $cookiejar = new CookieJar();// initial request to set some cookies
                    $client = Http::baseUrl($lpse->link)
                            ->withOptions(['cookies' => $cookiejar])
                            ->withoutRedirecting()
                            ->throw();
                    $getcookies = $client->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
                        'X-Requested-With'=> 'XMLHttpRequest',
                        'Referer'=> $lpse->link,
                        'Sec-Fetch-Mode' => 'cors',
                        'Sec-Fetch-Site'=> 'same-origin',
                    ])->asForm()->withoutVerifying()
                    ->get('/lelang')
                    ->cookies();

                    $stringcookie = $getcookies->getCookieByName('SPSE_SESSION')->getValue();
                    $arrcookie = Str::of($stringcookie)->explode('=')->get(1);

                    $token = Str::replace('&___TS','',$arrcookie);

                    foreach ($getcookies as $ck) {
                        $cookiejar->setCookie($ck);
                    }

                    $respon = $client->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
                        'X-Requested-With'=> 'XMLHttpRequest',
                        'Referer'=> $lpse->link . '/lelang',
                        'Sec-Fetch-Mode' => 'cors',
                        'Sec-Fetch-Site'=> 'same-origin',
                    ])->asForm()->withoutVerifying()->post('/dt/lelang', $this->setparams($token));

                    $a = 0;
                    $ulang = true;
                    $jumlah_paket = $lpse->jumlah_paket;
                    $jumlah_pagu = $lpse->jumlah_pagu;
                    while ($ulang) {
                        $params = $this->setparams($token);
                        $params['draw'] = $a + 1;
                        $params['start'] = $a * (1000 + 1);
                        $respon = $client->withHeaders([
                            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
                            'X-Requested-With'=> 'XMLHttpRequest',
                            'Referer'=> $lpse->link . '/lelang',
                            'Sec-Fetch-Mode' => 'cors',
                            'Sec-Fetch-Site'=> 'same-origin',
                        ])->asForm()->withoutVerifying()->post('/dt/lelang', $params);

                        $a++;
                        
                        if (count($respon->json()['data']) == 0) {
                            $ulang = false;
                        }else{
                            $jumlah_paket += count($respon->json()['data']);
                            $jumlah_pagu += $this->save($respon->json()['data'], $lpse->id);
                        }
                    }

                    // set the scrape state to true after saving
                    $lpse->scrape = true;
                    $lpse->jumlah_paket = $jumlah_paket;
                    $lpse->jumlah_pagu = $jumlah_pagu;
                    $lpse->save();

                }
            }catch (\Exception $e) {
                // Log the error
                Helpers::createErrorLog('Link : ' . $lpse->link . ' : ' . $e->getMessage(), $e->getTraceAsString());
                continue;
            }
            
            // break; // Break after processing the first LPSE for testing purposes
        }

        // Unscrape all LPSEs
        Lpse::query()->update(['scrape' => false]);
    }

    public function save($datas, $lpse_id){
        $jumlah_pagu = 0;
        foreach ($datas as $data) {
            try {
                $tender = Tender::updateOrCreate(
                    [
                        'tender_id' => $data[0]
                    ],
                    [
                        'lpse_id' => $lpse_id,
                        'nama_paket' => Str::limit($data[1], 500),
                        'slug' => Str::limit(
                            Str::slug($data[0] . ' ' . $data[1]),
                            250
                        ),
                        'nama_lpse' => $data[2],
                        'tahap_tender' => Str::replace(' [...]','',$data[3]),
                        'hps' => static::nominal($data[4]),
                        'metode_pengadaan' => $data[5],
                        'metode_pemilihan' => $data[6],
                        'metode_evaluasi' => $data[7],
                        'kategori' => Str::of($data[8])->explode(' - ')->get(0),
                        'tahun' => Carbon::now()->format('Y'),
                        'nilai_kontrak' => $data[10],
                    ]
                );


                $jumlah_pagu += static::nominal($data[4]);

                if($tender->wasRecentlyCreated){
                    $users = User::where('masa_berlaku', '>=', Carbon::now())
                        ->get();
                    
                    $users->each(function ($user) use ($tender, $lpse_id){
                        $keywords = Str::explode(',', $user->kata_kunci);

                        // insert fokus if the tender name contains any of the keywords
                        if(Str::contains($tender->nama_paket, $keywords, ignoreCase: true)){
                            Fokus::updateOrCreate(
                                [
                                    'tender_id' => $tender->id,
                                    'user_id' => $user->id, // Assuming user_id 1 is the admin or system user
                                ],
                                [
                                    'lpse_id' => $lpse_id,
                                ]
                            );

                            // send notification telegram to user
                            if(!in_array($tender->tahap_tender, [
                                'Tender Gagal', 
                                'Tender Sudah Selesai', 
                                'Tender Batal'
                                ])) {
                                // Create notifications for the user
                                if($user->notif_telegram and $user->telegram != null){
                                    // $user->notify(new \App\Notifications\TelegramTenderNotification($tender));
                                }
                                Notification::create([
                                    'channel' => 'telegram',
                                    'user_id' => $user->id, // Assuming user_id 1 is the admin or system user
                                    'tender_id' => $tender->id,
                                ]);

                                Notification::create([
                                    'channel' => 'email',
                                    'user_id' => $user->id, // Assuming user_id 1 is the admin or system user
                                    'tender_id' => $tender->id,
                                ]);

                                Notification::create([
                                    'channel' => 'whatsapp',
                                    'user_id' => $user->id, // Assuming user_id 1 is the admin or system user
                                    'tender_id' => $tender->id,
                                ]);
                            }
                        }
                    });
                }
            } catch (\Throwable $e) {
                continue;
            }
        }

        return $jumlah_pagu;
    }

    public function setparams($token)
    {
        $params = [];
            $params['draw'] = 1;
            $params['search[value]'] = '';
            $params['search[regex]'] = false;

        for ($i=0; $i <= 5 ; $i++) { 
            $params['columns[' . $i .'][data]'] = $i;
            $params['columns[' . $i .'][name]'] = '';
            if($i == 3){
                $params['columns[' . $i .'][searchable]'] = false;
                $params['columns[' . $i .'][orderable]'] = false;
            }else{
                $params['columns[' . $i .'][searchable]'] = true;
                $params['columns[' . $i .'][orderable]'] = true;
            }
            $params['columns[' . $i .'][search][value]'] = '';
            $params['columns[' . $i .'][search][regex]'] = false;
        }

            $params['order[0][column]']= 5;
            $params['order[0][dir]']= 'desc';
            $params['start']= 0;
            $params['length']= AppHelper::getScrapeItemTender();
            $params['search[value]']= '';
            $params['search[regex]']= false;
            $params['authenticityToken']= $token;
            $params['_']= time();
            $params['tahun']= Carbon::now()->format('Y');

            return $params;
    }

    protected static function nominal($data)
    {
        if(Str::endsWith($data, 'Jt')){
            $data = Str::replace(' Jt', '', $data);
            $data = (float) Str::replace(',','.',$data) * 1000000;
            return $data;
        }elseif(Str::endsWith($data, 'M')){
            $data = Str::replace(' M', '', $data);
            $data = (float) Str::replace(',','.',$data) * 1000000000;
            return $data;
        }elseif(Str::endsWith($data, 'T')){
            $data = Str::replace(' T', '', $data);
            $data = (float) Str::replace(',','.',$data) * 1000000000000;
            return $data;
        }
    }
}
