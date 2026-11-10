<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\LpseDataTable;
use App\Http\Controllers\Controller;
use App\Models\Lpse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    public function create()
    {
        return view('admin.lpse.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_lpse' => 'required|numeric|unique:lpses,kode_lpse',
            'nama_lpse' => 'required',
            'link' => 'required|unique:lpses,link',
            'jumlah_paket' => 'required|numeric',
            'jumlah_pagu' => 'required|numeric',
            // 'logo' => 'required|mimes:jpg,jpeg,png,webp|max:2048' // Max 2MB
        ]);

        // buat slug
        if($request->slug === ''){
            $request->input('slug', Str::slug($request->nama_lpse)) ;
        }

        $lpse = Lpse::create([
            'kode_lpse' => $request->kode_lpse,
            'nama_lpse' => $request->nama_lpse,
            'link' => $request->link,
            'slug' => $request->slug,
            'state' => $request->state ?? false,
            'scrape' => $request->scrape ?? false,
            'jumlah_paket' => $request->jumlah_paket,
            'jumlah_pagu' => $request->jumlah_pagu,
            'description' => $request->description,
        ]);

        // Handle file upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('assets/images/logo'), $filename);
            $lpse->update(['logo' => $filename]);
        }

        return redirect()->route('admin.lpse.index')->with('success','LPSE baru telah di tambahkan');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request);
        $request->validate([
            'kode_lpse' => 'required',
            'nama_lpse' => 'required',
            'link' => 'required',
            'jumlah_paket' => 'required|numeric',
            'jumlah_pagu' => 'required|numeric',
            // 'logo' => 'required|mimes:jpg,jpeg,png,webp|max:2048' // Max 2MB
        ]);

        // buat slug
        if($request->slug === ''){
            $request->input('slug', Str::slug($request->nama_lpse)) ;
        }

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

        // Handle file upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('assets/images/logo'), $filename);
            $lpse->update(['logo' => $filename]);
        }
        return redirect()->route('admin.lpse.index')->with('success', __('LPSE berhasil diupdate'));
    }


    public function status(int $id, Request $request)
    {
        $model = Lpse::findOrFail($id);
        $model->update(['state' => $request->status]);
    }

    public function toggle_status()
    {
        $lpses = Lpse::all();
        foreach($lpses as $lpse){
            if(Str::contains($lpse->link,'spse.inaproc.id'))
            {
                $state = !$lpse->state; // Toggle the state 
                $lpse->update(['state' => $state]);
            }
        }

        return redirect()->route('admin.lpse.index')->with('success', __('Status semua LPSE berhasil diubah'));
    }

    public function scrape(int $id, Request $request)
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

    public function destroy(Lpse $lpse)
    {
        $lpse->delete();

        return redirect()->route('admin.lpse.index')->with('success', 'Data berhasil dihapus'); 
    }

    public function map(){
        return view('admin.lpse.map');
    }
}
