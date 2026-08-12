<?php

namespace App\Http\Controllers\Member;

use App\DataTables\Member\LelangDataTable;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\FokusLelang;
use App\Models\Lelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LelangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LelangDataTable $dataTable)
    {
        return $dataTable->render('member.lelang.index');
    }

    public function fokus(Lelang $lelang)
    {
        FokusLelang::updateOrCreate(
            [
                'lelang_id' => $lelang->id,
                'user_id' => Helpers::getCurrentUserId(),
            ],
            []
        );

        return redirect()->route('app.lelang-sirup.index')->with('success', 'Lelang berhasil difokuskan.');
    }

    public function bulkFokus(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada lelang yang dipilih.');
        }
       // explode the ids and focus on each lelang
        $ids = explode(',', $ids);
        if (count($ids) > 100) {
            return redirect()->back()->with('error', 'Maksimal 100 lelang dapat difokuskan sekaligus.');
        }
        
        // Loop through each ID and focus the lelang
        foreach ($ids as $id) {
            $lelang = Lelang::find($id);
            if ($lelang) {
                FokusLelang::updateOrCreate(
                    [
                        'lelang_id' => $lelang->id,
                        'user_id' => Helpers::getCurrentUserId(),
                    ],
                    []
                );
            }
        }

        return redirect()->route('app.lelang-sirup.index')->with('success', 'Lelang berhasil difokuskan.');
    }

    public function isfokus()
    {
        return true;
    }
}
