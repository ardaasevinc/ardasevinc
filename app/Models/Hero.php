<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $fillable = [
        'loop_text',
        'top_text',
        'bottom_text',
        'img1',
        'img2',
        'img3',
        'img4',
        'img5',
        'word1',
        'word2',
        'word3',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}