<?php

namespace App;

use App\Models\ErrorLog;
use App\Models\Fokus;
use App\Models\Invoice;
use App\Models\Lelang;
use App\Models\Lpse;
use App\Models\Pengumuman;
use App\Models\Tender;
use App\Models\TenderKeyword;
use App\Models\User;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class dataDashboard
{
    protected int $user_id;
    /**
     * Create a new class instance.
     */
    public function __construct(int $user_id = 0)
    {
        $this->user_id = $user_id;
    }

    /***
     * Jumlah baris data Tender LPSE
     */
    public function totalRowTender()
    {
        return Tender::count();
    }

    /***
     * Jumlah baris data lelang sirup
     */
    public function totalRowLelang()
    {
        return Lelang::count();
    }

    /***
     * Jumlah baris tender yang cocok dengan keyword yang telah di tentukan
     */
    public function totalTenderKeyword()
    {
        return TenderKeyword::where('user_id', $this->user_id)->count();
    }

    /***
     * Jumlah baris tender yang di fokuskan untuk di ikuti tiap user
     */
    public function totalFokus()
    {
        return Fokus::where('user_id', $this->user_id)->count();
    }

    /***
     * Urutan Lpse dengan jumlah paket terbesar
     */
    public function topLPSE()
    {
        return Lpse::where('state',true)->orderBy('jumlah_paket', 'desc')->take(5)->get();
    }

    /***
     * Urutan User dengan komisi terbesar
     */
    public function topUser()
    {
        return User::orderBy('komisi', 'desc')->take(5)->get();
    }

    /***
     * Data aktifitas scrape dan error log
     */
    public function currentErrorLog()
    {
        if($this->user_id >0){
            return ErrorLog::where('kategori','scrape')->orderBy('id', 'desc')->take(10)->get();
        }
        return ErrorLog::orderBy('id', 'desc')->take(10)->get();
    }

    /***
     * Data pengumuman yang di publish untuk dilihat oleh user
     */
    public function currentPengumuman()
    {
        return Pengumuman::where('status', true);
    }

    /***
     * Jumlah invoice dengan status tertentu seperti paid, unpaid, cancel
     */
    public function jumlahInvoice(string $status = '')
    {
        if($status != ''){
            return Invoice::where('status', $status)->sum('total');
        }
        return Invoice::sum('total');
    }

    /***
     * Jumlah Komisi semua pengguna atau user tertentu
     */
    public function jumlahKomisi()
    {
        if($this->user_id > 0){
            return User::find($this->user_id)->komisi;
        }
        return User::sum('komisi');
    }

    /***
     * Masa aktif akun
     */
    public function masaberlaku()
    {
        $now = Carbon::now();
        $masaaktif = Carbon::parse(User::find($this->user_id)->masa_berlaku);

        return [$masaaktif->format('d M Y'), round($now->diffInDays($masaaktif))];
    }

    /***
     * Jumlah user berdasarkan group
     */
    public function totalUserByGroup(int $group_id)
    {
        return User::where('group_id', $group_id)->count();
    }

    /***
     * Jumlah User yang terdaftar tiap bulan
     */
    public function userPerBulan()
    {
        $dataUsers = [0,0,0,0,0,0,0,0,0,0,0,0];
        $dbUserPerBulan = User::select(
            DB::raw("TO_CHAR(created_at, 'mm') as bulan"),
            DB::raw("COUNT(*) as jumlah")
        )
        ->groupBy('bulan')
        ->orderBy('bulan', 'ASC')
        ->whereYear('created_at', date('Y'))
        ->get();

        foreach($dbUserPerBulan as $i => $data)
        {
            $dataUsers[intval($data->bulan) - 1] = $data->jumlah;
        }

        return $dataUsers;
    }

    /***
     * Data Invoice yang diajukan setiap bulan
     */
    public function dbInvoiceData()
    {
        $invoiceData = Invoice::select(
            DB::raw("TO_CHAR(created_at, 'mm') as bulan"),
            DB::raw("COUNT(*) as jumlah")
        )
        ->groupBy('bulan')
        ->orderBy('bulan', 'ASC')
        ->whereYear('created_at', date('Y'));

        return $invoiceData;
    }

    /***
     * Jumlah Invoice
     */
    public function axisInvoicePerBulan()
    {
        $dataInvoices = [0,0,0,0,0,0,0,0,0,0,0,0];
        $invoiceData = $this->dbInvoiceData()->get();

        foreach ($invoiceData as $data) {
            $dataInvoices[intval($data->bulan) - 1] = $data->jumlah;
        }

        return $dataInvoices;
    }

    /***
     * Data Paid Invoice per bulan untuk axis grafik
     * return array
     */
    public function axisPaidInvoicePerBulan() : array
    {
        $dataPaidInvoices = [0,0,0,0,0,0,0,0,0,0,0,0];
        $invoiceData = $this->dbInvoiceData()->where('status', 'paid')->get();

        foreach ($invoiceData as $data) {
            $dataPaidInvoices[intval($data->bulan) - 1] = $data->jumlah;
        }
        return $dataPaidInvoices;
    }

    /***
     * Data Pengunjung per hari untuk axis grafik
     * return array
     */
    public function axisVisitorPerHari()
    {
        $dataVisitor = [0,0,0,0,0,0,0,0,0,0,0,0];
        $visitorData = Visitor::select(
            DB::raw("TO_CHAR(created_at, 'dd') as hari"),
            DB::raw("COUNT(*) as jumlah")
        )
        ->groupBy('hari')
        ->orderBy('hari', 'desc')
        ->whereYear('created_at', date('Y'))
        ->take(3)
        ->get();

        foreach ($visitorData as $i => $data) {
            $dataVisitor[11 - $i] = $data->jumlah;
        }

        return $dataVisitor;
    }

    /***
     * Jumlah scrape data LPSE per hari
     */
    public function axisScrapeLPSEPerHari()
    {
        $dataScrapeLPSE = [0,0,0,0,0,0,0];
        $dataDBScrapeLPSE = Tender::select(
            DB::raw("TO_CHAR(created_at, 'dd') as hari"),
            DB::raw("COUNT(*) as jumlah")
        )
        ->groupBy('hari')
        ->orderBy('hari', 'desc')
        ->whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))
        ->get();

        foreach ($dataDBScrapeLPSE as $i => $data) {
            $dataScrapeLPSE[7 - $i] = $data->jumlah;
        }

        return $dataScrapeLPSE;
    }

    /***
     * jumlah scrape Lelang Sirup per hari
     * return array
     */
    public function axisScrapeLelangPerHari()
    {
        $dataScrapeSirup = [0,0,0,0,0,0,0];
        $dataDBScrapeSirup = Lelang::select(
            DB::raw("TO_CHAR(created_at, 'dd') as hari"),
            DB::raw("COUNT(*) as jumlah")
        )
        ->groupBy('hari')
        ->orderBy('hari', 'desc')
        ->whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))
        ->get();

        foreach ($dataDBScrapeSirup as $i => $data) {
            $dataScrapeSirup[7 - $i] = $data->jumlah;
        }

        return $dataScrapeSirup;
    }

    /***
     * Axis tanggal buat grafik untuk 7 hari kebelakang
     * return array
     */
    public function axisTanggal()
    {
        $tgl = [];
        for($i = 7; $i >= 0; $i--){
            $tgl[] = now()->subDays($i)->format('d/m/Y');
        }

        return $tgl;
    }

}
