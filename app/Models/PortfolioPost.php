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
        'img1',
        'img2',
        'title',
        'desc',
        'is_published',
        'slug', // 🔥
    ];

    // Route Model Binding için slug kullan
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (PortfolioPost $m) {
            if (empty($m->slug)) {
                $m->slug = static::uniqueSlug($m->title);
            }
        });

        static::updating(function (PortfolioPost $m) {
            if ($m->isDirty('title') && empty($m->slug)) {
                $m->slug = static::uniqueSlug($m->title, $m->id);
            }
        });
    }

    protected static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'portfolio';
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

 public function category()
{
    return $this->belongsTo(\App\Models\PortfolioCategory::class, 'portfolio_category_id');
}


    public function media(): HasMany
    {
        return $this->hasMany(PortfolioMedia::class, 'portfolio_post_id');
    }


}
