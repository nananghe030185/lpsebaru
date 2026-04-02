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
        Schema::create('lpses', function (Blueprint $table) {
            $table->id();
            $table->boolean('state')->default(true);
            $table->integer('kode_lpse')->unique()->nullable();
            $table->string('nama_lpse');
            $table->string('link')->nullable();
            $table->integer('jumlah_paket')->nullable(false)->default(0);
            $table->double('jumlah_pagu')->nullable(false)->default(0);
            $table->string('slug')->unique()->nullable();
            $table->string('description')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('scrape')->default(false);
            $table->datetimes();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpses');
    }
};
