<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();

            // Gönderen bilgiler
            $table->string('name');
            $table->string('email')->index();
            $table->string('phone')->nullable();

            // Mesaj
            $table->string('subject')->nullable();
            $table->longText('message');

            // Yönetim & takip
            $table->boolean('is_read')->default(false)->index();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
