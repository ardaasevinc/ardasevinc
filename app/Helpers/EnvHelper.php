<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;

class EnvHelper
{
    public static function updateEnv($key, $value)
    {
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);

        // Değişken varsa güncelle, yoksa ekle
        if (strpos($envContent, "{$key}=") !== false) {
            $envContent = preg_replace("/^{$key}=.*/m", "{$key}=\"{$value}\"", $envContent);
        } else {
            $envContent .= "\n{$key}=\"{$value}\"";
        }

        file_put_contents($envPath, $envContent);

        // Laravel önbelleğini temizleyerek yeni ayarları yükleyelim
        Artisan::call('config:clear');
        Artisan::call('config:cache');

        // Yeni ayarları .env'den tekrar yükleyelim
        $_ENV[$key] = $value;
        putenv("{$key}={$value}");
        config(["app.{$key}" => $value]);
    }

    


    public static function afterSave($record)
    {
        // Eğer güncellenen key, .env dosyasında da bulunan bir değişkense güncelle
        $envKeys = ['APP_NAME', 'APP_URL', 'APP_DEBUG'];

        if (in_array($record->key, $envKeys)) {
            EnvHelper::updateEnv($record->key, $record->value);

            Notification::make()
                ->title("Ayar Güncellendi")
                ->body("`.env` dosyasındaki `" . $record->key . "` değiştirildi!")
                ->success()
                ->send();
        }
    }
}
