<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\KuponDataTable;
use App\Http\Controllers\Controller;
use App\Models\Kupon;
use App\Models\User;
use Illuminate\Http\Request;
use illuminate\Support\Str;

class KuponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KuponDataTable $datatables)
    {
        return $datatables->render('admin.kupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:kupons,kode',
            'diskon' => 'required|numeric',
            'masa_berlaku' => 'required'
        ],[
            'kode.required' => 'Kode Kupon tidak boleh kosong',
            'diskon.required' => 'diskon tidak boleh kosong',
            'masa_berlaku.required' => 'masa berlaku tidak boleh kosong'
        ]);
        
        Kupon::create([
            'status' => $request->status,
            'kode' => Str::upper($request->kode),
            'diskon' => $request->diskon,
            'masa_berlaku' => $request->masa_berlaku,
            'keterangan' => $request->keterangan,
            'stok' => $request->stok
        ]);

        return redirect()->route('admin.kupon.index')->with('success', 'Kupon created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kupon $kupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kupon $kupon)
    {
        return view('admin.kupon.edit', compact('kupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kupon $kupon)
    {
         $request->validate([
            'status' => 'required',
            'kode' => 'required|string|max:255',
            'diskon' => 'required|numeric',
            'masa_berlaku' => 'required|date',
        ]);

        $kupon->update([
            'status' => $request->status,
            'kode' => $request->kode,
            'diskon' => $request->diskon,
            'masa_berlaku' => $request->masa_berlaku,
        ]);

        return redirect()->route('admin.kupon.index')->with('success', 'Kupon update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kupon $kupon)
    {
        //
    }

    /***
     * Perintah untuk menghapus data masal
     */
    public function bulkDelete(Request $request)
    {
        // 
         $ids = $request->input('ids', []);
        if (!empty($ids)) {
            Kupon::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Data berhasil dihapus.']);
        }
        return response()->json(['message' => 'Tidak ada data yang dipilih.'], 400);
    }

    public function status(int $id, Request $request)
    {
        $model = Kupon::findOrFail($id);
        $model->update(['status' => $request->status]);
    }
}
