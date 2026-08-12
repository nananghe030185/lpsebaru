<?php

use App\Http\Controllers\Admin\LelangController;
use App\Http\Controllers\Admin\TenderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


Route::get('/install', function(){
    return 'OK';
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/r/tender/{tender:slug}', [TenderController::class, 'redirect'])->name('redirect.tender');
Route::get('/r/tender/tahapan/{tender:slug}', [TenderController::class, 'tahapan'])->name('redirect.tender.tahapan');
Route::get('/r/lelang/{lelang:slug}', [LelangController::class, 'redirect'])->name('redirect.lelang');

require __DIR__.'/admin.php';
require __DIR__.'/member.php';
require __DIR__.'/auth.php';
