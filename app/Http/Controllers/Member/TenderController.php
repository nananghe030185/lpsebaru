<?php

namespace App\Http\Controllers\Member;

use App\DataTables\Member\TenderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Fokus;
use App\Models\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TenderDataTable $dataTable)
    {
        return $dataTable->render('member.tender.index');
    }

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
            Alert::toast('Gagal memfokuskan Tender ' . $e->getMessage())->error()->flash();
            return redirect()->route('app.tender-lpse.index');
        }

        Alert::toast('Tender berhasil difokuskan')->success()->flash();
        return redirect()->route('app.tender-lpse.index');
    }

    public function bulkFokus(Request $request)
    {
       $ids = $request->input('ids', []);

       // exit if no IDs are provided
        if (empty($ids)) {
            Alert::toast('Tidak ada paket yang dipilih')->warning()->flash();
            return redirect()->route('app.tender-lpse.index');
        }   
        // explode the ids to ensure they are in array format
        $ids = explode(',', $ids);

        DB::beginTransaction();
        try {
            foreach ($ids as $id) {
                $tender = Tender::findOrFail($id);
                Fokus::updateOrCreate([
                    'tender_id' => $tender->tender_id,
                    'user_id' => Auth::user()->id,
                ],[
                    'fokus' => true,
                ]);
            }
            DB::commit();

            Alert::toast('Tender berhasil difokuskan')->success()->flash();
            return redirect()->route('app.tender-lpse.index');
        } catch (\Exception $e) {
            DB::rollBack();

            Alert::toast('Gagal memfokuskan paket ' . $e->getMessage())->error()->flash();
            return redirect()->route('app.tender-lpse.index');
        }
    }
}
