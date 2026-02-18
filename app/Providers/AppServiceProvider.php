<?php

namespace App\Providers;

use App\Models\BlogPost;
use App\Models\Hero;
use App\Models\Setting;
use Carbon\Carbon;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1. MAKRO TANIMI
    FileUpload::macro('toWebp', function () {
    /** @var FileUpload $this */
    return $this->saveUploadedFileUsing(function ($file, $component) {
        $extension = strtolower($file->getClientOriginalExtension());
        // Directory null gelirse boş string yerine 'files' gibi bir varsayılan atayalım
        $directory = $component->getDirectory() ?? 'general'; 
        $filename = Str::random(40);
        
        // public/uploads/hero/
        $uploadFolder = public_path('uploads/' . $directory . '/');

        if (!file_exists($uploadFolder)) {
            mkdir($uploadFolder, 0775, true);
        }

        if ($extension === 'svg') {
            $finalName = $filename . '.svg';
            copy($file->getRealPath(), $uploadFolder . $finalName);
        } else {
            $finalName = $filename . '.webp';
            // Intervention Image v3
            Image::read($file)
                ->toWebp(80)
                ->save($uploadFolder . $finalName);
        }

        // DİKKAT: Burası veritabanına yazılan kısımdır. 
        // uploads diskinin root'u zaten public/uploads olduğu için
        // sadece 'directory/filename.webp' dönmeliyiz.
        return $directory . '/' . $finalName;
    });
});

        // Locale Ayarları
        Carbon::setLocale('tr');
        App::setLocale('tr');

        // Console (migration, refresh vs.) sırasında veritabanı sorgularını çalıştırma
        if (App::runningInConsole()) {
            return;
        }

        try {
            /**
             * SETTINGS - Cache Kaldırıldı
             */
            if (Schema::hasTable('settings')) {
                $settings = Setting::first() ?? new Setting();
                View::share('settings', $settings);
            }

            /**
             * HERO (BANNER) - Cache Kaldırıldı
             */
            if (Schema::hasTable('heroes')) {
                $hero = Hero::where('is_published', true)->orderBy('id', 'desc')->first();
                View::share('hero', $hero);
            }

            /**
             * BLOG MENU - Cache Kaldırıldı
             */
            if (Schema::hasTable('blog_posts')) {
                $blogMenu = BlogPost::query()
                    ->select(['id', 'title', 'slug', 'created_at', 'is_published', 'sort_order'])
                    ->where('is_published', true)
                    ->orderBy('sort_order', 'asc')
                    ->latest()
                    ->limit(5)
                    ->get();
                View::share('blog_menu', $blogMenu);
            }

        } catch (\Exception $e) {
            Log::warning("AppServiceProvider veritabanı yükleme hatası: " . $e->getMessage());
        }
    }
}