<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'loop_text',
        'button_text',
        'button_url',
        'image',
        'bg_image',
        'extra_word',
        'sort_order',
        'is_published',
    ];

    /**
     * Veri tipi dönüşümleri
     */
    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Model Boot İşlemleri
     */
    protected static function boot()
    {
        parent::boot();

        // Bir kayıt yayınlandığında diğerlerini otomatik pasif yap
        static::saving(function ($hero) {
            if ($hero->is_published) {
                // query() kullanımı static çağrılarda daha güvenli ve temizdir
                static::query()
                    ->where('id', '!=', $hero->id)
                    ->update(['is_published' => false]);
            }
        });
    }

    /**
     * Scope: Sadece yayında olan kahraman alanını getir
     * Kullanım: Hero::active()->first()
     */
    public function scopeActive($query)
    {
        return $query->where('is_published', true);
    }
}