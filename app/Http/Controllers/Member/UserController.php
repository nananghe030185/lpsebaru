<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get html response 
        // $html = Http::get('https://spse.inaproc.id/polri')->body();
        // $hasil = Str::of($html)->contains('Lembaga Kebijakan Pengadaan Barang/Jasa Pemerintah');
        // return;
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('member.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update (User $user, Request $request)
    {
        // validate $request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        ],[
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'alamat email tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
        ]);
        // update user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        // redirect back with success message
        Alert::toast('Profil berhasil diupdate')->success()->flash();
        return redirect()->back();
    }

    public function updateProfile(User $user, Request $request){
        // Validate input
        $request->validate([
            'perusahaan' => 'required|string|max:255',
            'whatsapp' => 'starts_with:62|digits_between:10,14',
            'kata_kunci' => 'required|string',
        ],
        [
            'whatsapp.starts_with' => 'Nomor WhatsApp harus diawali dengan kode negara 62 (Indonesia).',
            'whatsapp.digits_between' => 'Nomor WhatsApp harus terdiri dari 10 hingga 14 digit.',
            'kata_kunci.required' => 'Kata Kunci tidak boleh kosong.',
            'perusahaan.required' => 'Nama Perusahaan tidak boleh kosong.',
        ]);


        // Update user profile
        $user->perusahaan = $request->perusahaan;
        $user->alamat = $request->alamat;
        $user->kota = $request->kota;
        $user->whatsapp = $request->whatsapp;
        $user->telegram = $request->telegram;
        $user->notif_email_tender = $request->has('notif_email_tender');
        $user->notif_email_lelang = $request->has('notif_email_lelang');
        $user->notif_whatsapp_tender = $request->has('notif_whatsapp_tender');
        $user->notif_whatsapp_lelang = $request->has('notif_whatsapp_lelang');
        $user->notif_telegram_tender = $request->has('notif_telegram_tender');
        $user->notif_telegram_lelang = $request->has('notif_telegram_lelang');
        
        $kataKunci = $request->input('kata_kunci');
        if ($kataKunci) {
            $tags = collect(json_decode($kataKunci, true))->pluck('value')->toArray();
            // Save as comma separated string or as array (if your DB supports JSON)
            $user->kata_kunci = implode(',', $tags);
        }

        $kbli = $request->input('kbli');
        if ($kbli) {
            $tags = collect(json_decode($kbli, true))->pluck('value')->toArray();
            // Save as comma separated string or as array (if your DB supports JSON)
            $user->kbli = implode(',', $tags);
        }
        
        $user->save();

        if ($request->hasFile('images') && $request->file('images')->isValid()) {
            $user->addMedia($request->file('images'))->toMediaCollection('images');
        }

        Alert::toast('Profile berhasil diupdate')->success()->flash();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function removeImage(int $id)
    {
        $media = Media::find($id);
        $media->delete();
        Alert::toast('Gambar berhasil di hapus')->success()->flash();
        return redirect()->back();
    }

    public function updateImage(User $user, Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {

            $user->addMediaFromRequest('image')->toMediaCollection('image');

            Alert::toast('Gambar berhasil diupdate')->success()->flash();
            return redirect()->back();
        } catch (Exception $e) {
            Alert::toast('Gagal mengupdate gambar '. $e->getMessage())->error()->flash();
            return redirect()->back();
        }
    }
}
