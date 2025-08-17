<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(PortfolioCategory::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(PortfolioMedia::class, 'portfolio_post_id'); // ✅ Doğru ilişki
    }
}

