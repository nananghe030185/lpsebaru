<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SatkerDataTable;
use App\Http\Controllers\Controller;
use App\Models\Satker;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SatkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SatkerDataTable $dataTable)
    {
        // Return the DataTable view
        return $dataTable->render('admin.satuankerja.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $satker = Satker::findOrFail($id);
        return view('admin.satuankerja.edit', ['satker' => $satker]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
            $satker = Satker::findOrFail($id);
            $satker->update([
                'nama_satker' => $request->nama_satker,
            ]);

            DB::commit();

            return redirect()->route('admin.satuan-kerja.index')->with('success', __('Satuan Kerja berhasil diupdate'));
        } catch (Exception $e){

            DB::rollback();

            throw $e;
        }
    }


    public function lelang($id, Request $request)
    {
        $model = Satker::findOrFail($id);
        $model->update(['lelang' => $request->status]);
    }

    public function swakelola($id, Request $request)
    {
        $model = Satker::findOrFail($id);
        $model->update(['swakelola' => $request->status]);
    }

    public function reload()
    {
        Artisan::call('app:master-satker');
        // This method can be used to reload the data or perform any necessary actions.
        // For example, you might want to clear cache or refresh data from an external source.
        // return redirect()->route('admin.satuan-kerja.index')->with('success', __('Data Satuan Kerja telah diperbarui'));
        return redirect()->route('admin.satuan-kerja.index')->with('success', __('Data Satuan Kerja telah diperbarui'));
    }

}
