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
        Schema::create('perangkats', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('number', 100)->unique()->nullable();
            $table->string('name')->unique()->nullable();
            $table->string('description')->nullable();
			$table->string('multidevice', 10)->nullable();
            $table->string('status')->nullable();
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
