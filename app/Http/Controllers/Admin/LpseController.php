<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\LpseDataTable;
use App\Http\Controllers\Controller;
use App\Models\Lpse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class LpseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LpseDataTable $datatables)
    {
        return $datatables->render('admin.lpse.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lpse $lpse)
    {
        //
        return view('admin.lpse.edit', ['lpse' => $lpse]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $lpse = Lpse::findOrFail($id);
        $lpse->update([
            'kode_lpse' => $request->kode_lpse,
            'nama_lpse' => $request->nama_lpse,
            'link' => $request->link,
            'jumlah_paket' => $request->jumlah_paket,
            'jumlah_pagu' => $request->jumlah_pagu,
            'slug' => $request->slug,
            'description' => $request->description,
            'state' => $request->state ?? false,
            'scrape' => $request->scrape ?? false,
        ]);

        return redirect()->route('admin.lpse.index')->with('success', __('LPSE berhasil diupdate'));
    }


    public function status($id, Request $request)
    {
        $model = Lpse::findOrFail($id);
        $model->update(['state' => $request->status]);
    }

    public function scrape($id, Request $request)
    {
        $model = Lpse::findOrFail($id);
        $model->update(['scrape' => $request->status]);
    }

    public function unscrapeall()
    {
        Lpse::query()->update(['scrape' => false]); // Reset all scrape status
        return redirect()->route('admin.lpse.index')->with('success', 'Semua data LPSE berhasil diupdate.');
    }

    public function reload()
    {
        Artisan::call('app:master-lpse');
        // This method can be used to reload the data or perform any necessary actions.
        // For example, you might want to clear cache or refresh data from an external source.
        return redirect()->route('admin.lpse.index')->with('success', __('Data LPSE telah diperbarui'));
    }
}
