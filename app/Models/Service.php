<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * Toplu atama yapılabilecek alanlar.
     * * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'icon',
        'desc',
        'images', // Galeri görselleri (JSON/Array)
        'item1',
        'item2',
        'item3',
        'item4',
        'desc1',
        'desc2',
        'desc3',
        'iframe', // Yeni eklenen iframe alanı
        'sort_order',
        'is_published',

        // SEO Alanları
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * Veritabanından gelen verilerin otomatik dönüştürüleceği tipler.
     * * @var array
     */
    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
        'images' => 'array', // JSON veriyi otomatik diziye çevirir
    ];

    /**
     * Route model binding için ID yerine slug kullanılması.
     * Örn: /hizmet/web-tasarim
     * * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
