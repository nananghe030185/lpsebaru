<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\DataTables\Admin\UserDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Models\Fokus;
use App\Models\FokusLelang;
use App\Models\Groups;
use App\Models\Notification;
use App\Models\NotificationLelang;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(User $user)
    {
        return view('admin.user.create', ['user' => $user]);
    }

    public function store(CreateUserRequest $request)
    {
        // return $this->repository->store($request);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(User $user)
    {
        $usergroups = Groups::all();
        return view('admin.user.edit', compact(['user','usergroups']));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update (User $user, Request $request)
    {
        // dd($request->all());
        // validate $request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'group_id' => 'required',
        ],[
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'alamat email tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
        ]);
        // update user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->group_id = $request->group_id;
        $user->status = $request->has('status');
        $user->update($validated);
        // redirect back with success message

        Alert::toast('User berhasil diupdate')->success()->flash();
        return redirect()->route('admin.user.index', $user->username); // Exclude password
        

    }

    /**
     * Update Status the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id, Request $request)
    {
        $model = User::findOrFail($id);
        $model->update(['status' => $request->status]);
        return false;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(int $user)
    {
        $user = User::findOrFail($user);
        $user->delete();

        // remove row fokus lelang
        FokusLelang::where('user_id', $user->id)->delete();

        // remode fokus tender
        Fokus::where('user_id', $user->id)->delete();

        // Remove Lelang Notifikation
        NotificationLelang::where('user_id', $user->id)->delete();

        // remove notification tender
        Notification::where('user_id', $user->id)->delete();

        // redirect
        Alert::toast('User berhasil dihapus')->success()->flash();
        return redirect()->route('admin.user.index');
    }
    
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function userProfile()
    {
        return view('admin.user.user-profile',['user' => Auth::user(),'role' => Auth::user()->role->name]);
    }

    public function editProfile()
    {
        $countries = Country::all()->pluck('name','id');
        return view('admin.user_profile.edit_profile',['user' => Auth::user(),'role' => Auth::user()->role->name], compact('countries'));
    }
    public function getStates(Request $request){
    	$data['states'] = State::where("country_id", $request->country_id)->get(["name", "id"]);
        return response()->json($data);
    }

    public function updateProfile(User $user, Request $request){
        // Validate input
        $request->validate([
            'perusahaan' => 'required|string|max:255',
            'masa_berlaku' => 'required|date',
            'whatsapp' => 'starts_with:62|digits_between:10,14',
            'kata_kunci' => 'required|string',
        ],[
            'whatsapp.starts_with' => 'Nomor WhatsApp harus diawali dengan kode negara 62 (Indonesia).',
            'whatsapp.digits_between' => 'Nomor WhatsApp harus terdiri dari 10 hingga 14 digit.',
            'kata_kunci.required' => 'Kata Kunci tidak boleh kosong.',
            'perusahaan.required' => 'Nama Perusahaan tidak boleh kosong.',
            'masa_berlaku.required' => 'Masa berlaku keanggotaan tidak boleh kosong.',
        ]);

        // Update user profile
        $user->perusahaan = $request->perusahaan;
        $user->alamat = $request->alamat;
        $user->kota = $request->kota;
        $user->whatsapp = $request->whatsapp;
        $user->telegram = $request->telegram;
        $user->masa_berlaku = $request->masa_berlaku;
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

        Alert::toast('User Profile berhasil diupdate')->success()->flash();
        return redirect()->back();        
    }
    public function removeImage($id)
    {
        $user = User::find($id);
        $user->clearMediaCollection('image');
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
