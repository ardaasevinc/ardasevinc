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
        Schema::create('portfolio_posts', function (Blueprint $table) {
            $table->id();
            
            // Kategori ilişkisi
            $table->foreignId('portfolio_category_id')
                  ->index()
                  ->constrained('portfolio_categories')
                  ->onDelete('cascade');
            
            // Sütunları istediğin sırayla yazıyoruz (after kullanmaya gerek yok)
            $table->string('title'); 
            $table->string('slug')->unique(); // Tek seferde ve benzersiz tanımladık
            
            $table->string('img1')->nullable();
            $table->string('img2')->nullable();
            $table->text('desc')->nullable();
            
            // Diğer tablolarla uyum için sort_order ekledik
            $table->integer('sort_order')->default(0)->index();
            
            $table->boolean('is_published')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_posts');
    }
};