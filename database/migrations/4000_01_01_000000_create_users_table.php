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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('password');
            $table->string('two_factor_secret')->nullable();
            $table->string('email')->unique();
            $table->date('email_verified_at')->nullable();
            $table->integer('group_id')->default(3);
            $table->boolean('status')->default(false);
            $table->integer('system_reserve')->default(0);
            $table->string('perusahaan')->nullable();
            $table->string('kbli', 1000)->nullable();
            $table->string('kata_kunci', 1000)->nullable();
            $table->string('whatsapp')->nullable();
            $table->boolean('notif_whatsapp_tender')->default(false);
            $table->boolean('notif_whatsapp_lelang')->default(false);
            $table->string('telegram')->nullable();
            $table->boolean('notif_telegram_tender')->default(false);
            $table->boolean('notif_telegram_lelang')->default(false);
            $table->boolean('notif_email_tender')->default(false);
            $table->boolean('notif_email_lelang')->default(false);
            $table->string('image')->nullable();
            $table->dateTime('masa_berlaku')->default(now());
            $table->bigInteger('upline')->unsigned()->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            // $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            // $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('upline')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
