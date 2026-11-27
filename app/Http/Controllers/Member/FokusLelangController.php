<?php

namespace App\Http\Controllers\Member;

use App\DataTables\Member\FokusLelangDataTable;
use App\Http\Controllers\Controller;
use App\Models\FokusLelang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FokusLelangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FokusLelangDataTable $datatable)
    {
        return $datatable->render('member.fokuslelang.index');
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FokusLelang $fokus_lelang)
    {
        $fokus_lelang->delete();
        Alert::toast('Fokus Lelang berhasil dihapus')->success()->flash();
        return redirect()->route('app.fokus-lelang.index');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            Alert::toast('Tidak ada data yang dipilih')->error()->flash();
            return redirect()->back();
        }

        FokusLelang::whereIn('id', $ids)->delete();

        Alert::toast('Fokus Lelang yang dipilih berhasil dihapus')->success()->flash();
        return redirect()->route('app.fokus-lelang.index');
    }
}
