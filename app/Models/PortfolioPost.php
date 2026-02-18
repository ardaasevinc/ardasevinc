<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PortfolioPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_category_id',
        'title',
        'slug',
        'img1',
        'img2',
        'desc',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
        'portfolio_category_id' => 'integer',
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
        static::creating(function (PortfolioPost $post) {
            if (empty($post->slug)) {
                $post->slug = self::generateUniqueSlug($post->title);
            }
        });

        static::updating(function (PortfolioPost $post) {
            // Başlık değişmişse ve kullanıcı elle slug girmemişse slug'ı güncelle
            if ($post->isDirty('title') && !$post->isDirty('slug')) {
                $post->slug = self::generateUniqueSlug($post->title, $post->id);
            }
        });
    }

    /**
     * Benzersiz Slug Oluşturucu
     */
    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'portfolio-item';
        $slug = $base;
        $i = 1;

        while (static::query()
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
     * İlişki: Portfolyo Kategorisi
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(PortfolioCategory::class, 'portfolio_category_id');
    }

    /**
     * İlişki: Proje Galerisi (Sıralı)
     */
    public function media(): HasMany
    {
        return $this->hasMany(PortfolioMedia::class, 'portfolio_post_id')
                    ->orderBy('sort_order', 'asc');
    }

    /**
     * Scope: Sadece yayında olanları sıralı getir
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order', 'asc');
    }
}