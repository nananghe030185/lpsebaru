<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\KomisiDataTable;
use App\Http\Controllers\Controller;

use App\Models\Komisi;
use Illuminate\Http\Request;

class KomisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KomisiDataTable $dataTable)
    {
        return $dataTable->render('admin.laporan.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Komisi $komisi)
    {
        $komisi->delete();
        return redirect()->route('admin.laporan.komisi.index')->with('success', 'Komisi deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            Komisi::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Data berhasil dihapus.']);
        }
        return response()->json(['message' => 'Tidak ada data yang dipilih.'], 400);
    }

    public function status($id, Request $request)
    {
        $model = Komisi::findOrFail($id);
        $model->update(['state' => $request->state]);
 
        return redirect()->route('admin.laporan.komisi.index')->with('success', 'Komisi update state successfully.');
    }
}
