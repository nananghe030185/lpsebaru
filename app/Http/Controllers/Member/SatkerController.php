<?php

namespace App\Http\Controllers\Member;

use App\DataTables\Member\SatkerDataTable;
use App\Http\Controllers\Controller;
use App\Models\Klpdi;
use Illuminate\Http\Request;

class SatkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(SatkerDataTable $dataTable)
    {
        // $klpdi = Klpdi::where('kode_klpdi', 'D35')->first();
        // dd($klpdi);
        // Return the DataTable view
        return $dataTable->render('member.satuankerja.index');
    }

}
