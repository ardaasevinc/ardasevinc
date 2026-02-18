<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PortfolioCategory extends Model
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
     * Model Boot İşlemleri
     */
    protected static function boot()
    {
        parent::boot();

        // Kategori oluşturulurken slug boşsa otomatik üret
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * İlişki: Bu kategoriye ait projeler
     * Filament'teki counts('projects') ile tam uyumlu olması için isim 'projects' yapıldı.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(PortfolioPost::class, 'portfolio_category_id')
                    ->orderBy('sort_order', 'asc');
    }

    /**
     * Scope: Sadece yayında olan kategorileri sıralı getir
     */
    public function scopeActive($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order', 'asc');
    }
}