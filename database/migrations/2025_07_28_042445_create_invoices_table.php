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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('nomer');
            $table->timestamp('tanggal_terbit');
            $table->timestamp('tanggal_bayar')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->text('keterangan')->nullable();
            $table->integer('durasi')->nullable();
            $table->decimal('total', 15, 2);
            $table->string('status')->default('unpaid'); // Assuming status can be 'paid', 'unpaid', etc.
            $table->bigInteger('order_id')->default(0);
            $table->string('snap_token')->nullable();
            $table->string('pdf_url')->nullable();
            $table->string('item')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
