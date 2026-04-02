<?php

namespace App\Http\Controllers\Member;

use App\DataTables\Member\FokusDataTable;
use App\Http\Controllers\Controller;
use App\Models\Fokus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FokusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FokusDataTable $dataTable)
    {
        return $dataTable->render('member.fokuspaket.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fokus $fokus_paket)
    {
        DB::beginTransaction();
        try{
            $fokus_paket->delete();
            DB::commit();
            return redirect()->route('app.fokus-paket.index')->with('success', __('Data telah di hapus'));
        }catch(Exception $e){
            DB::rollback();
            throw $e;
            return redirect()->route('app.fokus-paket.index')->with('danger', __('Hapus Data Gagal'));
        }
    }

    public function unfokus(Fokus $fokus_paket)
    {
        DB::beginTransaction();
        try{
            $fokus_paket->update([
                'fokus' => false
            ]);

            DB::commit();
            return redirect()->route('app.fokus-paket.index')->with('success', __('Melepaskan Fokus Paket tender berhasil'));
        }catch(Exception $e){
            DB::rollback();
            throw $e;
            return redirect()->route('app.fokus-paket.index')->with('danger', __('Gagal Melepaskan Fokus Paket tender'));
        }

    }

    public function bulkUnfokus(Request $request)
    {
        
        $ids = explode(',', $request->input('ids', ''));
        if (empty($ids)) {
            return response()->json(['message' => 'No items selected for unfocusing.'], 400);
        }

        DB::beginTransaction();
        try {
            Fokus::whereIn('id', $ids)->update(['fokus' => false]);
            DB::commit();
            return response()->json(['message' => 'Selected items unfocused successfully.']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error unfocusing items: ' . $e->getMessage()], 500);
        }
    }
}
