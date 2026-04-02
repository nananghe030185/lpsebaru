<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\Admin\AutoResponDataTable;
use App\Models\AutoRespon;
use Illuminate\Http\Request;

class AutoResponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AutoResponDataTable $dataTable)
    {
        return $dataTable->render('admin.autorespon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.autorespon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|max:255',
            'response' => 'required|string',
            'whatsapp' => 'required|string',
            'telegram' => 'required|string',
        ]);

        AutoRespon::create([
            'keyword' => $request->keyword,
            'response' => $request->response,
            'whatsapp' => $request->whatsapp,
            'telegram' => $request->telegram,
        ]);

        return redirect()->route('admin.auto-respon.index')
            ->with('success', __('Auto Respon created successfully.'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function status($id, Request $request)
    {
        $model = AutoRespon::findOrFail($id);
        $model->update(['status' => $request->status]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function whatsapp($id, Request $request)
    {
        $model = AutoRespon::findOrFail($id);
        $model->update(['whatsapp' => $request->whatsapp]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function telegram($id, Request $request)
    {
        $model = AutoRespon::findOrFail($id);
        $model->update(['telegram' => $request->telegram]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            AutoRespon::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Data berhasil dihapus.']);
        }
        return response()->json(['message' => 'Tidak ada data yang dipilih.'], 400);
    }
    /**
     * Display the specified resource.
     */
    public function show(AutoRespon $autoRespon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AutoRespon $autoRespon)
    {
        return view('admin.autorespon.edit', ['autorespon' => $autoRespon]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AutoRespon $autoRespon)
    {
        //
        $request->validate([
            'keyword' => 'required|string|max:255',
            'response' => 'required|string',
            'channel' => 'required|string|max:255',
        ]);
        $autoRespon->update([
            'keyword' => $request->keyword,
            'response' => $request->response,
            'channel' => $request->channel,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.auto-respon.index')->with('success', __('Auto Respon berhasil diupdate'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AutoRespon $autoRespon)
    {
        //
    }
}
