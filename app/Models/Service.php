<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'icon',           // Görsel veya ikon sınıfı için
        'desc',
        'item1', 'item2', 'item3', 'item4',
        'desc1', 'desc2', 'desc3',
        'number',         // Hizmet istatistiği (Örn: 100% Memnuniyet)
        'number_title',
        'sort_order',     // Sıralama
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * URL'lerde ID yerine slug kullanılması için
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Model Olayları (Boot)
     */
    protected static function booted(): void
    {
        static::creating(function (Service $service) {
            if (empty($service->slug)) {
                $service->slug = self::generateUniqueSlug($service->title);
            }
        });

        static::updating(function (Service $service) {
            // Başlık değişmişse ve kullanıcı elle slug girmemişse slug'ı güncelle
            if ($service->isDirty('title') && !$service->isDirty('slug')) {
                $service->slug = self::generateUniqueSlug($service->title, $service->id);
            }
        });
    }

    /**
     * Benzersiz Slug Oluşturucu
     */
    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'hizmet';
        $slug = $base;
        $i = 1;

        while (static::query()
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    /**
     * Scope: Sadece yayında olan hizmetleri sıralı getir
     */
    public function scopeActive($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order', 'asc');
    }
}