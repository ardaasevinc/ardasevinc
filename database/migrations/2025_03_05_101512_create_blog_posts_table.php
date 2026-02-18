<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();

            // category FK
            $table->foreignId('blog_category_id')
                ->constrained('blog_categories')
                ->cascadeOnDelete();

            $table->string('title')->index();
            $table->string('slug')->unique();

            $table->string('img1')->nullable();
            $table->string('img2')->nullable();

            $table->longText('desc')->nullable();

            $table->integer('sort_order')->default(0)->index();
            $table->boolean('is_published')->default(false)->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
