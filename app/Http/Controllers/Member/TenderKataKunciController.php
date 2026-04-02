<?php

namespace App\Http\Controllers\Member;

use App\DataTables\Member\TenderKataKunciDataTable;
use App\Http\Controllers\Controller;
use App\Models\Fokus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenderKataKunciController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TenderKataKunciDataTable $dataTable)
    {
        return $dataTable->render('member.tenderkatakunci.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fokus $tender_kata_kunci)
    {
        DB::beginTransaction();
        try{
            $tender_kata_kunci->delete();
            DB::commit();
            return redirect()->route('app.tender-kata-kunci.index')->with('success', __('Data telah di hapus'));
        }catch(Exception $e){
            DB::rollback();
            throw $e;
            return redirect()->route('app.tender-kata-kunci.index')->with('danger', __('Hapus Data Gagal'));
        }

    }

    public function fokus(Fokus $tender_kata_kunci)
    {

        DB::beginTransaction();
        try{
            $tender_kata_kunci->update([
                'fokus' => true
            ]);

            DB::commit();

            return redirect()->route('app.tender-kata-kunci.index')->with('danger', 'Paket berhasil difokuskan'); 
        }catch(Exception $e){
            DB::rollBack();
            throw $e;

            return redirect()->route('app.tender-kata-kunci.index')->with('danger', 'Paket Tender Gagal difokuskan'); 
        }
    }

    public function bulkFokus(Request $request)
    {
        $ids = $request->input('ids', []);
        // explode the ids to ensure they are in array format
        $ids = explode(',', $ids);

        if (empty($ids)) {
            return redirect()->route('app.tender-kata-kunci.index')->with('warning', 'Tidak ada data yang dipilih');
        }

        DB::beginTransaction();
        try {
            Fokus::whereIn('id', $ids)->update(['fokus' => true]);
            DB::commit();
            return redirect()->route('app.tender-kata-kunci.index')->with('success', 'Data berhasil difokuskan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('app.tender-kata-kunci.index')->with('danger', 'Gagal memfokuskan data: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->back()->with('error', 'No items selected for deletion.');
        }

        Fokus::whereIn('id', $ids)->delete();
        return redirect()->route('app.tender-kata-kunci.index')->with('success', 'Selected Fokus Lelang deleted successfully.');
    }
}
