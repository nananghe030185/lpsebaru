<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\KlpdiDataTable;
use App\Http\Controllers\Controller;
use App\Models\Klpdi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class KlpdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KlpdiDataTable $datatables)
    {
        return $datatables->render('admin.klpdi.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Klpdi $klpdi)
    {
        return view('admin.klpdi.edit', compact('klpdi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Klpdi $klpdi)
    {
        $request->validate([
            'jenis_klpdi' => 'required|string|max:50',
            'nama_klpdi' => 'required|string|max:255',
            'kode_kabupaten' => 'nullable|string|max:10',
            'kode_klpdi' => 'required|string|max:10',
            'kode_provinsi' => 'nullable|string|max:10',
        ]);
        $klpdi->update($request->only(['jenis_klpdi', 'nama_klpdi', 'kode_kabupaten', 'kode_klpdi', 'kode_provinsi']));
        
        return redirect()->route('admin.klpdi.index')->with('success', __('Data KLPDI telah diperbarui'));
    }
    /**
    * reload the resource.
    */
    public function reload()
    {
        Artisan::call('app:master-klpdi');
        // This method can be used to reload the data or perform any necessary actions.
        // For example, you might want to clear cache or refresh data from an external source.
        // return redirect()->route('admin.klpdi.index')->with('success', __('Data KLPDI telah diperbarui'));
        return redirect()->route('admin.klpdi.index')->with('success', __('Data KLPDI telah diperbarui'));
    }
}
