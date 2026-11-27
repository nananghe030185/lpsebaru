<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PengaturanDataTable;
use App\Http\Controllers\Controller;
use App\Models\Fokus;
use App\Models\FokusLelang;
use App\Models\Inbox;
use App\Models\Lelang;
use App\Models\Notification;
use App\Models\NotificationLelang;
use App\Models\Outbox;
use App\Models\Pengaturan;
use App\Models\Tender;
use App\Models\TenderKeyword;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use RealRashid\SweetAlert\Facades\Alert;

class PengaturanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PengaturanDataTable $dataTable)
    {
        return $dataTable->render('admin.pengaturan.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengaturan $applikasi)
    {
        return view('admin.pengaturan.edit', ['pengaturan' => $applikasi]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengaturan $applikasi)
    {
        DB::beginTransaction();
        try{
            $applikasi->update([
                'value' => $request->value
            ]);

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            Alert::toast('Gagal : ' . $e->getMessage())->error()->flash();
            return redirect()->route('admin.applikasi.index');
        }

        Alert::toast('Data Pengaturan berhasil diupdate')->success()->flash();
        return redirect()->route('admin.applikasi.index');
    }

    /**
     * Run an Artisan command.
     */
    public function artisanRun(Request $request)
    {
        $command = $request->input('command');
        try {
            // Run the Artisan command
            Artisan::call($command);

            // Get the output of the command
            $output = Artisan::output();

            Alert::toast('Perintah berhasil dijalankan. Output ' . $output)->success()->flash();
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('Error executing comman ' . $e->getMessage())->error()->flash();
            return redirect()->back();
        }
    }

    public function hapusdata(Request $request)
    {

        $request->validate([
            'before' => 'required'
        ]);

        if($request->has('lelang')){
            $datalelangs = Lelang::where('created_at', '<', $request->before)->get();
            foreach($datalelangs as $datalelang){
                $datalelang->delete();
                // remove data lelang fokus
                FokusLelang::findOrFail($datalelang->id);
            }
        }

        if($request->has('tender')){
            $dataTenders = Tender::where('created_at', '<', $request->before)->get();
            foreach($dataTenders as $dataTender)
                {
                    $dataTender->delete();

                    // delete data fokus
                    Fokus::where('tender_id', $dataTender->tender_id)->delete();
                    TenderKeyword::where('tender_id',  $dataTender->tender_id)->delete();
                }
        }

        if($request->has('inbox')){
            Inbox::where('created_at', '<', $request->before)->delete();
        }

        if($request->has('outbox')){
            Outbox::where('created_at', '<', $request->before)->delete();
        }

        if($request->has('notification_lelang')){
            NotificationLelang::where('created_at', '<', $request->before)->delete();
        }

        if($request->has('notification_tender')){
            Notification::where('created_at', '<', $request->before)->delete();
        }

        Alert::toast('Data berhasil dihapus')->success()->flash();
        return redirect()->route('admin.pengaturan.hapus-data');
    }

}
