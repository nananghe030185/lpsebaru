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
        return view('admin.dashboard.index',compact('lelang', 'tender', 'tenderkeyword', 'fokus', 'toplpse','users','logs', 'member', 'nonmember',  'totalcancel','totalpending', 'totalunpaid', 'totalpaid', 'totalkomisi', 'totalinvoice'));
    }
}
