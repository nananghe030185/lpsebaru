<?php

namespace App\Http\Controllers\Admin;

use App\dataDashboard;
use App\Http\Controllers\Controller;
use App\Models\ErrorLog;
use App\Models\Fokus;
use App\Models\Lelang;
use App\Models\Lpse;
use App\Models\Pengumuman;
use App\Models\Tender;
use App\Models\TenderKeyword;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dataDashboard = new dataDashboard();

        $totalLelang = $dataDashboard->totalRowLelang();
        $totalTender = $dataDashboard->totalRowTender();

        $member = $dataDashboard->totalUserByGroup(2);
        $nonmember = $dataDashboard->totalUserByGroup(3);

        $tenderkeyword = $dataDashboard->totalTenderKeyword();
        $fokus = $dataDashboard->totalFokus();
        $toplpse = $dataDashboard->topLPSE();

        $users = $dataDashboard->topUser();

        $pengumuman = $dataDashboard->currentPengumuman();

        // $cancelinvoice = Invoice::where('status', 'cancel')->count();
        $totalcancel = $dataDashboard->jumlahInvoice('cancel');
        $totalpending = $dataDashboard->jumlahInvoice('pending');
        $totalunpaid = $dataDashboard->jumlahInvoice('unpaid');
        $totalpaid = $dataDashboard->jumlahInvoice('paid');
        $totalkomisi = $dataDashboard->jumlahKomisi();
        $totalinvoice = $dataDashboard->jumlahInvoice();

// dd($visitorPerHari);
        $dataUsers = $dataDashboard->userPerBulan();

        $dataInvoices = $dataDashboard->AxisInvoicePerBulan();

        $dataPaidInvoices = $dataDashboard->axisPaidInvoicePerBulan();
        $dataVisitor = $dataDashboard->axisVisitorPerHari();
        $dataScrapeLPSE = $dataDashboard->axisScrapeLPSEPerHari();
        $dataScrapeSirup = $dataDashboard->axisScrapeLelangPerHari();
        $tanggalAxis = $dataDashboard->axisTanggal();
        // dd($visitorPerHari);

        $errorsLog = $dataDashboard->currentErrorLog();

        // dd($request->session());
        return view('admin.dashboard.index',compact('tenderkeyword', 'fokus', 'toplpse','users', 'member', 'nonmember',  'totalcancel','totalpending', 'totalunpaid', 'totalpaid', 'totalkomisi', 'totalinvoice', 'dataUsers', 'dataInvoices', 'dataPaidInvoices', 'dataVisitor','dataScrapeLPSE', 'dataScrapeSirup','tanggalAxis', 'totalTender','totalLelang','errorsLog'));
    }
}
