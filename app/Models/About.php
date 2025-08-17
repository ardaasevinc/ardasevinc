<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'top_title',
        'title',
        'desc1',
        'desc2',
        'is_published',
    ];

    // Bir kayıt aktif olduğunda diğerlerini pasif yap
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($about) {
            if ($about->is_published) {
                // Tüm diğer kayıtları pasif hale getir
                static::where('id', '!=', $about->id)->update(['is_published' => false]);
            }
        });
    }
}
