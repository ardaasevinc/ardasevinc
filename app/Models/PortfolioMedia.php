<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_post_id',
        'media_path',
    ];

    public function portfolioPost(): BelongsTo
    {
        return $this->belongsTo(PortfolioPost::class, 'portfolio_post_id'); // ✅ Doğru ilişki
    }
}
