<?php

namespace App\Http\Controllers\Member;

use App\DataTables\Member\SatkerDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SatkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(SatkerDataTable $dataTable)
    {
        // Return the DataTable view
        return $dataTable->render('member.satuankerja.index');
    }

}
