<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();

            // Kategori adı
            $table->string('name');

            // SEO & URL için
            $table->string('slug')->unique();

            // Listeleme ve sıralama performansı için
            $table->integer('sort_order')->default(0)->index();

            // Yayın durumu filtreleneceği için index önemli
            $table->boolean('is_published')->default(true)->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};
