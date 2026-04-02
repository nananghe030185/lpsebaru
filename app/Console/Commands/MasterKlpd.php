<?php

namespace App\Console\Commands;

use App\Models\Klpd;
use App\Models\Klpdi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class MasterKlpd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:master-klpdi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah untuk mereload ulang master KLPD';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $klpds = Http::get('https://isb.lkpp.go.id/isb-2/api/satudata/MasterKLPD')->json();
        foreach ($klpds as $klpd) {
            try{
                    Klpdi::updateOrCreate([
                        'kode_klpd' => $klpd['kd_klpd']
                    ],[
                        'jenis_klpdi' => $klpd['jenis_klpd'],
                        'nama_klpdi' => $klpd['nama_klpd'],
                        'kode_provinsi' => $klpd['kd_provinsi'],
                        'kode_kabupaten' => $klpd['kd_kabupaten'],
                    ]);
            }catch(\Throwable $e){
                continue;
            }
        }
    }
}
