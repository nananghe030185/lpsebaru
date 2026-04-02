<?php

namespace App\Http\Controllers\Member;

use App\DataTables\Member\TenderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Fokus;
use App\Models\Tender;
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
        return $dataTable->render('member.tender.index');
    }

    public function fokus(Tender $tender)
    {
        $user_id = Auth::user()->id;

        // Check if the tender is already focused
        if (Fokus::where('tender_id', $tender->id)->where('user_id',$user_id)->exists()) {
            return redirect()->route('app.tender-lpse.index')->with('error', 'Paket sudah difokuskan sebelumnya');
        }

        try{
            DB::beginTransaction();
            // Create a new Fokus record
            $fokus = new Fokus();
            $fokus->tender_id = $tender->id;
            $fokus->lpse_id = $tender->lpse_id; // Assuming you want to set the lpse_id from the tender
            $fokus->user_id = $user_id; // Assuming you want to set the user_id to the currently authenticated user
            $fokus->fokus = true;
            $fokus->save();

            DB::commit();
        }catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('app.tender-lpse.index')->with('error', 'Gagal memfokuskan paket: ' . $e->getMessage());
        }

        return redirect()->route('app.tender-lpse.index')->with('success', 'Paket telah difokuskan');
    }

    public function bulkFokus(Request $request)
    {
       $ids = $request->input('ids', []);

       // exit if no IDs are provided
        if (empty($ids)) {
            return redirect()->route('app.tender-lpse.index')->with('warning', 'Tidak ada paket yang dipilih untuk difokuskan.');
        }   
        // explode the ids to ensure they are in array format
        $ids = explode(',', $ids);

        DB::beginTransaction();
        try {
            foreach ($ids as $id) {
                $tender = Tender::findOrFail($id);
                if (!Fokus::where('tender_id', $tender->id)->where('user_id', Auth::id())->exists()) {
                    Fokus::create([
                        'tender_id' => $tender->id,
                        'lpse_id' => $tender->lpse_id,
                        'user_id' => Auth::id(),
                        'fokus' => true,
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('app.tender-lpse.index')->with('success', 'Paket berhasil difokuskan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('app.tender-lpse.index')->with('error', 'Gagal memfokuskan paket: ' . $e->getMessage());
        }
    }
}
