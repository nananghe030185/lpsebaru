<?php

namespace App\Http\Controllers\Member;

use App\DataTables\Member\LpseDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LpseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LpseDataTable $datatables)
    {
        return $datatables->render('member.lpse.index');
    }
}
