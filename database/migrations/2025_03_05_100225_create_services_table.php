<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
              $table->string('slug')->nullable();
            $table->text('desc')->nullable();
            $table->string('item1')->nullable();
            $table->string('item2')->nullable();
            $table->string('item3')->nullable();
            $table->string('item4')->nullable();
            $table->text('desc1')->nullable();
            $table->text('desc2')->nullable();
            $table->text('desc3')->nullable();
            $table->integer('number')->nullable();
            $table->string('number_title')->nullable();
            $table->boolean('is_published')->default(false); // Birden fazla kayıt aktif olabilir
          
            $table->unique('slug');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
