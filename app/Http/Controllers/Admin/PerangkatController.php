<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PerangkatDataTable;
use App\Http\Controllers\Controller;

use App\Models\Perangkat;
use Illuminate\Http\Request;

class PerangkatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PerangkatDataTable $dataTable)
    {
        return $dataTable->render('admin.pengaturan.device');
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
    public function show(Perangkat $deviceModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perangkat $deviceModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perangkat $deviceModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perangkat $deviceModel)
    {
        //
    }
}
