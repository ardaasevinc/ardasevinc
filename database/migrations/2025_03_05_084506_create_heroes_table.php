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
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            
            // Metin Alanları
            $table->string('title')->nullable(); // Ana başlık
            $table->string('subtitle')->nullable(); // Alt başlık veya üst metin
            $table->text('loop_text')->nullable(); // Dönen/Değişen metinler (JSON veya virgülle ayrılmış olabilir)
            
            // Buton ve Linkler (Genelde Hero'da bir aksiyon butonu olur)
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            
            // Görseller
            // Tek bir ana görsel yerine bazen mobil/masaüstü ayrımı gerekebilir
            $table->string('image')->nullable(); 
            $table->string('bg_image')->nullable(); // Arka plan görseli
            
            // Durum ve Sıralama
            $table->integer('sort_order')->default(0); // Slaytların sırası
            $table->boolean('is_published')->default(false);
            
            // İhtiyaca göre ekstra "kelimeler" veya "özellikler" için JSON kullanmak daha mantıklı olabilir
            // Ama senin yapına sadık kalarak opsiyonel alanlar bırakıyorum
            $table->string('extra_word')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};