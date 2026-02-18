<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioMedia extends Model
{
    use HasFactory;

    // Tablo adını açıkça belirtmek iyidir (Eğer standart dışıysa gerekebilir)
    protected $table = 'portfolio_media';

    protected $fillable = [
        'portfolio_post_id',
        'media_path',
        'sort_order', // Sıralama için eklendi
    ];

    protected $casts = [
        'portfolio_post_id' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Resmin tam URL'ini döndüren yardımcı metod (Accessor).
     * Blade içinde {{ $media->full_url }} şeklinde kullanılabilir.
     */
    public function getFullUrlAttribute(): string
    {
        return asset('storage/' . $this->media_path);
    }

    /**
     * İlişki: Bu medya hangi portfolyo projesine ait?
     */
    public function portfolioPost(): BelongsTo
    {
        return $this->belongsTo(PortfolioPost::class, 'portfolio_post_id');
    }
}