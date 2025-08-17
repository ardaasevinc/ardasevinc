<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'desc',
        'item1',
        'item2',
        'item3',
        'item4',
        'desc1',
        'desc2',
        'desc3',
        'number',
        'number_title',
        'is_published',
    ];
}
