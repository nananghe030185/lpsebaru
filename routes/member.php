<?php

use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\FokusController;
use App\Http\Controllers\Member\FokusLelangController;
use App\Http\Controllers\Member\InvoiceController;
use App\Http\Controllers\Member\KlpdiController;
use App\Http\Controllers\Member\LelangController;
use App\Http\Controllers\Member\LpseController;
use App\Http\Controllers\Member\SatkerController;
use App\Http\Controllers\Member\TenderController;
use App\Http\Controllers\Member\TenderKataKunciController;
use App\Http\Controllers\Member\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){
    // redirect to dashboard
    Route::get('/app', function () {  
        return redirect()->route('app.dashboard.index');
    })->name('app.home');

    // Dashboard
    Route::get('/app/dashboard', [DashboardController::class, 'index'])->name('app.dashboard.index');
    
    // Lelang Sirup
    Route::get('/app/lelang-sirup/bulk-fokus', [LelangController::class, 'bulkFokus'])->name('app.lelang-sirup.bulk-fokus');
    Route::get('/app/lelang-sirup/fokus/{lelang}', [LelangController::class, 'fokus'])->name('app.lelang-sirup.fokus');
    Route::resource('/app/lelang-sirup', LelangController::class)->names('app.lelang-sirup')->except(['create','store','show','edit','update','destroy']);
    
    // Fokus lelang dan Paket
    Route::post('app/fokus-lelang/bulk-delete', [FokusLelangController::class, 'bulkDelete'])->name('app.fokus-lelang.bulk-delete');
    Route::resource('/app/fokus-lelang', FokusLelangController::class)->names('app.fokus-lelang')->except(['create','store','show','edit','update']);

    Route::get('app/fokus-paket/unfokus/{fokus_paket}', [FokusController::class, 'unfokus'])->name('app.fokus-paket.unfokus');
    Route::resource('/app/fokus-paket', FokusController::class)->names('app.fokus-paket')->except(['create','store','show','edit','update']);

    // LPSE
    Route::get('/app/lpse', [LpseController::class, 'index'])->name('app.lpse.index');

    // Master Satuan Kerja
    Route::get('/app/satuan-kerja', [SatkerController::class, 'index'])->name('app.satuan-kerja.index');

    // KLPDI
    Route::get('/app/klpdi', [KlpdiController::class, 'index'])->name('app.klpdi.index');

    // Tender LPSE
    Route::get('/app/tender-lpse/bulk-fokus', [TenderController::class, 'bulkFokus'])->name('app.tender-lpse.bulk-fokus');
    Route::get('/app/tender-lpse/fokus/{tender}', [TenderController::class, 'fokus'])->name('app.tender-lpse.fokus');
    Route::resource('/app/tender-lpse', TenderController::class)->names('app.tender-lpse')->except(['create','store','show','edit','update','destroy']);;
    
    Route::get('/app/tender-kata-kunci/bulk-fokus', [TenderKataKunciController::class, 'bulkFokus'])->name('app.tender-kata-kunci.bulk-fokus');
    Route::post('/app/tender-kata-kunci/bulk-delete', [TenderKataKunciController::class, 'bulkDelete'])->name('app.tender-kata-kunci.bulk-delete');
    Route::get('/app/tender-kata-kunci/fokus/{tender_kata_kunci}', [TenderKataKunciController::class, 'fokus'])->name('app.tender-kata-kunci.fokus');
    Route::resource('/app/tender-kata-kunci', TenderKataKunciController::class)->names('app.tender-kata-kunci')->except(['create','store','show','edit','update']);;
    
    // add bulk unfokus route
    Route::get('/app/fokus-paket/bulk-unfokus', [FokusController::class, 'bulkUnfokus'])->name('app.fokus-paket.bulk-unfokus');
    Route::resource('/app/fokus-paket', FokusController::class)->names('app.fokus-paket')->except(['create','store','show','edit','update']);;
    
    Route::get('/app/invoice/{invoice:nomer}/display', [InvoiceController::class, 'display'])->name('app.invoice.display');
    Route::get('/app/invoice/{invoice:nomer}/pay', [InvoiceController::class, 'pay'])->name('app.invoice.pay');
    Route::resource('/app/invoice', InvoiceController::class)->names('app.invoice')->except(['show','edit','update']);
    
    // User
    Route::put('/app/user/update-profile/{user}', [UserController::class,'updateProfile'])->name('app.user.update-profile');
    Route::resource('/app/user', UserController::class)->names('app.user')->except(['index','create','store','show','destroy']);

});