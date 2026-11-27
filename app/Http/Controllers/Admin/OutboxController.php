<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\OutboxDataTable;
use App\Http\Controllers\Controller;
use App\Models\Outbox;
use App\Models\OutboxModel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class OutboxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OutboxDataTable $dataTable)
    {
        

        return $dataTable->render('admin.inout.outbox');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OutboxModel $outboxModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutboxModel $outboxModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OutboxModel $outboxModel)
    {
        //
    }

    /**
     * Resend Outbox Item
     */
    public function resend(OutboxModel $outbox){
        $outbox->update([
            'status' => false
        ]);
        Alert::toast('Data dalam antrian')->success()->flash();
        return redirect()->route('admin.inout.outbox.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutboxModel $outbox)
    {
        $outbox->delete();
        Alert::toast('Data Outbox berhasil dihapus')->success()->flash();
        return redirect()->route('admin.inout.outbox.index');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            Outbox::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Data berhasil dihapus.']);
        }
        return response()->json(['message' => 'Tidak ada data yang dipilih.'], 400);
    }

    public function bulkResend(Request $request)
    {
        // 
         $ids = $request->input('ids', []);
        if (!empty($ids)) {
            Outbox::whereIn('id', $ids)->update([
                'status' => 0
            ]);
            return response()->json(['message' => 'Data berhasil di kirim ulang.']);
        }
        return response()->json(['message' => 'Tidak ada data yang dipilih.'], 400);
    }
}
