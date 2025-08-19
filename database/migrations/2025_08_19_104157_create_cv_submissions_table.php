<?php


// Migration: database/migrations/2025_08_19_000000_create_cv_submissions_table.php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
public function up(): void
{
Schema::create('cv_submissions', function (Blueprint $table) {
$table->id();
$table->string('name');
$table->string('email');
$table->string('phone')->nullable();
$table->date('birth_date')->nullable();
$table->string('photo_path')->nullable();
$table->text('career_goal')->nullable();
$table->json('education')->nullable();
$table->json('experience')->nullable();
$table->json('languages')->nullable();
$table->json('certificates')->nullable();
$table->text('hobbies')->nullable();
$table->text('references')->nullable();
$table->timestamps();
});
}


public function down(): void
{
Schema::dropIfExists('cv_submissions');
}
};