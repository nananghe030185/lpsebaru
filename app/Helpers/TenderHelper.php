<?php

namespace App\Helpers;

use App\Models\Tender;

class TenderHelper
{
    protected $tender;
    /**
     * Create a new class instance.
     */
    public function __construct(Tender $tender)
    {
        $this->tender = $tender;
    }

    public function getNamaPaket()
    {
        return $this->tender->nama_paket . "\n" .
            'Kode Tender - ' . $this->tender->tender_id . "\n" .
            'HPS - ' . $this->tender->hps . "\n" .
            'Nama LPSE - ' . $this->tender->nama_lpse . "\n";
    }

}
