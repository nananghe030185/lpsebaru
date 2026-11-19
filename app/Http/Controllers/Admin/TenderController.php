<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\TenderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Fokus;
use App\Models\Tender;
use App\Models\TenderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TenderDataTable $dataTable)
    {
        return $dataTable->render('admin.tender.index');
    }

    public function edit(Tender $tender_lpse)
    {
        return view('admin.tender.edit', compact('tender_lpse'));
    }

    public function update(Request $request, Tender $tender_lpse){
        $tender_lpse->description = $request->description;
        $tender_lpse->save();

        return redirect()->route('admin.tender-lpse.index')->with('success','Data Berhasil diupdate');
    }
    /**
     * Fokuskan paket  tender
     */
    public function fokus(Tender $tender)
    {
        try{
            DB::beginTransaction();
            // Create a new Fokus record
            Fokus::updateOrCreate([
                'user_id' => Auth::user()->id,
                'tender_id' => $tender->tender_id,
            ],[
                'fokus' => true
            ]);

            DB::commit();
        }catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('admin.tender-lpse.index')->with('error', 'Gagal memfokuskan paket: ' . $e->getMessage());
        }

        return redirect()->route('admin.tender-lpse.index')->with('success', 'Paket telah difokuskan');
    }

    /**
     * Redirect to tender detail page on LPSE website
     */
    public function redirect(Tender $tender){
        return view('admin.redirect.tender', [
            'referer' => $tender->lpse->link,
            'target' => $tender->lpse->link . '/lelang/'. $tender->tender_id .'/pengumumanlelang'
        ]);
    }

    public function page(Tender $tender){
        dd($tender);
    }
    /**
     * Redirect to tender schedule page on LPSE website
     */
    public function tahapan(Tender $tender){
        return view('admin.redirect.tender', [
            'referer' => $tender->lpse->link,
            'target' => $tender->lpse->link . '/lelang/'. $tender->tender_id .'/jadwal'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['message' => 'No IDs provided.'], 400);
        }

        Tender::whereIn('id', $ids)->delete();

        // Delete related Fokus records
        Fokus::whereIn('tender_id', $ids)->delete();
        return response()->json(['message' => 'Selected rows deleted successfully.']);
    }
}
