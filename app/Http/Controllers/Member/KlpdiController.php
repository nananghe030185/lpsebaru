<?php

namespace App\Http\Controllers\Member;

use App\DataTables\Member\KlpdiDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KlpdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KlpdiDataTable $datatables)
    {
        return $datatables->render('member.klpdi.index');
    }

}
