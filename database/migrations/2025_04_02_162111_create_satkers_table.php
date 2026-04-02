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
        Schema::create('satkers', function (Blueprint $table) {
            $table->id();
            $table->boolean('lelang')->nullable(false)->default(false);
            $table->boolean('swakelola')->nullable(false)->default(false);
            $table->string('kode_satker')->unique();
            $table->string('kode_klpd');
            $table->string('nama_satker');
            $table->integer('penyedia_paket')->default(0);
            $table->integer('penyedia_pagu')->default(0);
            $table->integer('swakelola_paket')->default(0);
            $table->integer('swakelola_pagu')->default(0);
            $table->integer('penyedia_dalam_swakelola_paket')->default(0);
            $table->integer('penyedia_dalam_swakelola_pagu')->default(0);
            $table->integer('total_paket')->default(0);
            $table->integer('total_pagu')->default(0);
            $table->timestamps();

            $table->index(['kode_satker', 'kode_klpd', 'nama_satker']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satkers');
    }
};
