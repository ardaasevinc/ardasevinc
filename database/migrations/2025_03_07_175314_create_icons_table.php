<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('icons', function (Blueprint $table) { // Yeni tablo adı burada
            $table->id();
            $table->string('icon')->nullable(); // İkon dosyası için
            $table->string('title')->nullable(); // Başlık
            $table->text('desc')->nullable(); // Açıklama
            $table->boolean('is_published')->default(false); // Yayınlanma durumu
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('icons');
    }
};

