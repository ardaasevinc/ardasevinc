<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('top_title')->nullable();
            $table->string('title')->nullable();
            $table->text('desc1')->nullable();
            $table->text('desc2')->nullable();
            $table->boolean('is_published')->default(false); // Tek bir satır aktif olabilir
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
