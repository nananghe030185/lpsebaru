<?php
namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PengumumanDataTable;
use App\Http\Controllers\Controller;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PengumumanDataTable $dataTable)
    {
        //
        return $dataTable->render('admin.pengumuman.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pengumuman.create', ['pengumuman' => new Pengumuman()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'message' => 'required|string|between:1,68',
            'status' => 'required|in:0,1',
            'expire' => 'nullable|date',
        ]);
        Pengumuman::create([
            'message' => $request->message,
            'status' => $request->status,
            'expire' => $request->expire,
        ]);
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman)
    {
        //
        return view('admin.pengumuman.edit', ['pengumuman' => $pengumuman]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        //
        $request->validate([
            'message' => 'required|string|between:1,68',
            'status' => 'required|in:0,1',
            'expire' => 'nullable|date',
        ]);
        $pengumuman->update([
            'message' => $request->message,
            'status' => $request->status,
            'expire' => $request->expire,
        ]);
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman deleted successfully.');
    }

    /**
     * Bulk delete the specified resources from storage.
     */
    public function bulkDelete(Request $request)
    {
        // 
         $ids = $request->input('ids', []);
        if (!empty($ids)) {
            Pengumuman::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Data berhasil dihapus.']);
        }
        return response()->json(['message' => 'Tidak ada data yang dipilih.'], 400);
    }

    /**
     * Update the status of the specified resource.
     */
    public function status($id, Request $request)
    {
        $model = Pengumuman::findOrFail($id);
        $model->update(['status' => $request->status]);
    }
}
