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
        'icon',
        'desc',
        'item1', 'item2', 'item3', 'item4',
        'desc1', 'desc2', 'desc3',
        'number',
        'number_title',
        'sort_order',
        'is_published',

        // SEO
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
        'number' => 'integer',
    ];

    /**
     * Route model binding slug ile çalışsın
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Model Events
     */
    protected static function booted(): void
    {
        static::creating(function (Service $service) {
            if (blank($service->slug)) {
                $service->slug = self::generateUniqueSlug($service->title);
            }
        });

        static::updating(function (Service $service) {
            if ($service->isDirty('title') && !$service->isDirty('slug')) {
                $service->slug = self::generateUniqueSlug($service->title, $service->id);
            }
        });
    }

    /**
     * Unique Slug Generator
     */
    public static function generateUniqueSlug(?string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title ?? '');

        // tamamen boş çıkarsa garanti slug
        if (blank($base)) {
            $base = 'hizmet-' . uniqid();
        }

        $slug = $base;
        $i = 1;

        while (
            static::query()
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    /**
     * Scope: Yayında olanlar
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope: Varsayılan sıralama
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('id');
    }
}