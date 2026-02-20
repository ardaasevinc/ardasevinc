<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {

            $table->id();

            // Temel içerik
            $table->string('title')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->text('desc')->nullable();

            // Liste alanları
            $table->string('item1')->nullable();
            $table->string('item2')->nullable();
            $table->string('item3')->nullable();
            $table->string('item4')->nullable();

            // Alt açıklamalar
            $table->text('desc1')->nullable();
            $table->text('desc2')->nullable();
            $table->text('desc3')->nullable();

            // İstatistik alanı
            $table->integer('number')->nullable();
            $table->string('number_title')->nullable();

            // 🔥 HATA VEREN ALAN
            $table->string('icon')->nullable();

            // CMS kontrol alanları
            $table->integer('sort_order')->default(0);
            $table->boolean('is_published')->default(true);

            // SEO alanları (ileride %100 lazım olacak)
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};