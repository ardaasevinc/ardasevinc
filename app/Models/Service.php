<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'icon',
        'desc',
        'item1', 'item2', 'item3', 'item4',
        'desc1', 'desc2', 'desc3',
        'number',
        'number_title',
        'sort_order',
        'is_published',

        // SEO
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
        'number' => 'integer',
    ];

    /**
     * Route model binding için slug kullanmaya devam ediyoruz.
     */
}
