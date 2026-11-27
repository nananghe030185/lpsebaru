<?php

namespace App\Http\Controllers\Member;

use App\dataDashboard;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


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
        $masaberlaku = $dataDashboard->masaberlaku();
        $user = User::find(Auth::user()->id);
        $username = $user->username;
        return view('member.dashboard.index',compact('totalLelang', 'totalTender', 'tenderkeyword', 'totalFokus', 'toplpse','totalkomisi', 'topUsers', 'dataInvoices', 'dataPaidInvoices', 'dataVisitor','dataScrapeLPSE', 'dataScrapeSirup','tanggalAxis', 'totalTender','totalLelang', 'errorsLog','masaberlaku', 'username','user'));
    }

}
