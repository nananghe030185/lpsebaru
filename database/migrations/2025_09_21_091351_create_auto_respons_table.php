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
        Schema::create('auto_respons', function (Blueprint $table) {
            $table->id();
            $table->string('keyword');
            $table->text('response');
            $table->boolean('status')->default(1)->comment('1=active,0=inactive');
            $table->boolean('whatsapp')->default(1)->comment('1=active,0=inactive');
            $table->boolean('telegram')->default(1)->comment('1=active,0=inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_respons');
    }
};
