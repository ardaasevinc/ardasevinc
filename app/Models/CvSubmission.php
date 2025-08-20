<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvSubmission extends Model
{
   protected $fillable = [
    'name',
    'email',
    'phone',
    'birth_date',
    'photo_path',
    'career_goal',
    'education',
    'experience',
    'languages',
    'certificates',
    'hobbies',
    'references',
    'kvkk_onay', // ✅ eklendi
];


    protected $casts = [
        'birth_date'   => 'date',
        'education'    => 'array',
        'experience'   => 'array',
        'languages'    => 'array',
        'certificates' => 'array',
    ];
}
