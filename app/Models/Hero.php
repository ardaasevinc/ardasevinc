<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;

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

    // Bir kayıt yayınlandığında diğerlerini pasif yap
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($hero) {
            if ($hero->is_published) {
                // Tüm diğer kayıtları pasif hale getir
                static::where('id', '!=', $hero->id)->update(['is_published' => false]);
            }
        });
    }
}
