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
        Schema::create('klpdis', function (Blueprint $table) {
            $table->id();
            $table->text('jenis_klpdi');
            $table->text('kode_kabupaten');
            $table->text('kode_klpdi');
            $table->text('kode_provinsi');
            $table->text('nama_klpdi');
            $table->boolean('scrape_daftar_hitam')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klpdis');
    }
};
