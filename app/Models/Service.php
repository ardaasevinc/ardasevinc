<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'desc',
        'item1','item2','item3','item4',
        'desc1','desc2','desc3',
        'number','number_title',
        'is_published',
        'slug', // 🔥
    ];

    // Route Model Binding için slug kullan
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (Service $m) {
            if (empty($m->slug)) {
                $m->slug = static::uniqueSlug($m->title);
            }
        });

        static::updating(function (Service $m) {
            // Başlık değiştiyse ve manuel slug verilmemişse yeniden üret
            if ($m->isDirty('title') && empty($m->slug)) {
                $m->slug = static::uniqueSlug($m->title, $m->id);
            }
        });
    }

    protected static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'service';
        $slug = $base; $i = 1;

        while (static::query()
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
