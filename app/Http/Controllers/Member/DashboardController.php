<?php

namespace App\Http\Controllers\Member;

use App\dataDashboard;
use App\Helpers\Helpers;
use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Models\ErrorLog;
use App\Models\Fokus;
use App\Models\Lelang;
use App\Models\Lpse;
use App\Models\Tender;
use App\Models\TenderKeyword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $dataDashboard = new dataDashboard(Auth::user()->id);

        $totalLelang = $dataDashboard->totalRowLelang();
        $totalTender = $dataDashboard->totalRowTender();
        $tenderkeyword = $dataDashboard->totalTenderKeyword();
        $totalkomisi = $dataDashboard->jumlahKomisi();

        $totalFokus = $dataDashboard->totalFokus();
        $toplpse = $dataDashboard->topLPSE();
        $topUsers = $dataDashboard->topUser();

        // Data Grafik
        $dataInvoices = $dataDashboard->AxisInvoicePerBulan();
        $dataPaidInvoices = $dataDashboard->axisPaidInvoicePerBulan();
        $dataVisitor = $dataDashboard->axisVisitorPerHari();
        $dataScrapeLPSE = $dataDashboard->axisScrapeLPSEPerHari();
        $dataScrapeSirup = $dataDashboard->axisScrapeLelangPerHari();
        $tanggalAxis = $dataDashboard->axisTanggal();

        $errorsLog = $dataDashboard->currentErrorLog();

        return view('member.dashboard.index',compact('totalLelang', 'totalTender', 'tenderkeyword', 'totalFokus', 'toplpse','totalkomisi', 'topUsers', 'dataInvoices', 'dataPaidInvoices', 'dataVisitor','dataScrapeLPSE', 'dataScrapeSirup','tanggalAxis', 'totalTender','totalLelang', 'errorsLog'));
    }

}
