<?php

namespace App\Helpers;

use App\Models\Pengaturan;

class AppHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct(Pengaturan $pengaturan)
    {
        //
    }

    public static function model()
    {
        $model = new Pengaturan();

        return $model;
    }

    public static function getValue($key)
    {
        $model = self::model();
        return $model->where('key', $key)->value('value');
    }

    public static function getTokenTelegram()
    {
        return self::getValue('token_telegram');
    }

    public static function getMessageNotifikasi()
    {
        return self::getValue('message_notifikasi');
    }

    public static function getMessageNotifikasiPerpanjangan()
    {
        return self::getValue('message_notifikasi_perpanjangan');
    }

    public static function getMessageNotifikasiPembayaran()
    {
        return self::getValue('message_notifikasi_pembayaran');
    }

    public static function getMessageNotifikasiTiket()
    {
        return self::getValue('message_notifikasi_tiket');
    }

    public static function getItemPerPage()
    {
        return self::getValue('item_per_page');
    }

    public static function getHargaPersonal()
    {
        return self::getValue('harga_personal');
    }

    public static function getHargaPremium()
    {
        return self::getValue('harga_premium');
    }

    public static function getHargaCorporate()
    {
        return self::getValue('harga_corporate');
    }

    public static function getDurasiPersonal()
    {
        return self::getValue('durasi_personal');
    }

    public static function getDurasiPremium()
    {
        return self::getValue('durasi_premium');
    }

    public static function getDurasiCorporate()
    {
        return self::getValue('durasi_corporate');
    }

    public static function getPersenKomisi()
    {
        return self::getValue('persen_komisi');
    }

    public static function getReminderExpired()
    {
        return self::getValue('reminder_expired_day');
    }

    public static function getMasaPercobaan()
    {
        return self::getValue('masa_percobaan');
    }

    public static function getScrapeItemTender()
    {
        return self::getValue('scape_item_tender');
    }

    public static function getScrapeItemLelang()
    {
        return self::getValue('scape_item_lelang');
    }

    public static function getTahunPaketTender()
    {
        return self::getValue('tahun_paket_tender');
    }
    public static function getTahunPaketLelang()
    {
        return self::getValue('tahun_paket_lelang');
    }



    
}
