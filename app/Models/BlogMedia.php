<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogMedia extends Model
{
    use HasFactory;

    // Tablo ismi otomatik olarak 'blog_media' olarak algılanacaktır.
    
    protected $fillable = [
        'blog_post_id',
        'image',
        'sort_order', // Sıralama için eklendi
    ];

    protected $casts = [
        'blog_post_id' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Medya dosyasının tam URL'ini döndüren yardımcı metod.
     * View kısmında {{ $media->image_url }} şeklinde kullanılabilir.
     */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }

    /**
     * İlişki: Bu medya hangi blog yazısına ait?
     */
    public function blogPost(): BelongsTo
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }
}