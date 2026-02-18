<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_category_id',
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
        'blog_category_id' => 'integer',
    ];

    /**
     * Model Boot İşlemleri
     */
    protected static function booted(): void
    {
        // Kayıt oluşturulurken slug boşsa otomatik üret
        static::creating(function (BlogPost $post) {
            if (empty($post->slug)) {
                $post->slug = self::generateUniqueSlug($post->title);
            }
        });

        // Güncellenirken başlık değişmişse ve yeni slug verilmemişse güncelle
        static::updating(function (BlogPost $post) {
            if ($post->isDirty('title') && !$post->isDirty('slug')) {
                $post->slug = self::generateUniqueSlug($post->title, $post->id);
            }
        });
    }

    /**
     * Benzersiz Slug Üretici
     */
    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title) ?: 'blog-post';
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    /**
     * İlişki: Blog Kategorisi
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    /**
     * İlişki: Galeri Resimleri (Sıralı)
     */
    public function media(): HasMany
    {
        return $this->hasMany(BlogMedia::class, 'blog_post_id')->orderBy('sort_order', 'asc');
    }

    /**
     * Scope: Sadece yayında olanlar
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order', 'asc');
    }
}