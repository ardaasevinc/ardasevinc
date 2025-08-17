<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PortfolioCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_published',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(PortfolioPost::class);
    }
}
