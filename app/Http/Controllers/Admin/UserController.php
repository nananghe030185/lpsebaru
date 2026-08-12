<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\DataTables\Admin\UserDataTable;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\Admin\UpdateProfileRequest;

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
        // $countries = Country::all()->pluck('name','id');
        // return view('admin.user.edit', ['user' => $user, 'roles' => $this->role->get()], compact('countries'));
        return view('admin.user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update (User $user, Request $request)
    {
        // validate $request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'group_id' => 'required',
        ]);
        // update user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->group_id = $request->group_id;
        $user->update($validated);
        // redirect back with success message
        return redirect()->route('admin.user.edit', $user->username)->with('success', __('User updated successfully'))
            ->withInput($request->except('password')); // Exclude password
        

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
    public function destroy(User $user)
    {
        // return $this->repository->destroy($user->id);
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
        ]);

        // Update user profile
        $user->perusahaan = $request->perusahaan;
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

        return redirect()->back()->with('success', __('Profile updated successfully'));        
    }
    public function removeImage($id)
    {
        $user = User::find($id);
        $user->clearMediaCollection('image');
        return redirect()->back()->with('success', 'Image removed successfully');
    }

    public function updateImage(User $user, Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $user->addMediaFromRequest('image')->toMediaCollection('image');
            return redirect()->back()->with('success', __('Image updated successfully'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(__('Failed to update image: ') . $e->getMessage());
        }
    }
}
