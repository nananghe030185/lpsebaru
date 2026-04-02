<?php

namespace App\Http\Controllers\Member;

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

class DashboardController extends Controller
{
    public function index()
    {
        $userid = Helpers::getCurrentUserId();

        $lelang = Lelang::count();
        $tender = Tender::count();
        $tenderkeyword = TenderKeyword::count();

        $fokus = Fokus::where('user_id', $userid)->count();
        $toplpse = Lpse::where('state',true)->orderBy('jumlah_paket', 'desc')->take(5)->get();
        $users = User::orderBy('created_at', 'desc')->take(5)->get();
        $logs = ErrorLog::orderBy('created_at', 'desc')->take(5)->get();
        return view('member.dashboard.index',compact('lelang', 'tender', 'tenderkeyword', 'fokus', 'toplpse','users','logs'));
    }

}
