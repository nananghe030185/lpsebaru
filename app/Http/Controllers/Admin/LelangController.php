<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\LelangDataTable;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\FokusLelang;
use App\Models\Lelang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LelangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LelangDataTable $dataTable)
    {
        return $dataTable->render('admin.lelang.index');
    }

    /**
     * Fokus lelang
     */
    public function fokus(Lelang $lelang)
    {
        FokusLelang::updateOrCreate(
            [
                'lelang_id' => $lelang->id,
                'user_id' => Helpers::getCurrentUserId(),
            ],
            []
        );

        Alert::toast('Data Lelang berhasil difokuskan')->success()->flash();
        return redirect()->route('admin.lelang-sirup.index');
    }

    /**
     * Redirect to lelang detail page
     */
    public function redirect(Lelang $lelang)
    {
        return view('admin.redirect.lelang', [
            'target' => 'https://sirup.inaproc.id/sirup/rup/detailPaketPenyedia2020?idPaket=' . $lelang->kode_rup,
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['message' => 'No IDs provided.'], 400);
        }

        Lelang::whereIn('id', $ids)->delete();
        // delete related FokusLelang records
        FokusLelang::whereIn('lelang_id', $ids)->delete();
        
        return response()->json(['message' => 'Selected rows deleted successfully.']);
    }
}
