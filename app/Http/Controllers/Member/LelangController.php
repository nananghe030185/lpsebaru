<?php

namespace App\Http\Controllers\Member;

use App\DataTables\Member\LelangDataTable;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\FokusLelang;
use App\Models\Lelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

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

        Alert::toast('Lelang berhasil difokuskan')->success()->flash();
        return redirect()->route('app.lelang-sirup.index');
    }

    public function bulkFokus(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            Alert::toast('Tidak ada data yang dipilih')->error()->flash();
            return redirect()->back();
        }
       // explode the ids and focus on each lelang
        $ids = explode(',', $ids);
        if (count($ids) > 100) {
            Alert::toast('Maksimal 100 data')->error()->flash();
            return redirect()->back();
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

        Alert::toast('Lelang berhasil difokuskan')->success()->flash();
        return redirect()->route('app.lelang-sirup.index');
    }

    public function isfokus()
    {
        return true;
    }
}
