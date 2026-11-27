<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Lelang;
use App\Models\Tender;

class FrontendController extends Controller
{
    //
    public function home()
    {
        $title = 'LPSE Indonesia';
        $description = 'LPSE Indonesia';
        return view('frontend.home', compact('title','description'));
    }

    public function tender()
    {
        $title = 'LPSE Indonesia : Tender LPSE';
        $tenders = Tender::take(5)->get();
        $description = 'ini descriptioannya';
        return view('frontend.tender', compact('title','tenders', 'description'));
    }

    public function tenderdetail(Tender $tender)
    {
        $title = 'LPSE Indonesia : ' . $tender->nama_paket;
        $description = 'ini descriptioannya';
        return view('frontend.tenderdetail', compact('title','tender', 'description'));
    }

    public function lelang()
    {
        $title = 'LPSE Indonesia : Lelang Sirup';
        $lelangs = Lelang::take(5)->get();
        $description = 'ini deskription lelang';
        return view('frontend.lelang', compact('title','lelangs', 'description'));
    }

    public function lelangdetail(Lelang $lelang)
    {
        $title = 'LPSE Indonesia : ' . $lelang->nama_paket;
        $description = 'ini deskription lelang';
        return view('frontend.lelangdetail', compact('title','lelang', 'description'));
    }

    public function harga()
    {
        $title = 'LPSE Indonesia : Harga';
        $description = 'ini deskription harga';
        return view('frontend.harga', compact('title','description'));
    }

    public function blog()
    {
        $title = 'LPSE Indonesia : Blog';
        $description = 'ini deskription blog';
        $blogs = Blog::take(3)->get();
        return view('frontend.blog', compact('title','description','blogs'));
    }

    public function blogdetail(Blog $blog)
    {
        $title = $blog->title;
        $description = $blog->description;
        return view('frontend.blogdetail', compact('title','description','blog'));
    }
}
