<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\{File, Log, Cache, Artisan};

class Setting extends Model
{
    protected $guarded = ['id'];

    /**
     * Veri tipi dönüşümleri
     */
    protected $casts = [
        'app_debug' => 'boolean',
        'maintenance_mode' => 'boolean',
    ];

    protected static function booted()
    {
        static::saved(function ($setting) {
            // .env mapping: Veritabanı sütun isimleri soldaki ENV anahtarlarına atanır
            $envMapping = [
                'APP_URL'               => $setting->app_url,
                'APP_ENV'               => $setting->app_env,
                'APP_DEBUG'             => $setting->app_debug ? 'true' : 'false',
                'MAIL_MAILER'           => $setting->mail_mailer ?? 'smtp',
                'MAIL_HOST'             => $setting->mail_host,
                'MAIL_PORT'             => $setting->mail_port,
                'MAIL_USERNAME'         => $setting->mail_username,
                'MAIL_PASSWORD'         => $setting->mail_password,
                'MAIL_ENCRYPTION'       => $setting->mail_encryption,
                'MAIL_FROM_ADDRESS'     => $setting->mail_from_address,
                'MAIL_FROM_NAME'        => $setting->mail_from_name,
                'FACEBOOK_PIXEL_ID'     => $setting->facebook_pixel_code,
                'GOOGLE_ANALYTICS_ID'   => $setting->google_analytics_code,
                'INSTAGRAM_ACCESS_TOKEN'=> $setting->instagram_access_token,
            ];

            try {
                $envPath = base_path('.env');
                if (File::exists($envPath)) {
                    $content = File::get($envPath);

                    foreach ($envMapping as $key => $value) {
                        $value = $value ?? '';
                        // Değeri tırnak içine al ve tırnakları kaçır
                        $safeValue = '"' . str_replace('"', '\"', $value) . '"';
                        
                        $pattern = "/^{$key}=.*/m";

                        if (preg_match($pattern, $content)) {
                            $content = preg_replace($pattern, "{$key}={$safeValue}", $content);
                        } else {
                            // Eğer anahtar yoksa, dosyanın sonuna yeni satırla ekle
                            $content = rtrim($content) . "\n{$key}={$safeValue}";
                        }
                    }

                    File::put($envPath, rtrim($content) . "\n");

                    // KRİTİK: Config cache varsa temizle, yoksa yeni .env değerleri okunmaz
                    if (app()->environment() !== 'local') {
                        Artisan::call('config:clear');
                    }
                }
            } catch (\Exception $e) {
                Log::error("Setting Model - ENV Yazım Hatası: " . $e->getMessage());
            }
        });
    }

    /**
     * Instagram gönderilerini çeker.
     * file_get_contents yerine daha profesyonel olan Http Client (Guzzle) önerilir 
     * ancak basitlik adına bu yapıyı optimize ettik.
     */
    public function getInstagramPosts($limit = 6)
    {
        // Önce veritabanına bak, yoksa config'e (env) bak
        $token = $this->instagram_access_token ?: config('services.instagram.token');

        if (!$token) {
            return [];
        }

        return Cache::remember('insta_posts', 3600, function () use ($token, $limit) {
            try {
                $url = "https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,thumbnail_url,timestamp&access_token={$token}";
                
                $response = @file_get_contents($url);
                
                if ($response === false) {
                    return [];
                }

                $data = json_decode($response, true);
                return array_slice($data['data'] ?? [], 0, $limit);
            } catch (\Exception $e) {
                Log::warning("Instagram API Hatası: " . $e->getMessage());
                return [];
            }
        });
    }
}