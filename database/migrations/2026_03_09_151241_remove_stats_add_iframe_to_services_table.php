<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $blueprint) {
            // Eski istatistik alanlarını kaldırıyoruz
            $blueprint->dropColumn(['number', 'number_title']);

            // Yeni iframe alanını ekliyoruz (nullable olması güvenli olur)
            $blueprint->text('iframe')->nullable()->after('desc3');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $blueprint) {
            $blueprint->integer('number')->nullable();
            $blueprint->string('number_title')->nullable();
            $blueprint->dropColumn('iframe');
        });
    }
};
