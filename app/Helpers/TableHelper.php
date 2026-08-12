<?php

namespace App\Helpers;

class TableHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function nominal_simple($nominal)
    {
        if($nominal / 1000000000000 >= 1){
            return 'Rp. ' . number_format($nominal / 1000000000000, 2, ',', '.') . ' Triliun';
        } elseif ($nominal / 1000000000 >= 1) {
            return 'Rp. ' . number_format($nominal / 1000000000, 2, ',', '.') . ' Milyar';
        } elseif ($nominal / 1000000 >= 1) {
            return 'Rp. ' . number_format($nominal / 1000000, 2, ',', '.') . ' Juta';
        } elseif ($nominal / 1000 >= 1) {
            return 'Rp. ' . number_format($nominal / 1000, 2, ',', '.') . ' Ribu';
        } else {
            return 'Rp. ' . number_format($nominal, 2, ',', '.');
        }
    }

    public static function tanggal(\DateTime $tanggal)
    {
        return $tanggal->format('d/m/Y');
    }
}
