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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            
            // "10+", "500+" gibi değerler yazabilmek için string yaptık
            $table->string('number'); 
            
            // "Yıllık Tecrübe", "Tamamlanan Proje" gibi başlıklar
            $table->string('number_title'); 

            // Sayaçların yanındaki ikon (Örn: fa fa-user)
            $table->string('icon')->nullable();

            // Web sitesindeki diziliş sırası
            $table->integer('sort_order')->default(0);

            // Yayın durumu
            $table->boolean('is_published')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};