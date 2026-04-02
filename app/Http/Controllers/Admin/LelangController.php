<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\LelangDataTable;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\FokusLelang;
use App\Models\Lelang;
use App\Models\LelangModel;
use Illuminate\Http\Request;

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

        return redirect()->route('admin.lelang-sirup.index')->with('success', 'Lelang berhasil difokuskan.');
    }

    /**
     * Redirect to lelang detail page
     */
    public function redirect(Lelang $lelang)
    {

        return view('admin.redirect.lelang', [
            'target' => 'https://sirup.lkpp.go.id/sirup/rup/detailPaketPenyedia2020?idPaket=' . $lelang->kode_rup,
        ]);
    }
}
