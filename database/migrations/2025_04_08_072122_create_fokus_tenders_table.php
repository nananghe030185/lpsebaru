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
        Schema::create('fokus_tenders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lpse_id');
            $table->bigInteger('user_id');
            $table->bigInteger('tender_id');
            $table->boolean('fokus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fokus_tenders');
    }
};
