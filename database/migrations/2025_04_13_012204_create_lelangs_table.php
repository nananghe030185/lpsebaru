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
        Schema::create('lelangs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_rup');
            $table->integer('id_bulan');
            $table->string('id_jenispengadaan');
            $table->string('id_klpdi');
            $table->string('id_metode');
            $table->string('id_satker');
            $table->string('id_referensi');
            $table->string('id_lokasi');
            $table->boolean('is_pdn');
            $table->boolean('is_umk');
            $table->string('jenis_pengadaan');
            $table->string('klpdi');
            $table->string('lokasi');
            $table->string('metode');
            $table->double('pagu');
            $table->text('nama_paket',500);
            $table->string('slug',500);
            $table->boolean('pds');
            $table->string('pemilihan');
            $table->string('satuan_kerja');
            $table->string('sumber_dana');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lelangs');
    }
};
