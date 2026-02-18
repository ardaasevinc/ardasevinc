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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            
            // Başlıklar
            $table->string('top_title')->nullable(); // Slogan veya üst küçük başlık
            $table->string('title')->nullable();     // Ana büyük başlık
            
            // İçerik Alanları
            $table->text('desc1')->nullable(); // Kısa özet veya giriş
            $table->text('desc2')->nullable(); // Detaylı metin
            
            // Görsel Alanları (Hakkımızda sayfası görselsiz olmaz)
            $table->string('image')->nullable();
            $table->string('video_url')->nullable(); // Tanıtım videosu linki için
            
            // Ekstra Özellikler (Opsiyonel: Vizyon, Misyon gibi)
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();

            // Sıralama ve Yayın Durumu
            $table->integer('sort_order')->default(0); 
            $table->boolean('is_published')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};