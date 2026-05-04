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
        $users = User::orderBy('created_at', 'desc')->take(5)->get();
        $logs = ErrorLog::orderBy('created_at', 'desc')->take(5)->get();
        $pengumuman = Pengumuman::where('status', true);
        return view('admin.dashboard.index',compact('lelang', 'tender', 'tenderkeyword', 'fokus', 'toplpse','users','logs', 'member', 'nonmember'));
    }
}
