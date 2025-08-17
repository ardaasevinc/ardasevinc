<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_post_id',
        'image',
    ];

    public function blogPost(): BelongsTo
    {
        return $this->belongsTo(BlogPost::class);
    }
}
