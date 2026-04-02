<?php

use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\WhatsappController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/invoice/checkout', [InvoiceController::class, 'checkout'])->name('invoice.checkout');
Route::post('/invoice/webhook', [InvoiceController::class, 'webhook'])->name('invoice.webhook');

// send message
Route::post('/whatsapp/send-message', [WhatsappController::class, 'send'])->name('whatsapp.sendMessage');
