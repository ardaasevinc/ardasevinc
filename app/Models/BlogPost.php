<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class,'blog_category_id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(BlogMedia::class,'blog_post_id','id');
    }
}
