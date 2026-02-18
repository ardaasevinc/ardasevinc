<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portfolio_categories', function (Blueprint $table) {
            $table->id();
            
            // Kategori adı
            $table->string('name');
            
            // URL uyumlu isim (Örn: web-tasarim)
            $table->string('slug')->unique();
            
            // Manuel sıralama (Menü dizilimi için)
            $table->integer('sort_order')->default(0);
            
            // Yayın durumu
            $table->boolean('is_published')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_categories');
    }
};