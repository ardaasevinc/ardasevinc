<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_media', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();

            $table->foreignId('blog_post_id')
                ->constrained('blog_posts')
                ->cascadeOnDelete();

            $table->string('image');

            $table->integer('sort_order')->default(0)->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_media');
    }
};
