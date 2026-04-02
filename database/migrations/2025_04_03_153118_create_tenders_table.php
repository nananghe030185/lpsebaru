<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tender_id');
            $table->bigInteger('lpse_id');
            $table->string('nama_lpse',500);
            $table->string('status_tender')->nullable();
            $table->string('nama_paket',500);
            $table->string('slug');
            $table->double('hps');
            $table->dateTime('tgl_dibuat')->nullable();
            $table->string('tahap_tender');
            $table->string('kategori');
            $table->string('metode_pemilihan');
            $table->string('metode_pengadaan');
            $table->string('metode_evaluasi');
            $table->string('kualifikasi')->nullable();
            $table->string('syarat_kualifikasi')->nullable();
            $table->string('tahun');
            $table->string('nilai_kontrak');

            $table->timestamps();

            $table->index('nama_paket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
