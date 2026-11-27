<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\DataTables\Admin\BlogDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class BlogController extends Controller
{
   
    
    /**
     * Display a listing of the resource.
    */
    public function index(BlogDataTable $dataTable)
    {
        return $dataTable->render('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [];
        $tags = [];
        return view('admin.blog.create', compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'content' => $request->content,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status' => 1,
            'created_by_id' => Auth::user()->id
        ]);

        return redirect()->route('admin.blog.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'slug' => 'required'
        ]);

        $blog->update([
            'title' => $request->title,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
            'description' => $request->meta_description,
            'content' => $request->content,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status' => $request->has('status'),
        ]);

        Alert::toast('Artikel berhasil diupdate')->success()->flash();
        return redirect()->route('admin.blog.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        Alert::toast('Artikel berhasl dihapus')->success()->flash();
        return redirect()->route('admin.blog.index');
    }

    public function status(int $id, Request $request)
    {
        $model = Blog::findOrFail($id);
        $model->update(['state' => $request->status]);
    }

    public function removeImage($id)
    {
        $media = Media::find($id);
        $media->delete();
        Alert::toast('Gambar berhasil dihapus')->success()->flash();
        return redirect()->back();
    }
}
