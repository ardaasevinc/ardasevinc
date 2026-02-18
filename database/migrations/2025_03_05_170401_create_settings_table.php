<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Site Genel Durumu
            $table->string('site_name')->nullable();
            $table->boolean('maintenance_mode')->default(false); // Bakım modu anahtarı

            // İletişim ve Adres
            $table->text('work_time')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_formatted')->nullable(); // Tıklanabilir olmayan, süslü görünen tel
            $table->string('whatsapp')->nullable(); // Direkt WhatsApp butonu için
            $table->string('email')->nullable();
            $table->string('slogan')->nullable();

            // Görseller
            $table->string('logo_light')->nullable();
            $table->string('logo_dark')->nullable();
            $table->string('favicon')->nullable();
            $table->string('og_image')->nullable(); // Sosyal medyada paylaşınca çıkan önizleme resmi

            // Harita ve Sosyal
            $table->text('map_iframe')->nullable();
            $table->text('map_link')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();

            // SEO & Analytics
            $table->string('meta_title')->nullable();
            $table->text('meta_desc')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('google_analytics_code')->nullable();
            $table->text('facebook_pixel_code')->nullable();

            // Özel Kod Alanları (Admin panelden canlı destek, takip kodu vb. eklemek için)
            $table->text('header_scripts')->nullable(); // <head> içine
            $table->text('body_scripts')->nullable();   // <body> başlangıcına
            $table->text('footer_scripts')->nullable(); // </body> bitimine

            // ENV / Teknik Ayarlar
            $table->string('app_env')->default('local');
            $table->string('app_url')->nullable();
            $table->boolean('app_debug')->default(true);
            $table->string('instagram_access_token')->nullable();

            // Mail Ayarları
            $table->string('mail_mailer')->default('smtp');
            $table->string('mail_host')->nullable();
            $table->string('mail_port')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_encryption')->nullable(); // tls veya ssl
            $table->string('mail_from_address')->nullable();
            $table->string('mail_from_name')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};