<?php

namespace App\Http\Controllers\Member;

use App\DataTables\Member\FokusLelangDataTable;
use App\Http\Controllers\Controller;
use App\Models\FokusLelang;
use Illuminate\Http\Request;

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
        return redirect()->route('app.fokus-lelang.index')->with('success', 'Fokus Lelang deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->back()->with('error', 'No items selected for deletion.');
        }

        FokusLelang::whereIn('id', $ids)->delete();
        return redirect()->route('app.fokus-lelang.index')->with('success', 'Selected Fokus Lelang deleted successfully.');
    }
}
