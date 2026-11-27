<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\KlpdiDataTable;
use App\Http\Controllers\Controller;
use App\Models\Klpdi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use RealRashid\SweetAlert\Facades\Alert;

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
            'kode_provinsi' => 'nullable|string|max:10'
        ]);

        $klpdi->update($request->only(['jenis_klpdi', 'nama_klpdi', 'kode_kabupaten', 'kode_klpdi', 'kode_provinsi']));
        
        Alert::toast('Data KLPDI berhasil diupdate')->success()->flash();
        return redirect()->route('admin.klpdi.index');
    }
    /**
    * reload the resource.
    */
    public function reload()
    {
        Artisan::call('app:master-klpdi');
        
        Alert::toast('Data KLPDI berhasil diupdate')->success()->flash();
        return redirect()->route('admin.klpdi.index');
    }
}
