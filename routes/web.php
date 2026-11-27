<?php

use App\Http\Controllers\Admin\LelangController;
use App\Http\Controllers\Admin\TenderController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InstallController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

Route::get('/update', function(){
    // Run a simple terminal command
    $result = Process::run('composer update');
    return 'Done';
});

Route::get('/scrape-lpse', function(){
    Artisan::call('scrape:tender-lpse');
    return 'Done ...<a href="' . route('dashboard') . '">Go to Dashboard</a> <p>'. Artisan::output() .'</p>';
});

Route::get('/install/{pwd}', [InstallController::class, 'app'])->name('install.app');

Route::get('/install/dbseed/{pwd}', [InstallController::class, 'dbseed'])->name('install.app.seed');

// home
Route::get('/', function(){
    return redirect()->route('login');
});

Route::get('/home', [FrontendController::class, 'home'])->name('frontend.home');
Route::get('/tender', [FrontendController::class, 'tender'])->name('frontend.tender');
Route::get('/tender/{tender:slug}', [FrontendController::class, 'tenderdetail'])->name('frontend.tender.detail');
Route::get('/lelang', [FrontendController::class, 'lelang'])->name('frontend.lelang');
Route::get('/lelang/{lelang:slug}', [FrontendController::class, 'lelangdetail'])->name('frontend.lelang.detail');
Route::get('/harga', [FrontendController::class, 'harga'])->name('frontend.harga');
Route::get('/blog', [FrontendController::class, 'blog'])->name('frontend.blog');
Route::get('/p/{blog:slug}', [FrontendController::class, 'blogdetail'])->name('frontend.blog.detail');
Route::get('/dashboard', function () {
    return redirect()->to(route('app.dashboard.index'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/r/tender/{tender:slug}', [TenderController::class, 'redirect'])->name('redirect.tender');
Route::get('/r/tender/tahapan/{tender:slug}', [TenderController::class, 'tahapan'])->name('redirect.tender.tahapan');
Route::get('/r/lelang/{lelang:slug}', [LelangController::class, 'redirect'])->name('redirect.lelang');

// Page Tender Frontend
Route::get('/p/tender/{tender:slug}', [TenderController::class, 'page'])->name('page.tender');

require __DIR__.'/admin.php';
require __DIR__.'/member.php';
require __DIR__.'/auth.php';
