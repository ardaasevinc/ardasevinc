<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    // Tablo adı zaten 'experiences' ise bunu belirtmeye gerek yoktur (Laravel standardı)
    // Ancak farklı bir isimse kalabilir.

    protected $fillable = [
        'number',        // Örn: 10, 500, 100%
        'number_title',  // Örn: Yıllık Tecrübe, Mutlu Müşteri
        'icon',          // FontAwesome klası veya ikon yolu
        'sort_order',    // Sıralama
        'is_published',  // Yayın durumu
    ];

    /**
     * Veri Tipi Dönüşümleri
     */
    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope: Sadece yayında olanları sıralı getir
     * Kullanım: Experience::active()->get()
     */
    public function scopeActive($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order', 'asc');
    }
}