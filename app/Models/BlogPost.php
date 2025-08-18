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
        'img1',
        'img2',
        'title',
        'desc',
        'is_published',
        'slug',
    ];

    protected static function booted(): void
    {
        static::creating(function (BlogPost $post) {
            if (empty($post->slug)) {
                $post->slug = static::uniqueSlug($post->title);
            }
        });

        static::updating(function (BlogPost $post) {
            // Başlık değişmiş ve slug boş/manuel değilse yeniden üretmek istersen:
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = static::uniqueSlug($post->title, $post->id);
            }
        });
    }

    protected static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'yazi';
        $slug = $base;
        $i = 1;

        while (static::query()
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(BlogMedia::class, 'blog_post_id', 'id');
    }
}
