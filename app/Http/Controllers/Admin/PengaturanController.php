<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PengaturanDataTable;
use App\Http\Controllers\Controller;
use App\Models\Inbox;
use App\Models\Lelang;
use App\Models\Notification;
use App\Models\NotificationLelang;
use App\Models\Outbox;
use App\Models\Pengaturan;
use App\Models\Tender;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

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
            return redirect()->route('admin.applikasi.index')->with('error', 'Gagal: ' . $e->getMessage());
        }

        return redirect()->route('admin.applikasi.index')->with('success', 'Data Berhasil di Update');
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

            return redirect()->back()->with('success', "Command executed successfully. Output: " . $output);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Error executing command: " . $e->getMessage());
        }
    }

    public function hapusdata(Request $request)
    {

        $request->validate([
            'before' => 'required'
        ]);

        if($request->has('lelang')){
            Lelang::where('created_at', '<', $request->before)->delete();
        }

        if($request->has('tender')){
            Tender::where('created_at', '<', $request->before)->delete();
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

        return redirect()->route('admin.pengaturan.hapus-data')->with('success','Data Berhasil di hapus');
    }

}
