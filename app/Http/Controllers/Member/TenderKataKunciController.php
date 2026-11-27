<?php

namespace App\Http\Controllers\Member;

use App\DataTables\Member\TenderKataKunciDataTable;
use App\Http\Controllers\Controller;
use App\Models\Fokus;
use App\Models\TenderKeyword;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

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
    public function destroy(int $tender_kata_kunci)
    {
        DB::beginTransaction();
        try{
            $tender_kata_kunci = TenderKeyword::findOrFail($tender_kata_kunci);
            $tender_kata_kunci->delete();
            DB::commit();

            Alert::toast('Data berhasil dihapus')->success()->flash();
            return redirect()->route('app.tender-kata-kunci.index');
        }catch(Exception $e){
            DB::rollback();
            throw $e;
            return redirect()->route('app.tender-kata-kunci.index')->with('danger', __('Hapus Data Gagal'));
        }

    }

    public function fokus(TenderKeyword $tender_kata_kunci)
    {

        DB::beginTransaction();
        try{
            $tender_kata_kunci->update([
                'fokus' => true
            ]);

            // insert daata di tabel Fokus
            Fokus::updateOrCreate([
                'user_id' => $tender_kata_kunci->user_id,
                'tender_id' => $tender_kata_kunci->tender_id,
            ],[
                'fokus' => true
            ]);

            DB::commit();

            Alert::toast('Tender berhassil difokuskan')->success()->flash();
            return redirect()->route('app.tender-kata-kunci.index'); 
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
            Alert::toast('Tidak ada data yang dipilih')->warning()->flash();
            return redirect()->route('app.tender-kata-kunci.index');
        }

        DB::beginTransaction();
        try {
            foreach($ids as $id){
                $tenderKataKunci = TenderKeyword::find($id);
                Fokus::updateOrCreate([
                    'user_id' => $tenderKataKunci->user_id,
                    'tender_id' => $tenderKataKunci->tender_id
                ],[
                    'fokus' => true
                ]);
            }
            DB::commit();

            Alert::toast('Data berhasil difokuskan')->success()->flash();
            return redirect()->route('app.tender-kata-kunci.index');
        } catch (Exception $e) {
            DB::rollBack();

            Alert::toast('Gagal memfokuskan data ' . $e->getMessage())->error()->flash();
            return redirect()->route('app.tender-kata-kunci.index');
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        // dd($ids);

        if (empty($ids)) {
            Alert::toast('Tidak ada data yang dipilih')->error()->flash();
            return redirect()->back();
        }

        TenderKeyword::whereIn('id', $ids)->delete();

        Alert::toast('Data yang dipilih berhasil dihapus')->success()->flash();
        return redirect()->route('app.tender-kata-kunci.index');
    }
}
