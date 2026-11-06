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
        Schema::create('outboxes', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('status')->default(0)->comment('0 belum dikirim, 1 sudah dikirim, 2 gagal dikirim');
            $table->string('recipient');
            $table->string('message');
            $table->string('channel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outboxes');
    }
};
