<?php

namespace App\Console\Commands;

use App\Helpers\Helpers;
use App\Models\ErrorLog;
use App\Models\Lpse;
use App\ScrapeTenderV1;
use Illuminate\Console\Command;


class TenderLpse extends Command
{
    protected $version = 1;
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
        // Buat laporan di aktifitas
        Helpers::createErrorLog('Scrape data tender LPSE', '', 'scrape');

        // Scrape hanya Bappenas
        $lpses = Lpse::where(['state' => true])->get(['id', 'link', 'state', 'scrape', 'jumlah_paket', 'jumlah_pagu', 'kode_lpse']);

        if($this->version == 1) {
            $scraper = new ScrapeTenderV1($lpses);
            $scraper->run();
        }
    }
}
