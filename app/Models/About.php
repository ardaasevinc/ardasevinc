<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'top_title',
        'title',
        'desc1',
        'desc2',
        'image',
        'video_url',
        'vision',
        'mission',
        'sort_order',
        'is_published',
    ];

    /**
     * Model özellikleri ve cast işlemleri
     */
    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Bir kayıt aktif olduğunda diğerlerini otomatik pasif yap
     */
    protected static function boot()
    {
        parent::boot();

        // saving: Hem create hem update işlemlerinde çalışır
        static::saving(function ($about) {
            if ($about->is_published) {
                // Kendi ID'si hariç (eğer ID varsa) diğerlerini pasif yap
                // query() kullanımı static çağrılarda daha temizdir
                static::query()
                    ->where('id', '!=', $about->id)
                    ->update(['is_published' => false]);
            }
        });
    }

    /**
     * Sadece yayında olan kaydı getiren Scope (Örn: About::active()->first())
     */
    public function scopeActive($query)
    {
        return $query->where('is_published', true);
    }
}