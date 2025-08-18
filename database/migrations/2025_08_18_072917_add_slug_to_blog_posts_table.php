<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Kolonu nullable ekle
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
        });

        // 2) Mevcut kayıtlar için benzersiz slug doldur
        $rows = DB::table('blog_posts')->select('id', 'title')->orderBy('id')->get();
        foreach ($rows as $row) {
            $base = Str::slug($row->title ?? '') ?: 'yazi-'.$row->id;
            $slug = $base;
            $i = 1;
            while (DB::table('blog_posts')->where('slug', $slug)->exists()) {
                $slug = $base.'-'.$i++;
            }
            DB::table('blog_posts')->where('id', $row->id)->update(['slug' => $slug]);
        }

        // 3) NOT NULL + UNIQUE yap (DBAL gerekmeden)
        DB::statement('ALTER TABLE blog_posts MODIFY slug VARCHAR(255) NOT NULL');
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
