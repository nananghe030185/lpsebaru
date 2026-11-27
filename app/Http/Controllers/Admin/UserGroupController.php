<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UserGroupDataTable;
use App\Models\Groups;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserGroupDataTable $dataTable)
    {
        return $dataTable->render('admin.group.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Groups $groups)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Groups $group)
    {
        return view('admin.group.edit', ['group' => $group]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Groups $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $group->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        Alert::toast('User Group berhasil diupdate')->success()->flash();
        return redirect()->route('admin.user.group.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Groups $groups)
    {
        //
    }
}
