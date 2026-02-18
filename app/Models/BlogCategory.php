<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Otomatik Slug Oluşturma
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * İlişki: Kategoriye ait yazılar
     */
    public function posts(): HasMany
    {
        // Yazıları kendi içindeki sıralamasına göre getir
        return $this->hasMany(BlogPost::class)->orderBy('sort_order', 'asc');
    }

    /**
     * Scope: Sadece yayında olanları ve sıralı getir
     */
    public function scopeActive($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order', 'asc');
    }
}