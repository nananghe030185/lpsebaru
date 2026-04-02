<?php

namespace App\Console\Commands;

use App\Models\Lpse;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class MasterLpse extends Command
{
    protected static $url = 'https://isb.lkpp.go.id/isb-2/api/satudata/MasterLPSE';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:master-lpse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrapping LPSE data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lpses = Http::get(static::$url)->json();
        foreach ($lpses as $lpse) {
            try {
                Lpse::updateOrCreate(
                    [
                        'kode_lpse'       => $lpse['kd_lpse']
                    ],
                    [
                        'nama_lpse'     => $lpse['nama_lpse'],
                    ]
                );
            } catch (\Exception $e) {
                continue;
            }
        }
    }
}
