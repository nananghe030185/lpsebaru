<?php

namespace App\Http\Controllers;

use App\DataTables\Admin\ErrorLogDataTable;
use App\Models\ErrorLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ErrorLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ErrorLogDataTable $dataTable)
    {
        return $dataTable->render('admin.errorlog.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ErrorLog $errorlog)
    {
        DB::beginTransaction();
        try{
            $errorlog->delete();
            DB::commit();
            return redirect()->route('admin.errorlog.index')->with('success', __('Data telah di hapus'));
        }catch(Exception $e){
            DB::rollback();
            throw $e;
            return redirect()->route('admin.errorlog.index')->with('danger', __('Hapus Data Gagal'));
        }
    }

    public function bulkDelete(Request $request)
    {
        // 
         $ids = $request->input('ids', []);
        if (!empty($ids)) {
            ErrorLog::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Data berhasil dihapus.']);
        }
        return response()->json(['message' => 'Tidak ada data yang dipilih.'], 400);
    }
}
