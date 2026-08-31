<?php

namespace App\Http\Controllers\Admin;

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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $lelang = Lelang::count();
        $tender = Tender::count();
        $member = User::where('group_id', 2)->count();
        $nonmember = User::where('group_id', 3)->count();
        $tenderkeyword = TenderKeyword::count();
        $fokus = Fokus::count();
        $toplpse = Lpse::where('state',true)->orderBy('jumlah_paket', 'desc')->take(5)->get();
        $users = User::orderBy('komisi', 'desc')->take(5)->get();
        $logs = ErrorLog::orderBy('created_at', 'desc')->take(5)->get();
        $pengumuman = Pengumuman::where('status', true);
        // $cancelinvoice = Invoice::where('status', 'cancel')->count();
        $totalcancel = Invoice::where('status', 'cancel')->sum('total');
        $totalpending = Invoice::where('status', 'pending')->sum('total');
        $totalunpaid = Invoice::where('status', 'unpaid')->sum('total');
        $totalpaid = Invoice::where('status', 'paid')->sum('total');
        $totalkomisi = User::sum('komisi');
        $totalinvoice = Invoice::sum('total');

        $userPerBulan = User::select(
            DB::raw("TO_CHAR(created_at, 'mm') as bulan"),
            DB::raw("COUNT(*) as jumlah")
        )
        ->groupBy('bulan')
        ->orderBy('bulan', 'ASC')
        ->whereYear('created_at', date('Y'))
        ->get();

        $invoiceData = Invoice::select(
            DB::raw("TO_CHAR(created_at, 'mm') as bulan"),
            DB::raw("COUNT(*) as jumlah")
        )
        ->groupBy('bulan')
        ->orderBy('bulan', 'ASC')
        ->whereYear('created_at', date('Y'));

        $invoicePerBulan = $invoiceData->get();
        $paidInvoicePerBulan = $invoiceData->where('status', 'paid')->get();

        $dataUsers = [0,0,0,0,0,0,0,0,0,0,0,0];
        $dataInvoices = [0,0,0,0,0,0,0,0,0,0,0,0];
        $dataPaidInvoices = [0,0,0,0,0,0,0,0,0,0,0,0];

        foreach ($userPerBulan as $data) {
            $dataUsers[intval($data->bulan) - 1] = $data->jumlah;
        }
        foreach ($invoicePerBulan as $data) {
            $dataInvoices[intval($data->bulan) - 1] = $data->jumlah;
        }
        foreach ($paidInvoicePerBulan as $data) {
            $dataPaidInvoices[intval($data->bulan) - 1] = $data->jumlah;
        }


        return view('admin.dashboard.index',compact('lelang', 'tender', 'tenderkeyword', 'fokus', 'toplpse','users','logs', 'member', 'nonmember',  'totalcancel','totalpending', 'totalunpaid', 'totalpaid', 'totalkomisi', 'totalinvoice', 'dataUsers', 'dataInvoices', 'dataPaidInvoices'));
    }
}
