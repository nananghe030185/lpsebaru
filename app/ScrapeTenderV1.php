<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Helpers\Helpers;
use GuzzleHttp\Cookie\CookieJar;
use App\Helpers\AppHelper;
use Carbon\Carbon;
use App\Models\Tender;
use App\Models\User;
use App\Models\Fokus;
use App\Models\Notification;
use App\Models\Lpse;
use App\Models\TenderKeyword;
use Illuminate\Database\Eloquent\Collection;


class ScrapeTenderV1
{
    protected Collection $lpses;
    /**
     * Create a new class instance.
     */
    public function __construct(Collection $lpses)
    {
        $this->lpses = $lpses;
    }

    /**
     * Run Tender Scraper
     */
    public function run()
    {
        foreach ($this->lpses as $lpse) {
            try {
                if($lpse->link != null and $lpse->state == true and $lpse->scrape == false){

                    if(!Http::connectTimeout(5)->timeout(10)->get($lpse->link)->successful()){
                        
                        // skip if the lpse link is not valid
                        Helpers::createErrorLog('Link : ' . $lpse->link . ' : ' . 'Link LPSE tidak dapat diakses', null);
                        $lpse->state = false;
                        $lpse->save();
                        
                        continue;
                    }

                    $cookiejar = new CookieJar();// initial request to set some cookies
                    $client = Http::baseUrl($lpse->link)
                            ->withOptions(['cookies' => $cookiejar])
                            ->withoutRedirecting()
                            ->timeout(10)
                            ->connectTimeout(5)
                            ->throw();
                    
                    // get cookies from the initial request to /lelang
                    $headers = [
                        'Accept' => 'application/json, text/javascript, */*; q=0.01',
                        'Accept-Encoding' => 'gzip, deflate, br, zstd',
                        'Accept-Language' => 'id,id-ID;q=0.9,en-US;q=0.8,en;q=0.7,ms;q=0.6',
                        'Cache-Control' => 'no-cache',
                        // Cookie
                        'Dnt' => '1',
                        'Pragma' => 'no-cache',
                        'Priority' => 'u=1, i',
                        'Referer' => $lpse->link,
                        'Sec-Ch-Ua' => '"Not:A;Brand";v="8", "Chromium";v="138", "Google Chrome";v="138"',
                        'Sec-Ch-Ua-Mobile' => '?0',
                        'Sec-Ch-Ua-Platform' => '"Windows"',
                        'Sec-Fetch-Dest' => 'empty',
                        'Sec-Fetch-Mode' => 'cors',
                        'Sec-Fetch-Site'=> 'same-origin',
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
                        'X-Requested-With'=> 'XMLHttpRequest',
                    ];
                    $getcookies = $client->withHeaders($headers)->asForm()->withoutVerifying()
                    ->get('/lelang')
                    ->cookies();

                    $stringcookie = is_null($getcookies->getCookieByName('SPSE_SESSION')->getValue()) ? '' : $getcookies->getCookieByName('SPSE_SESSION')->getValue();
                    $arrcookie = Str::of($stringcookie)->explode('=')->get(1);
                    $token = Str::replace('&___TS','',$arrcookie);
                    
                    foreach ($getcookies as $ck) {
                        $cookiejar->setCookie($ck);
                    }

                    $respon = $client->withHeaders($headers)->asForm()->withoutVerifying()->post('/dt/lelang?tahun=' . Carbon::now()->format('Y'), $this->setparams($token));

                    $this->save($respon->json(), $lpse->id);

                }
            }catch (\Exception $e) {
                // Log the error
                Helpers::createErrorLog('Link : ' . $lpse->link . ' : ' . $e->getMessage(), $e->getTraceAsString());
                continue;
            }
        }
    }

    

    public function save( array $datas, int $lpse_id){
        foreach ($datas['data'] as $data) {
            try {
                $tender = Tender::updateOrCreate(
                    [
                        'tender_id' => $data[0]
                    ],
                    [
                        'lpse_id' => $lpse_id,
                        'nama_lpse' => $data[2],
                        'nama_paket' => Str::limit($data[1], 490),
                        'slug' => Str::limit(
                            Str::slug($data[0] . ' ' . $data[1]),
                            250
                        ),
                        
                        'tahap_tender' => Str::replace(' [...]','',$data[3]),
                        'hps' => static::nominal($data[4]),
                        'metode_pengadaan' => $data[5],
                        'metode_pemilihan' => $data[6],
                        'metode_evaluasi' => $data[7],
                        'kategori' => $data[8],
                        'tahun' => Carbon::now()->format('Y'),
                        'nilai_kontrak' => $data[10],
                    ]
                );
                if($tender->wasRecentlyCreated){
                    $this->notificationTender($tender, $lpse_id);
                    // update jumlah paket dan Pagu LPSE
                    $lpse = Lpse::find($lpse_id);
                    $lpse->jumlah_paket += 1;
                    $lpse->jumlah_pagu += $tender->hps;
                    $lpse->save();
                }
            } catch (\Throwable $e) {
                Helpers::createErrorLog('Tender ID : ' . $data[0] . ' : ' . $e->getMessage(), $e->getTraceAsString());
                continue;
            }
        }
    }

    public function notificationTender(Tender $tender, int $lpse_id)
    {
        $users = User::where('masa_berlaku', '>=', Carbon::now())
            ->get();

        $users->each(function ($user) use ($tender, $lpse_id){
            $keywords = Str::of($user->kata_kunci)->explode(',')
                ->map(fn($keyword) => trim($keyword))
                ->filter(fn($keyword) => !empty($keyword))
                ->toArray();

            // insert fokus if the tender name contains any of the keywords
            if(Str::contains($tender->nama_paket, $keywords, ignoreCase: true)){
                // kumpulkan yang sesuai keyword di tabel tender keyword
                TenderKeyword::updateOrCreate(
                    [
                        'tender_id' => $tender->tender_id,
                        'user_id' => $user->id, // Assuming user_id 1 is the admin or system user
                    ],
                    [
                        'fokus' => false,
                    ]
                );

                // send notification telegram to user
                if(!in_array($tender->tahap_tender, [
                    'Tender Gagal', 
                    'Tender Sudah Selesai', 
                    'Tender Batal'
                    ])) {
                    // Create notifications for the user
                    if($user->notif_telegram_tender){
                        Notification::create([
                            'channel' => 'telegram',
                            'user_id' => $user->id, // Assuming user_id 1 is the admin or system user
                            'tender_id' => $tender->tender_id,
                        ]);
                    }

                    if($user->notif_email_tender){
                        Notification::create([
                            'channel' => 'email',
                            'user_id' => $user->id, // Assuming user_id 1 is the admin or system user
                            'tender_id' => $tender->tender_id,
                        ]);
                    }

                    if($user->notif_whatsapp_tender){
                        Notification::create([
                            'channel' => 'whatsapp',
                            'user_id' => $user->id, // Assuming user_id 1 is the admin or system user
                            'tender_id' => $tender->tender_id,
                        ]);
                    }
                }
            }
        });
    }

    public function setparams(string $token)
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
            // $params['_']= time();
            // $params['tahun']= Carbon::now()->format('Y');

            // dd($params);
            return $params;
    }

    public static function nominal(string $data)
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
