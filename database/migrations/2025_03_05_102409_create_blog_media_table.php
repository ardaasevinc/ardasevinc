<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blog_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_post_id')->constrained()->onDelete('cascade'); // Blog ilişkisi
            $table->string('image'); // Resim dosyası
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_media');
    }
};
