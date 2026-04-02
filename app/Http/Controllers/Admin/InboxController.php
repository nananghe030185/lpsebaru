<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\InboxDataTable;
use App\Http\Controllers\Controller;
use App\Models\ErrorLog;
use App\Models\InboxModel;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(InboxDataTable $dataTable)
    {
        return $dataTable->render('admin.inout.inbox');
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
    public function show(InboxModel $inboxModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InboxModel $inboxModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InboxModel $inboxModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InboxModel $inboxModel)
    {
        //
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
