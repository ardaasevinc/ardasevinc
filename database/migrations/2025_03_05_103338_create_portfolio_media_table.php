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
        Schema::create('portfolio_media', function (Blueprint $table) {
            $table->id();
            
            // Portfolyo ilişkisi
            // index() ekleyerek sorguları hızlandırdık
            $table->foreignId('portfolio_post_id')
                  ->index()
                  ->constrained('portfolio_posts')
                  ->onDelete('cascade');
            
            // Medya dosya yolu
            $table->string('media_path');

            // Sıralama sütunu (Sürükle-bırak sıralama için)
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_media');
    }
};