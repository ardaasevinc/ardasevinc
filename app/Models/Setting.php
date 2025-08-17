<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class Setting extends Model
{
    use HasFactory;

    protected $casts = [
        'value' => 'array', // `value` alanı artık JSON olarak saklanacak ve `array` olarak işlenecek.
    ];



    protected $fillable = ['key', 'value'];

    /**
     * Verilen ayarı getir.
     */
    public static function get(string $key, $default = null)
    {
        return self::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Ayarı güncelle ve .env dosyasına yansıt
     */
    public static function set(string $key, $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        self::updateEnv($key, $value);
    }

    /**
     * .env dosyasını güncelle ve Laravel config'lerini temizle
     */
    private static function updateEnv($key, $value)
    {
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);

        // Eğer key varsa güncelle, yoksa ekle
        if (strpos($envContent, "{$key}=") !== false) {
            $envContent = preg_replace("/^{$key}=.*/m", "{$key}=\"{$value}\"", $envContent);
        } else {
            $envContent .= "\n{$key}=\"{$value}\"";
        }

        file_put_contents($envPath, $envContent);

        // Laravel önbelleğini temizle ve yeni config'leri yükle
        Artisan::call('config:clear');
        Artisan::call('config:cache');

        // Yeni ayarları Laravel'e yansıt
        $_ENV[$key] = $value;
        putenv("{$key}={$value}");
        config(["app.{$key}" => $value]);
    }
}
