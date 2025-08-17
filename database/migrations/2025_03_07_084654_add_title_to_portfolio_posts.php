<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('portfolio_posts', function (Blueprint $table) {
            $table->string('title')->after('id')->nullable(); // title ekleniyor
        });
    }

    public function down(): void
    {
        Schema::table('portfolio_posts', function (Blueprint $table) {
            $table->dropColumn('title'); // Geri almak için
        });
    }
};
