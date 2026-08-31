<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BroadcastController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FokusController;
use App\Http\Controllers\Admin\FokusLelangController;
use App\Http\Controllers\Admin\InboxController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\Admin\KlpdiController;
use App\Http\Controllers\Admin\KomisiController;
use App\Http\Controllers\Admin\LelangController;
use App\Http\Controllers\Admin\LpseController;
use App\Http\Controllers\Admin\OutboxController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SatkerController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TenderController;
use App\Http\Controllers\Admin\TenderKataKunciController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WhatsappController;
use App\Http\Controllers\Admin\AutoResponController;
use App\Http\Controllers\Admin\UserGroupController;
use App\Http\Controllers\ErrorLogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','admin'])->group(function () {
    // redirect to dashboard
    Route::get('/admin', function () {  
        return redirect()->route('admin.dashboard');
    })->name('admin.home');

    // dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Invoice
    Route::post('/admin/invoice/bulk-delete', [InvoiceController::class, 'bulkDelete'])->name('admin.invoice.bulk-delete');
    Route::get('/admin/invoice/{invoice:nomer}/display', [InvoiceController::class, 'display'])->name('admin.invoice.display');
    Route::get('/admin/invoice/{invoice:nomer}/pay', [InvoiceController::class, 'pay'])->name('admin.invoice.pay');
    Route::resource('/admin/invoice', InvoiceController::class)->names('admin.invoice')->except(['edit','update']);;

    // Broadcast
    Route::get('/admin/broadcast/email', [BroadcastController::class, 'email'])->name('admin.broadcast.email');
    Route::get('/admin/broadcast/member', [BroadcastController::class, 'member'])->name('admin.broadcast.member');
    Route::get('/admin/broadcast/whatsapp', [BroadcastController::class, 'whatsapp'])->name('admin.broadcast.whatsapp');
    Route::get('/admin/broadcast/telegram', [BroadcastController::class, 'telegram'])->name('admin.broadcast.telegram');
    Route::post('/admin/broadcast/telegram/member', [BroadcastController::class, 'telegrammember'])->name('admin.broadcast.telegram.member');
    Route::post('/admin/broadcast/telegram/nonmember', [BroadcastController::class, 'telegramnonmember'])->name('admin.broadcast.telegram.nonmember');
    Route::post('/admin/broadcast/telegram/semua', [BroadcastController::class, 'telegramsemua'])->name('admin.broadcast.telegram.semua');
    Route::post('/admin/broadcast/telegram/outer', [BroadcastController::class, 'telegramouter'])->name('admin.broadcast.telegram.outer');


    // inbox
    Route::post('/admin/inout/inbox/bulk-delete', [InboxController::class, 'bulkDelete'])->name('admin.inout.inbox.bulk-delete');
    Route::resource('/admin/inout/inbox', InboxController::class)->names('admin.inout.inbox');

    // outbox
    Route::post('/admin/inout/outbox/bulk-delete', [OutboxController::class, 'bulkDelete'])->name('admin.inout.outbox.bulk-delete');
    Route::get('/admin/inout/outbox/resend/{outbox}', [OutboxController::class, 'resend'])->name('admin.inout.outbox.resend');
    Route::resource('/admin/inout/outbox', OutboxController::class)->names('admin.inout.outbox');
    
    // KLPDI
    Route::get('/admin/klpdi/reload', [KlpdiController::class, 'reload'])->name('admin.klpdi.reload');
    Route::resource('/admin/klpdi', KlpdiController::class)->names('admin.klpdi')->except(['create','store','show','destroy']);;
    
    // Lelang Sirup
    Route::get('/admin/lelang-sirup/fokus/{lelang}', [LelangController::class, 'fokus'])->name('admin.lelang-sirup.fokus');
    Route::post('/admin/lelang-sirup/bulk-delete', [LelangController::class, 'bulkDelete'])->name('admin.lelang-sirup.bulk-delete');
    Route::resource('/admin/lelang-sirup', LelangController::class)->names('admin.lelang-sirup')->except(['create','store','show','edit','update','destroy']);;
    
    // LPSE
    Route::put('/admin/lpse/status/{id}', [LpseController::class, 'status'])->name('admin.lpse.state');
    Route::put('/admin/lpse/scrape/{id}', [LpseController::class, 'scrape'])->name('admin.lpse.scrape');
    Route::get('/admin/lpse/unscrapeall', [LpseController::class, 'unscrapeall'])->name('admin.lpse.unscrape-all');
    Route::get('/admin/lpse/reload', [LpseController::class, 'reload'])->name('admin.lpse.reload');
    Route::get('/admin/lpse/map', [LpseController::class, 'map'])->name('admin.lpse.map');
    Route::resource('/admin/lpse', LpseController::class)->names('admin.lpse')->except(['store','show','destroy']);;
    
    // Pengaturan
    Route::resource('/admin/pengaturan/applikasi', PengaturanController::class)->names('admin.applikasi')->except(['create','store','show','destroy']);;
    // Route::resource('/admin/pengaturan/perangkat', WhatsappController::class)->names('admin.whatsapp');
    Route::get('/admin/pengaturan/hapus-data', function () {
        return view('admin.pengaturan.hapus');
    })->name('admin.pengaturan.hapus-data');
    Route::get('/admin/pengaturan/artisan', function () {
        return view('admin.pengaturan.artisan');
    })->name('admin.pengaturan.artisan');
    Route::post('/admin/pengaturan/artisan/run', [PengaturanController::class, 'artisanRun'])->name('admin.pengaturan.artisan.run');

    // Auto Respon
    Route::put('/admin/auto-respon/status/{autorespon}', [AutoResponController::class, 'status'])->name('admin.auto-respon.status');
    Route::put('/admin/auto-respon/whatsapp/{autorespon}', [AutoResponController::class, 'whatsapp'])->name('admin.auto-respon.whatsapp');
    Route::put('/admin/auto-respon/telegram/{autorespon}', [AutoResponController::class, 'telegram'])->name('admin.auto-respon.telegram');
    Route::post('/admin/auto-respon/bulk-delete', [AutoResponController::class, 'bulkDelete'])->name('admin.auto-respon.bulk-delete');
    Route::resource('/admin/auto-respon', AutoResponController::class)->names('admin.auto-respon');

    // Master Satuan Kerja
    Route::put('/admin/satuan-kerja/swakelola/{id}', [SatkerController::class, 'swakelola'])->name('admin.satuan-kerja.swakelola');
    Route::put('/admin/satuan-kerja/lelang/{id}', [SatkerController::class, 'lelang'])->name('admin.satuan-kerja.lelang');
    Route::get('/admin/satuan-kerja/reload', [SatkerController::class, 'reload'])->name('admin.satuan-kerja.reload');
    Route::resource('/admin/satuan-kerja', SatkerController::class)->names('admin.satuan-kerja')->except(['create','store','show','destroy']);;
    
    
    // Tender LPSE
    Route::get('/admin/tender-lpse/fokus/{tender}', [TenderController::class, 'fokus'])->name('admin.tender-lpse.fokus');
    Route::post('/admin/tender-lpse/bulk-delete', [TenderController::class, 'bulkDelete'])->name('admin.tender-lpse.bulk-delete');
    Route::resource('/admin/tender-lpse', TenderController::class)->names('admin.tender-lpse')->except(['create','store','show','edit','update','destroy']);;

    // Blog, Category, Role, Tag
    Route::resource('/admin/blog', BlogController::class)->names('admin.blog')->except(['show']);;
    Route::post('/admin/category/update-orders', [CategoryController::class, 'updateOrders'])->name('admin.category.update.orders');
    Route::resource('/admin/category', CategoryController::class)->names('admin.category');
    Route::resource('/admin/role', RoleController::class)->names('admin.role');
    Route::resource('/admin/tag', TagController::class)->names('admin.tag');
    Route::get('/get-states', [UserController::class,'getStates'])->name('admin.user.get-states');

    // User Group
    Route::resource('/admin/user/group', UserGroupController::class)->names('admin.user.group');

    // User
    Route::put('/admin/user/status/{id}', [UserController::class,'status'])->name('admin.user.status');
    Route::put('/admin/user/update-image/{user}', [UserController::class,'updateImage'])->name('admin.user.update-image');
    Route::get('/admin/user/remove-image/{id}', [UserController::class,'removeImage'])->name('admin.user.removeImage');
    Route::put('/admin/user/update-profile/{user}', [UserController::class,'updateProfile'])->name('admin.user.update-profile');
    Route::resource('/admin/user', UserController::class)->names('admin.user');

    // Komisi
    Route::put('/admin/komisi/status/{komisi}', [KomisiController::class, 'status'])->name('admin.komisi.status');
    Route::post('/admin/komisi/bulk-delete', [KomisiController::class, 'bulkDelete'])->name('admin.komisi.bulk-delete');
    Route::resource('/admin/laporan/komisi', KomisiController::class)->names('admin.laporan.komisi')->except(['create','store','show','edit','update']);

    // Keuangan
    Route::get('/admin/laporan/keuangan', [KeuanganController::class, 'index'])->name('admin.laporan.keuangan');

    //  Pengumuman
    Route::put('/admin/pengumuman/status/{id}', [PengumumanController::class, 'status'])->name('admin.pengumuman.status');
    Route::post('/admin/pengumuman/bulk-delete', [PengumumanController::class, 'bulkDelete'])->name('admin.pengumuman.bulk-delete');
    Route::resource('/admin/pengumuman', PengumumanController::class)->names('admin.pengumuman')->except(['show']);
    
    // Error log
    Route::post('/admin/errorlog/bulk-delete', [ErrorLogController::class, 'bulkDelete'])->name('admin.errorlog.bulk-delete');
    Route::resource('/admin/errorlog', ErrorLogController::class)->names('admin.errorlog')->except(['create','edit','update','show','store']);

    // Whatsapp Gateway
    Route::get('admin/whatsapp/sessions', [WhatsappController::class, 'sessions'])->name('admin.whatsapp.sessions');
    Route::get('admin/whatsapp/sessions/data', [WhatsappController::class, 'sessionsData'])->name('admin.whatsapp.sessions.data');
    Route::get('admin/whatsapp/login/{sessionId}', [WhatsappController::class, 'login'])->name('admin.whatsapp.login');
    Route::get('admin/whatsapp/logout/{sessionId}', [WhatsappController::class, 'logout'])->name('admin.whatsapp.logout');
    Route::get('admin/whatsapp/qr/{sessionId}', [WhatsappController::class, 'qr'])->name('admin.whatsapp.qr');
    Route::get('admin/whatsapp/send/{sessionId}', [WhatsappController::class, 'sendForm'])->name('admin.whatsapp.send.form');
    Route::post('admin/whatsapp/send/{sessionId}', [WhatsappController::class, 'send'])->name('admin.whatsapp.send');
    Route::resource('/admin/whatsapp', WhatsappController::class)->names('admin.whatsapp');
});