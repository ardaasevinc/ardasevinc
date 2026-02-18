<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscribes', function (Blueprint $table) {
            $table->id();

            // Abone bilgisi
            $table->string('email')->unique()->index();

            // Durum yönetimi
            $table->boolean('is_active')->default(true)->index();
            $table->timestamp('verified_at')->nullable();

            // KVKK & takip
            $table->boolean('kvkk_onay')->default(false);
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            // Abonelik iptali
            $table->timestamp('unsubscribed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribes');
    }
};
