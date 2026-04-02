<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengaturan::create(['key' => 'message_notifikasi', 'value' => 'Berikut Data LPSE yang baru tayang pada :tanggal : \n :namapaket dengan Kode Tender : :kodetender \n Kunjungi : :link', 'description' => 'Template Pesan Notifikasi Paket LPSE sudah tayang','order' =>'1']);
        Pengaturan::create(['key' => 'message_notifikasi_perpanjangan', 'value' => 'Pembayaran Keanggotaan a/n :name dengan ID :id selama :days Hari', 'description' => 'Template Pesan Perpanjangan masa berlaku member','order' =>'2']);
        Pengaturan::create(['key' => 'message_notifikasi_pembayaran', 'value' => 'Pembayaran Keanggotaan a/n  :name dengan ID :id sebesar :nominal Pada Tanggal :tanggal', 'description' => 'Template Pesan Pembayaran perpanjangan telah di terima','order' =>'3']);
        Pengaturan::create(['key' => 'message_notifikasi_tiket', 'value' => 'Silahkan lakukan pembayaran Rp. {nominal} ke Rek BRI 098989898989 a/n Nanang Hermawan','description' => '','order' =>'4']);
        Pengaturan::create(['key' => 'item_per_page', 'value' => '20', 'description' => 'item table yang di tampilkan tiap halaman','order' =>'5']);
        Pengaturan::create(['key' => 'harga_personal', 'value' => '350000', 'description' => 'harga membership personal','order' =>'6']);
        Pengaturan::create(['key' => 'harga_premium', 'value' => '1200000', 'description' => 'harga membership Premium','order' =>'7']);
        Pengaturan::create(['key' => 'harga_corporate', 'value' => '1500000', 'description' => 'harga membership corporate','order' =>'8']);
        Pengaturan::create(['key' => 'durasi_personal', 'value' => '90', 'description' => 'lama membership personal (hari)','order' =>'9']);
        Pengaturan::create(['key' => 'durasi_premium', 'value' => '360', 'description' => 'lama membership Premium (hari)','order' =>'10']);
        Pengaturan::create(['key' => 'durasi_corporate', 'value' => '360', 'description' => 'lama membership corporate(hari)','order' =>'11']);
        Pengaturan::create(['key' => 'bri_client_id', 'value' => 'Pk5eocJANT9AcpIbekbSgaH3wa2Zes8r', 'description' => 'BRI Client ID untuk cek mutasi BRIVA','order' =>'12']);
        Pengaturan::create(['key' => 'bri_client_secret', 'value' => 'AVjGGnGOoUsOnA9W', 'description' => 'BRI Client Secret','order' =>'13']);
        Pengaturan::create(['key' => 'bri_account_no', 'value' => '210501003757507', 'description' => 'No Rekening BRI','order' =>'14']);
        Pengaturan::create(['key' => 'bri_access_token', 'value' => 'gaWC2xpxG1fNMGvQPvSTnrR1E7mg', 'description' => 'BRI Akses Token','order' =>'15']);
        Pengaturan::create(['key' => 'no_whatsapp_sender', 'value' => '087821996965', 'description' => 'No Whatsapp untuk kirim pesan','order' =>'16']);
        Pengaturan::create(['key' => 'logo_image', 'value' => 'xxx', 'description' => 'Logo Image Applikasi','order' =>'17']);
        Pengaturan::create(['key' => 'persen_komisi', 'value' => '10', 'description' => 'Persen Komisi untuk Upline','order' =>'18']);
        Pengaturan::create(['key' => 'reminder_expired_day', 'value' => '14', 'description' => 'Jumlah hari untuk di kirim pesan pengingat sebelum masa berlaku habis','order' =>'19']);
        Pengaturan::create(['key' => 'masa_percobaan', 'value' => '14', 'description' => 'Masa percobaan member baru','order' =>'20']);
        Pengaturan::create(['key' => 'token_telegram', 'value' => '7166262778:AAHA4gJzh6XMXynlaLUB0lS45XEiqwUGlBY', 'description' => 'Token Telegram Bot','order' =>'21']);
        Pengaturan::create(['key' => 'scrape_item_tender', 'value' => '1000', 'description' => 'Jumlah Item yang di scrape dua kali dalam sehari','order' =>'22']);
        Pengaturan::create(['key' => 'scrape_item_lelang', 'value' => '500', 'description' => 'Jumlah Item Lelang yang di scrap setiap 30 menit sekali','order' =>'23']);
        Pengaturan::create(['key' => 'scrape_item_swakelola', 'value' => '500', 'description' => 'Jumlah Item Swakelola yang di scrap setiap 30 menit sekali','order' =>'24']);
        Pengaturan::create(['key' => 'tahun_paket_tender', 'value' => '2025', 'description' => 'scrape paket tender pada tahun yang telah di tentukan','order' =>'25']);
        Pengaturan::create(['key' => 'tahun_paket_lelang', 'value' => '2025', 'description' => 'scrape paket lelang pada tahun yang telah di tentukan','order' =>'26']);
        Pengaturan::create(['key' => 'tahun_paket_swakelola', 'value' => '2025', 'description' => 'scrape paket swakelola pada tahun yang telah di tentukan','order' =>'27']);
    }
}
