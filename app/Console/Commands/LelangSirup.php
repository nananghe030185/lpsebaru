<?php

namespace App\Console\Commands;

use App\Models\Lelang;
use Carbon\Carbon;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LelangSirup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:lelang-sirup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lelang Sirup Srape Command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $kldi = '903';

        $url = 'https://sirup.lkpp.go.id';
        $headers = [
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'Accept-Encoding' => 'gzip, deflate, br, zstd',
            'Accept-Language' => 'id,id-ID;q=0.9,en-US;q=0.8,en;q=0.7,ms;q=0.6',
            'Cache-Control' => 'no-cache',
            // Cookie
            'Dnt' => '1',
            'Pragma' => 'no-cache',
            'Priority' => 'u=1, i',
            'Referer' => $url . '/sirup/caripaketctr/index',
            'Sec-Ch-Ua' => '"Not)A;Brand";v="8", "Chromium";v="138", "Google Chrome";v="138"',
            'Sec-Ch-Ua-Mobile' => '?0',
            'Sec-Ch-Ua-Platform' => '"Windows"',
            'Sec-Fetch-Dest' => 'empty',
            'Sec-Fetch-Mode' => 'cors',
            'Sec-Fetch-Site'=> 'same-origin',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
            'X-Requested-With'=> 'XMLHttpRequest',
            ];

            $respon = Http::withHeaders($headers)->get($url . '/sirup/caripaketctr/search', $this->setparams($kldi));
            $totalRecord = $respon->json()['recordsTotal'];

            $jumlahScrape = 1000;
            for ($i = 0; $i < ceil($totalRecord/$jumlahScrape); $i++) {
                if($i == 0){
                    $respon = Http::withHeaders($headers)->get($url . '/sirup/caripaketctr/search', $this->setparams($kldi, $i));
                }else{
                    $respon = Http::withHeaders($headers)->get($url . '/sirup/caripaketctr/search', $this->setparams($kldi, $i * $jumlahScrape));
                }
                $this->save($respon->json()['data']);
            }
    }

    public function setparams($kldi, $start = 0)
    {
        $tanggal = Carbon::now();
        $params = [];
        $params['tahunAnggaran']= $tanggal->format('Y');
        $params['jenisPengadaan']= '';
        $params['metodePengadaan']= '';
        $params['minPagu']= '';
        $params['maxPagu']= '';
        $params['bulan']= $tanggal->format('n');
        // $params['bulan']= '';
        $params['lokasi']= '';
        $params['kldi'] = '';
        $params['pdn'] = '';
        $params['ukm'] = '';
        $params['draw'] = 1;
        for ($i=0; $i <= 10 ; $i++) { 
            if ($i == 0) {
                $params['columns[' . $i .'][data]'] = '';
            }elseif ($i == 1) {
                $params['columns[' . $i .'][data]'] = 'paket';
            }elseif ($i == 2) {
                $params['columns[' . $i .'][data]'] = 'pagu';
            }elseif ($i == 3) {
                $params['columns[' . $i .'][data]'] = 'jenisPengadaan';
            }elseif ($i == 4) {
                $params['columns[' . $i .'][data]'] = 'isPDN';
            }elseif ($i == 5) {
                $params['columns[' . $i .'][data]'] = 'isUMK';
            }elseif ($i == 6) {
                $params['columns[' . $i .'][data]'] = 'metode';
            }elseif ($i == 7) {
                $params['columns[' . $i .'][data]'] = 'pemilihan';
            }elseif ($i == 8) {
                $params['columns[' . $i .'][data]'] = 'kldi';
            }elseif ($i == 9) {
                $params['columns[' . $i .'][data]'] = 'satuanKerja';
            }elseif ($i == 10) {
                $params['columns[' . $i .'][data]'] = 'lokasi';
            }else{
                $params['columns[' . $i .'][data]'] = 'id';
            }
            $params['columns[' . $i .'][name]'] = '';
            if($i == 0){
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
            $params['start']= $start;
            $params['length']= 1000;
            $params['search[value]']= '';
            $params['search[regex]']= false;
            // $params['authenticityToken']= $token;
            $params['_']= time();

            return $params;
    }

    public function save($datas){
        foreach ($datas as $data) {
            DB::beginTransaction();
            try {
                Lelang::updateOrCreate(
                    [
                        'kode_rup' => $data['id']
                    ],
                    [
                        'id_bulan' => $data['idBulan'],
                        'id_jenispengadaan' => $data['idJenisPengadaan'],
                        'id_klpdi' => $data['idKldi'],
                        'id_metode' => $data['idMetode'],
                        'id_satker' => $data['idSatker'],
                        'id_referensi' => $data['id_referensi'],
                        'id_lokasi' => $data['idsLokasi'],
                        'is_pdn' => $data['isPDN'],
                        'is_umk' => $data['isUMK'],
                        'jenis_pengadaan' => $data['jenisPengadaan'],
                        'klpdi' => $data['kldi'],
                        'lokasi' => $data['lokasi'],
                        'metode' => $data['metode'],
                        'pagu' => $data['pagu'],
                        'nama_paket' => $data['paket'],
                        'slug' => Str::slug($data['id'] . '-' . $data['paket']),
                        'pds' => $data['pds'],
                        'pemilihan' => $data['pemilihan'],
                        'satuan_kerja' => $data['satuanKerja'],
                        'sumber_dana' => strpos($data['sumberDana'],',') !== false ? explode(',', $data['sumberDana'])[0] : $data['sumberDana'],
                    ]
                );
                DB::commit();
            }catch (\Throwable $e) {
                DB::rollBack();
            }
        }
    }
}
